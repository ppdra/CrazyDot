<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/@sheaf/rover@latest/dist/cdn.min.js"></script>

    <title>{{ $title ?? config('app.name') }}</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        // Load dark mode before page renders to prevent flicker
        const loadDarkMode = () => {
            const theme = localStorage.getItem('theme') ?? 'system'

            if (
                theme === 'dark' ||
                (theme === 'system' &&
                    window.matchMedia('(prefers-color-scheme: dark)')
                    .matches)
            ) {
                document.documentElement.classList.add('dark')
            }
        }

        // Initialize on page load
        loadDarkMode();

        // Reinitialize after Livewire navigation (for spa mode)
        document.addEventListener('livewire:navigated', function() {
            loadDarkMode();
        });
    </script>
    @livewireStyles
</head>

<body class="bg-(--color-surface)">
    <x-ui.layout>
        @include('custom.sidebar')
        <x-ui.layout.main>
            @include('custom.header')

            <div class="p-6">
                {{ $slot }}
            </div>

            <x-ui.toast position="bottom-right" maxToasts="5" />
        </x-ui.layout.main>
    </x-ui.layout>

    @livewireScripts
</body>

</html>
