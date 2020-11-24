<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <!-- Tailwind UI -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tailwindcss/ui@latest/dist/tailwind-ui.min.css">
    @livewireStyles
    @stack('styles')
</head>
<body class="antialiased font-sans bg-gray-200">
{{ $slot }}
@livewireScripts
@stack('scripts')
<!-- Alpine -->
<script src="https://cdn.bootcdn.net/ajax/libs/alpinejs/2.7.3/alpine.js"></script>
</body>
</html>
