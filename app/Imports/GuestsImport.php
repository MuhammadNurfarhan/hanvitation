<?php

namespace App\Imports;

use App\Models\Guest;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithUpserts; // ✅ 1. Import Interface WithUpserts
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\Log;

class GuestsImport implements ToModel, WithHeadingRow, WithMapping, WithValidation, WithBatchInserts, WithChunkReading, WithUpserts
{
    protected $weddingId;
    public $stats = ['imported' => 0, 'updated' => 0, 'total' => 0];

    public function __construct($weddingId) {
        $this->weddingId = $weddingId;
    }

    /**
     * ✅ 2. Mapping data dengan sanitasi header
     */
    public function map($row): array
    {
        // Sanitasi header: bersihkan spasi/karakter khusus
        $sanitized = [];
        foreach ($row as $key => $value) {
            $cleanKey = trim(strtolower(str_replace([' ', '-', '.'], '_', $key)));
            $sanitized[$cleanKey] = $value;
        }

        // Konversi phone ke string (handle Excel numeric)
        $phoneRaw = $sanitized['phone'] ?? null;
        if ($phoneRaw !== null && !is_string($phoneRaw)) {
            $phoneRaw = (string) $phoneRaw;
        }

        return [
            'name' => is_string($sanitized['name'] ?? null) ? trim($sanitized['name']) : null,
            'phone' => $phoneRaw,
            'email' => $sanitized['email'] ?? null,
            'guest_count' => (int) ($sanitized['guest_count'] ?? 1),
        ];
    }

    /**
     * ✅ 3. PENTING: Return NEW Model (JANGAN updateOrCreate)
     * Biarkan WithUpserts yang menangani logika database-nya
     */
    public function model(array $row)
    {
        // Skip jika nama kosong
        if (empty($row['name'])) {
            return null;
        }

        // Format phone
        $phone = $this->formatPhone($row['phone']);

        $uniqueCode = Str::random(8);

        Log::debug('[GuestsImport] Processing', [
            'name' => $row['name'],
            'phone' => $phone,
            'wedding_id' => $this->weddingId,
        ]);

        // ✅ Return instance Guest BARU dengan atribut data saja
        // JANGAN panggil Guest::updateOrCreate() di sini!
        return new Guest([
            'wedding_id' => $this->weddingId,
            'name' => $row['name'],
            'phone' => $phone,
            'email' => $row['email'] ?? null,
            'guest_count' => (int) ($row['guest_count'] ?? 1),
            'unique_code' => $uniqueCode,
            // unique_code akan di-generate otomatis oleh Model Event 'creating'
        ]);
    }

    /**
     * ✅ 4. PENTING: Definisikan kolom unik untuk logika Upsert
     * Jika kombinasi wedding_id + name sudah ada → UPDATE
     * Jika belum ada → INSERT
     */
    public function uniqueBy()
    {
        return ['wedding_id', 'name'];
    }

    /**
     * ✅ 5. Validasi
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|max:20', // Hapus 'string' agar terima numeric dari Excel
            'email' => 'nullable|email|max:255',
            'guest_count' => 'nullable|integer|min:1|max:10',
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'name.required' => 'Kolom Nama wajib diisi',
            'phone.required' => 'Kolom Phone/WhatsApp wajib diisi',
            'phone.max' => 'Nomor phone terlalu panjang (maks 20 digit)',
            'email.email' => 'Format email tidak valid',
        ];
    }

    /**
     * ✅ 6. Helper: Format phone robust
     */
    private function formatPhone(?string $phone): ?string
    {
        if ($phone === null || $phone === '') {
            return null;
        }

        $phone = preg_replace('/[^0-9]/', '', (string) $phone);

        if (empty($phone)) {
            return null;
        }

        if (str_starts_with($phone, '0') && strlen($phone) >= 10) {
            return '62' . substr($phone, 1);
        } elseif (str_starts_with($phone, '62') && strlen($phone) >= 11) {
            return '62' . substr($phone, 2);
        } elseif (strlen($phone) >= 10) {
            return '62' . $phone;
        }

        return null;
    }

    public function batchSize(): int { return 100; }
    public function chunkSize(): int { return 100; }

    /**
     * ✅ 7. Skip empty rows
     */
    public function isEmptyWhen(array $row): bool
    {
        return empty($row['name']) && empty($row['phone']) && empty($row['email']);
    }
}
