<!DOCTYPE html>
<html lang="en">

<head>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? config('app.name') }}</title>
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo.png') }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles
    </head>
</head>

<body class="min-h-screen flex items-center justify-center bg-black">

    <div class="absolute inset-0">
        <img src="https://dsmcdn.cloud-bricks.net/fotos/786220/file/desktop/brasil-e-alemanha-bernard-mineirao-finais-64-original3.webp?1762085377"
            alt="Login Background" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/70"></div>
    </div>

    <div class="relative w-full max-w-md mx-4">

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <x-ui.input name="email" placeholder="Digite seu email..." type="text" :value="old('email')"
                class="bg-white/10 backdrop-blur text-white border-white/20" />


            <x-ui.error name="email" />

            <x-ui.input name="password" placeholder="Digite sua senha..." type="password" :value="old('password')" revealable
                class="bg-white/10 backdrop-blur text-white border-white/20" />

            <x-ui.error name="password" />

            <input type="hidden" name="timezone" id="timezone">

            <button type="submit"
                class="w-full rounded-xl py-3 font-semibold bg-black/50 backdrop-blur text-white hover:opacity-90 transition">
                Sign In
            </button>
        </form>


    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
            document.getElementById('timezone').value = timezone;
        });
    </script>
</body>

</html>
