<!doctype html>
<html>
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>A dispute has been raised on your transfer</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="">

<div>

    <p class="py-2">Hi {{ $disputee }},</p>

    <p class="py-2">{{ $disputer[0] }} has raised a <b>dispute</b> on your transfer.</p>

    <p class="py-2">Please click below to resolve this:</p>
    <div class="mt-4">
        <span class="block w-32 rounded-md">
            <button onclick="window.location.href = '{{env('APP_URL')}}/transfer/{{ $transfer_id }}';" class="w-full flex py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                View Dispute
            </button>
        </span>
        <div>
            <img class="h-8 w-32 mb-8" src="https://image.pitchbook.com/gnkjRIZxgf2Ky3MPbrr1xIsNzce1550816075095_200x200?uq=xmEofzkE"  alt="Workflow" />
        </div>
    </div>
</div>
</body>
</html>
