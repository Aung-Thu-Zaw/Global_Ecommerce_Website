<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="title" content="{{ $meta->meta_title }}">
    <meta name="author" content=" {{ $meta->meta_author }}">
    <meta name="keywords" content=" {{ $meta->meta_keyword }}">
    <meta name="description" content="{{ $meta->meta_description }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title inertia>{{ config('app.name', 'Laravel') }}</title>
    <link rel="shortcut icon" href="{{ $setting->favicon }}" type="image">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@2.51.6/dist/full.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2/dist/tailwind.min.css" rel="stylesheet" type="text/css" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Roboto:wght@400;500;700&display=swap"
        rel="stylesheet">

    <script src="https://kit.fontawesome.com/18c274e5f3.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&display=swap" rel="stylesheet" />
    <script src="https://js.stripe.com/v3/"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/share.js') }}"></script>
    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js','resources/css/app.css', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
    <style>
        .grecaptcha-badge {
            visibility: visible !important;
        }
    </style>
</head>

<body class="font-sans antialiased w-full min-h-screen h-full bg-white border text-dark">
    <x-translations />
    @inertia
</body>

</html>