<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@lang('packages/core::common.403_error')</title>
    <style>
        body {
            margin: 0;
        }

        .container-error {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #343a40;
            color: #ffffff;
            font-family: 'Arial', sans-serif;
        }

        .text-center {
            text-align: center;
        }

        h1 {
            font-size: 50px;
            margin-bottom: 10px;
        }

        p {
            font-size: 20px;
            margin-bottom: 20px;
        }

        .back-home {
            display: inline-block;
            text-decoration: none;
            padding: 10px 30px;
            background-color: #dc3545;
            color: #ffffff;
            border-radius: 5px;
        }

        .back-home:hover {
            opacity: 0.8;
        }

        .icon {
            font-size: 100px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container-error">
        <div class="text-center">
            <div class="icon">&#128561;</div>
            <h1>@lang('packages/core::common.403_error')</h1>
            <p>@lang('packages/core::messages.403_error')</p>
            <p>Redirecting in <span id="countdown">5</span> seconds...</p>
            <a class="back-home" href="{{ route('auth.login') }}">@lang('packages/core::common.go_home')</a>
        </div>
    </div>

    <script>
        let countdown = 5;
        function updateCountdown() {
            document.getElementById('countdown').innerHTML = countdown;
            countdown--;
            if (countdown < 0) {
                window.location.href = "{{ route('auth.login') }}";
            }
        }
        setInterval(updateCountdown, 1000);
        updateCountdown();
    </script>
</body>
</html>
