<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GuestsTemplateExport implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    /**
     * Contoh data untuk panduan user (opsional)
     */
    public function collection()
    {
        return collect([
            [
                'name' => 'Bapak Farhan Wijaya',
                'phone' => '081234567890',
                'email' => 'farhan@example.com',
                'guest_count' => 2,
            ],
            [
                'name' => 'Ibu Siti Aminah',
                'phone' => '081298765432',
                'email' => 'siti@example.com',
                'guest_count' => 1,
            ],
            [
                'name' => 'Sdr. Ahmad Rizki',
                'phone' => '081345678901',
                'email' => '',
                'guest_count' => 1,
            ],
        ]);
    }

    /**
     * Header kolom - HARUS SAMA dengan validasi di GuestsImport.php
     */
    public function headings(): array
    {
        return [
            'name',          // ✅ Wajib: nama tamu
            'phone',         // ⚪ Opsional: nomor WhatsApp (format: 08xxx atau 628xxx)
            'email',         // ⚪ Opsional: alamat email
            'guest_count',   // ⚪ Opsional: jumlah tamu yang dibawa (default: 1)
        ];
    }

    /**
     * Nama sheet di Excel
     */
    public function title(): string
    {
        return 'Guests Template';
    }

    /**
     * Styling sederhana untuk header
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style header row
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => '7f1d1d']], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'fef3c7']]],
            // Auto-size columns
            'A' => ['width' => 50],
            'B' => [
                'width' => 50,
                'numberFormat' => ['formatCode' => '@'],
            ],
            'C' => ['width' => 50],
            'D' => ['width' => 15],
        ];
    }
}
