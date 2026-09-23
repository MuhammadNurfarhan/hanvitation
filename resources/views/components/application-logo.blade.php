@props(['class' => ''])

<svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" {{ $attributes->merge(['class' => $class]) }}>
    <!-- Outer decorative ring -->
    <circle cx="50" cy="50" r="46" fill="none" stroke="currentColor" stroke-width="1.5" opacity="0.3" />

    <!-- Inner ornamental dots -->
    <circle cx="50" cy="8" r="1.5" fill="currentColor" opacity="0.5" />
    <circle cx="50" cy="92" r="1.5" fill="currentColor" opacity="0.5" />
    <circle cx="8" cy="50" r="1.5" fill="currentColor" opacity="0.5" />
    <circle cx="92" cy="50" r="1.5" fill="currentColor" opacity="0.5" />

    <!-- Stylized "H" with serif/elegant touch -->
    <g fill="currentColor">
        <!-- Left vertical stroke -->
        <path d="M 32 28 L 32 72 L 38 72 L 38 53 L 62 53 L 62 72 L 68 72 L 68 28 L 62 28 L 62 47 L 38 47 L 38 28 Z" />
        <!-- Top serif decoration -->
        <rect x="30" y="26" width="10" height="2" rx="1" />
        <rect x="60" y="26" width="10" height="2" rx="1" />
        <!-- Bottom serif decoration -->
        <rect x="30" y="72" width="10" height="2" rx="1" />
        <rect x="60" y="72" width="10" height="2" rx="1" />
    </g>

    <!-- Small heart accent at center -->
    <path d="M 50 60 C 48.5 58.5, 46 58, 46 60 C 46 62, 50 65, 50 65 C 50 65, 54 62, 54 60 C 54 58, 51.5 58.5, 50 60 Z"
        fill="currentColor" opacity="0.8" />
</svg>