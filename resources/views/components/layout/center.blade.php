<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include("/components/layout/head")
</head>
<body
    class="h-screen font-sans antialiased dark:bg-black dark:text-white/50 h-screen align-items-center text-center content-center">
    {{ $slot }}

    @livewireScripts
</body>
</html>
