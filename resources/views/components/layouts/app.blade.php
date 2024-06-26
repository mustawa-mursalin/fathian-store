<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<title>{{ isset($title) ? $title . ' | ' . config('app.name') : config('app.name') }}</title>
	@vite(['resources/css/app.css', 'resources/js/app.js'])
	@livewireStyles
</head>

<body class="bg-slate-200 dark:bg-slate-700">
<livewire:layout.navbar />
{{--<main class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">--}}
<main>
	{{ $slot }}
</main>
<livewire:layout.footer />
@livewireScripts

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<x-livewire-alert::scripts />
</body>

</html>