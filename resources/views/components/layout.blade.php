<!-- resources/views/components/layout.blade.php -->

<html>
    <head>
        <title>{{ 'PT MASUYA' }}</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body>
        <x-navbar />
        {{ $slot }}
    </body>
</html>