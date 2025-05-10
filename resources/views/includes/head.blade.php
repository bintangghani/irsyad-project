<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="{{ asset('storage/' . ($setting->icon ? $setting->icon : 'default-icon.png')) }}" type="image/x-icon"/>
<title>{{ $setting->title ?? 'PUSKITA' }}</title>


@vite(['resources/css/app.css', 'resources/js/app.js'])
