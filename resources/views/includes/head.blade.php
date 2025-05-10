<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $setting->title ?? 'PUSKITA' }}</title>

<link rel="icon" href="{{ asset('/storage/' . ($setting->icon ?? 'default-icon.png')) }}" type="image/x-icon"/>

@vite(['resources/css/app.css', 'resources/js/app.js'])
