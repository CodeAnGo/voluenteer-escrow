<!doctype html>
<html>
<head>
    <meta name="viewport" content="width=device-width"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Your transfer status has been changed to {{ $status }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="py-2">
    <p class="py-1">Hi {{ $sending_party_name }},</p>
    <p>The status of your {{env('APP_NAME')}} transfer has been changed to <b>{{ $status }}</b>.</p>
    <p>You can view the transfer by clicking below:</p>
    <div class="py-2">
        <span class="block w-32 rounded-md">
            <a href="window.location.href = '{{env('APP_URL')}}/transfers/{{ $transfer_id }}';"
               class="text-center w-full flex py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                View Transfer
            </a>
        </span>
    </div>
    <p>Alternatively, you can copy the link below in to your browser:</p>
    <p> {{env('APP_URL')}}/transfers/{{ $transfer_id }} </p>
    <p>Regards,</p>
    <p>{{env('APP_NAME')}}</p>
    <div>
        <img class="h-8 w-32 mb-8"
             src="https://image.pitchbook.com/gnkjRIZxgf2Ky3MPbrr1xIsNzce1550816075095_200x200?uq=xmEofzkE"
             alt="Workflow"/>
    </div>
</div>
</body>
</html>
