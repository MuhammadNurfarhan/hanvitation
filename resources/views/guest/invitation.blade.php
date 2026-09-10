<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Undangan Pernikahan {{ $wedding->groom_name }} & {{ $wedding->bride_name }}">
    <meta name="theme-color" content="#7f1d1d">

    <title>The Wedding of {{ $wedding->groom_first_name }} & {{ $wedding->bride_first_name }}</title>

    {{-- FAVICON & APP ICONS --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <meta name="msapplication-TileColor" content="#7f1d1d">
    <meta name="apple-mobile-web-app-title" content="Hanvitation">
    <meta name="application-name" content="Hanvitation">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Inter:wght@300;400;500;600&family=Great+Vibes&display=swap"
        rel="stylesheet">

    {{-- Tailwind CSS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 0;
            height: 0;
        }

        /* Font Utilities */
        .font-script {
            font-family: 'Great Vibes', cursive;
        }

        .font-serif-custom {
            font-family: 'Playfair Display', serif;
        }

        .font-sans-custom {
            font-family: 'Inter', sans-serif;
        }

        /* Envelope Animation */
        @keyframes envelopeOpen {
            0% {
                transform: translateY(0);
            }

            100% {
                transform: translateY(-20px);
            }
        }

        @keyframes flapOpen {
            0% {
                transform: rotateX(0deg);
            }

            100% {
                transform: rotateX(-180deg);
            }
        }

        @keyframes cardSlide {
            0% {
                transform: translateY(0);
                opacity: 0;
            }

            100% {
                transform: translateY(-40px);
                opacity: 1;
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .envelope-wrapper {
            perspective: 1000px;
        }

        .envelope-body {
            transform-origin: top;
            transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .envelope-open .envelope-flap {
            animation: flapOpen 0.8s ease forwards;
        }

        .envelope-open .invitation-card {
            animation: cardSlide 0.6s ease 0.3s forwards;
        }

        /* Music Button Pulse */
        @keyframes pulseRing {
            0% {
                transform: scale(0.8);
                opacity: 0.5;
            }

            100% {
                transform: scale(1.4);
                opacity: 0;
            }
        }

        .music-pulse::before {
            content: '';
            position: absolute;
            inset: -6px;
            border-radius: 50%;
            border: 2px solid currentColor;
            animation: pulseRing 1.5s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
        }

        /* Smooth Section Transitions */
        .section-fade {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }

        .section-fade.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Glass Effect */
        .glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        /* Gradient Text */
        .text-gradient {
            background: linear-gradient(135deg, #7f1d1d 0%, #b45309 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Safe Area for Mobile */
        .pb-safe {
            padding-bottom: env(safe-area-inset-bottom, 20px);
        }
    </style>
</head>

<body class="font-sans-custom bg-stone-50 text-stone-800 antialiased overflow-x-hidden" x-data="weddingApp()"
    x-init="init()">

    {{-- ============================================
    ENVELOPE OPENING ANIMATION
    ============================================ --}}
    @include('guest.partials.envelope')

    {{-- ============================================
    MAIN INVITATION CONTENT
    ============================================ --}}
    <div x-show="invitationOpened" x-cloak x-transition:enter="transition ease-out duration-700"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="relative">

        {{-- Sticky Header --}}
        @include('guest.partials.header')

        {{-- Cover Section --}}
        @include('guest.partials.cover')

        {{-- Bible Quote --}}
        @include('guest.partials.quote')

        {{-- The Couple --}}
        @include('guest.partials.couple')

        {{-- Wedding Events --}}
        @include('guest.partials.events')

        {{-- Gallery --}}
        {{-- @include('guest.partials.gallery') --}}

        {{-- RSVP --}}
        @include('guest.partials.rsvp')

        {{-- Digital Envelope --}}
        @include('guest.partials.digital-envelope')

        {{-- Guestbook --}}
        @include('guest.partials.guestbook')

        {{-- Closing Message --}}
        @include('guest.partials.closing')

        {{-- Footer --}}
        @include('guest.partials.footer')

        {{-- Bottom Navigation --}}
        @include('guest.partials.bottom-nav')
    </div>

    {{-- Background Music --}}
    <audio id="bgMusic" loop preload="auto">
        @if($wedding->music_file)
        {{-- Prioritas: File Upload dari Storage --}}
        <source src="{{ asset('storage/' . $wedding->music_file) }}" type="audio/mpeg">
        @else
        {{-- 🎵 Default: Musik fallback jika tidak ada upload --}}
        <source src="{{ asset('audio/default-wedding.mp3') }}" type="audio/mpeg">
        @endif
        Your browser does not support the audio element.
    </audio>

    {{-- ============================================
    ALPINE.JS APPLICATION
    ============================================ --}}
    <script>
        function weddingApp() {
            return {
                // State
                invitationOpened: false,
                isPlaying: false,
                showEnvelope: true,
                guestName: '{{ $guestName ?? "" }}',
                countdown: { days: '00', hours: '00', minutes: '00', seconds: '00' },
                activeSection: 'cover',

                // RSVP Form
                rsvpForm: {
                    name: '',
                    attendance: '',
                    guest_count: 1,
                },
                rsvpLoading: false,
                rsvpSubmitted: false,

                // Guestbook - DENGAN PAGINATION
                guestbookMessages: [],
                guestbookLoading: false,
                guestbookForm: {
                    name: '',
                    message: '',
                    attendance_status: ''
                },
                currentPage: 1,
                lastPage: 1,
                hasMorePages: false,
                loadingMore: false,

                // Gallery Slider
                currentSlide: 0,
                galleryImages: [],

                // Notification
                notification: { show: false, message: '', type: 'success' },

                init() {
                    this.startCountdown();
                    this.initScrollObserver();
                    this.loadGuestbook(1);

                    // Parse URL params
                    const params = new URLSearchParams(window.location.search);
                    if (params.has('untuk')) {
                        const nameFromUrl = params.get('untuk');
                        this.guestName = nameFromUrl;
                        this.rsvpForm.name = nameFromUrl;
                        this.guestbookForm.name = nameFromUrl;
                    }

                    // AUTO-SCROLL KE GUESTBOOK SETELAH REFRESH
                    if (sessionStorage.getItem('scroll_to_guestbook') === 'true') {
                        sessionStorage.removeItem('scroll_to_guestbook');
                        setTimeout(() => {
                            const guestbookSection = document.getElementById('guestbook');
                            if (guestbookSection) {
                                guestbookSection.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'start'
                                });
                            }
                        }, 500);
                    }

                    // Check if user already opened (session)
                    if (sessionStorage.getItem('invitation_opened')) {
                        this.openInvitation(true);
                    }
                },

                openInvitation(silent = false) {
                    this.invitationOpened = true;
                    this.showEnvelope = false;
                    sessionStorage.setItem('invitation_opened', 'true');

                    if (!silent) {
                        setTimeout(() => this.playMusic(), 800);
                    }

                    document.body.style.overflow = 'auto';
                },

                toggleMusic() {
                    if (this.isPlaying) {
                        this.pauseMusic();
                    } else {
                        this.playMusic();
                    }
                },

                playMusic() {
                    const audio = document.getElementById('bgMusic');
                    audio.volume = 0.5;
                    audio.play().then(() => {
                        this.isPlaying = true;
                    }).catch(e => {
                        console.log('Autoplay blocked:', e);
                    });
                },

                pauseMusic() {
                    const audio = document.getElementById('bgMusic');
                    audio.pause();
                    this.isPlaying = false;
                },

                startCountdown() {
                    const target = new Date('{{ $wedding->event_date }}').getTime();

                    const update = () => {
                        const now = new Date().getTime();
                        const diff = target - now;

                        if (diff > 0) {
                            this.countdown = {
                                days: String(Math.floor(diff / (1000 * 60 * 60 * 24))).padStart(2, '0'),
                                hours: String(Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0'),
                                minutes: String(Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0'),
                                seconds: String(Math.floor((diff % (1000 * 60)) / 1000)).padStart(2, '0')
                            };
                        } else {
                            this.countdown = { days: '00', hours: '00', minutes: '00', seconds: '00' };
                        }
                    };

                    update();
                    setInterval(update, 1000);
                },

                initScrollObserver() {
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                entry.target.classList.add('visible');
                                const id = entry.target.id;
                                if (id) this.activeSection = id;
                            }
                        });
                    }, { threshold: 0.3 });

                    setTimeout(() => {
                        document.querySelectorAll('.section-fade').forEach(el => observer.observe(el));
                    }, 100);
                },

                scrollToSection(id) {
                    const el = document.getElementById(id);
                    if (el) {
                        el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                },

                // RSVP Methods
                async submitRSVP() {
                    if (!this.rsvpForm.name || !this.rsvpForm.attendance) {
                        this.showNotification('Mohon lengkapi nama dan status kehadiran.', 'error');
                        return;
                    }

                    this.rsvpLoading = true;

                    try {
                        const uniqueCodeInput = document.querySelector('input[name="unique_code"]');
                        const uniqueCode = uniqueCodeInput?.value || '';

                        const response = await fetch('{{ route("guest.rsvp.store", $wedding->slug) }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                ...this.rsvpForm,
                                unique_code: uniqueCode
                            })
                        });

                        const data = await response.json();

                        if (data.success) {
                            this.rsvpSubmitted = true;
                            this.showNotification('Terima kasih! RSVP Anda berhasil dikirim.', 'success');
                            this.rsvpForm = { name: this.rsvpForm.name, attendance: '', guest_count: 1 };
                            this.loadGuestbook(1);
                        } else {
                            this.showNotification(data.message || 'Terjadi kesalahan. Silakan coba lagi.', 'error');
                        }
                    } catch (error) {
                        console.error('RSVP Error:', error);
                        this.showNotification('Terjadi kesalahan jaringan.', 'error');
                    } finally {
                        this.rsvpLoading = false;
                    }
                },

                async loadGuestbook(page = 1) {
                    if (page === 1) {
                        this.guestbookLoading = true;
                    }

                    try {
                        const timestamp = new Date().getTime();
                        const url = `{{ route("guest.guestbook.index", $wedding->slug) }}?page=${page}&t=${timestamp}`;

                        const response = await fetch(url, {
                            headers: {
                                'Accept': 'application/json',
                                'Cache-Control': 'no-cache'
                            }
                        });

                        const data = await response.json();

                        if (data.success) {
                            // Baca dari data.messages (array) dan data.pagination (object)
                            const messages = data.messages || [];
                            const pagination = data.pagination || {};

                            if (page === 1) {
                                // First load - replace all
                                this.guestbookMessages = messages;
                            } else {
                                // Load more - append
                                this.guestbookMessages = [...this.guestbookMessages, ...messages];
                            }

                            // Update pagination state
                            this.currentPage = pagination.current_page || 1;
                            this.lastPage = pagination.last_page || 1;
                            this.hasMorePages = pagination.has_more || false;
                        }
                    } catch (error) {
                        console.error('Guestbook Error:', error);
                    } finally {
                        this.guestbookLoading = false;
                        this.loadingMore = false;
                    }
                },

                async loadMoreMessages() {
                    if (this.loadingMore || !this.hasMorePages) {
                        console.log('⚠️ Cannot load more:', { loadingMore: this.loadingMore, hasMorePages: this.hasMorePages });
                        return;
                    }

                    this.loadingMore = true;
                    const nextPage = this.currentPage + 1;

                    console.log(`🔄 Loading page ${nextPage}...`);
                    await this.loadGuestbook(nextPage);
                },

                async submitGuestbook() {
                    if (!this.guestbookForm.name || !this.guestbookForm.message) {
                        this.showNotification('Mohon lengkapi nama dan ucapan.', 'error');
                        return;
                    }

                    this.guestbookLoading = true;

                    try {
                        const uniqueCodeInput = document.querySelector('input[name="unique_code"]');
                        const uniqueCode = uniqueCodeInput ? uniqueCodeInput.value : '';

                        const response = await fetch('{{ route("guest.guestbook.store", $wedding->slug) }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                ...this.guestbookForm,
                                unique_code: uniqueCode
                            })
                        });

                        const data = await response.json();

                        if (data.success) {
                            this.showNotification('Ucapan berhasil dikirim!', 'success');
                            sessionStorage.setItem('scroll_to_guestbook', 'true');
                            window.location.reload();
                        } else {
                            this.showNotification(data.message || 'Gagal mengirim ucapan.', 'error');
                        }
                    } catch (error) {
                        console.error('Guestbook Error:', error);
                        this.showNotification('Terjadi kesalahan jaringan.', 'error');
                    } finally {
                        this.guestbookLoading = false;
                    }
                },

                // Gallery Methods
                prevSlide() {
                    const images = @json($wedding->gallery->pluck('url')->map(fn($u) => asset('storage/' . $u)));
                    this.currentSlide = (this.currentSlide - 1 + images.length) % images.length;
                },

                nextSlide() {
                    const images = @json($wedding->gallery->pluck('url')->map(fn($u) => asset('storage/' . $u)));
                    this.currentSlide = (this.currentSlide + 1) % images.length;
                },

                goToSlide(index) {
                    this.currentSlide = index;
                },

                // Utility Methods
                copyToClipboard(text, label = '') {
                    navigator.clipboard.writeText(text).then(() => {
                        this.showNotification(`${label} berhasil disalin!`, 'success');
                    }).catch(() => {
                        const ta = document.createElement('textarea');
                        ta.value = text;
                        document.body.appendChild(ta);
                        ta.select();
                        document.execCommand('copy');
                        document.body.removeChild(ta);
                        this.showNotification(`${label} berhasil disalin!`, 'success');
                    });
                },

                addToCalendar() {
                    const date = new Date('{{ $wedding->event_date }}');
                    const title = 'Pernikahan {{ $wedding->groom_first_name }} & {{ $wedding->bride_first_name }}';
                    const location = '{{ $wedding->receptionEvent?->venue_name ?? "" }}';

                    const startDate = date.toISOString().replace(/-|:|\.\d+/g, '');
                    const endDate = new Date(date.getTime() + 4 * 60 * 60 * 1000).toISOString().replace(/-|:|\.\d+/g, '');

                    const url = `https://calendar.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent(title)}&dates=${startDate}/${endDate}&details=${encodeURIComponent('Undangan Digital - Hanvitation')}&location=${encodeURIComponent(location)}`;

                    window.open(url, '_blank');
                },

                showNotification(message, type = 'success') {
                    this.notification = { show: true, message, type };
                    setTimeout(() => {
                        this.notification.show = false;
                    }, 3000);
                }
            };
        }
    </script>
</body>

</html>