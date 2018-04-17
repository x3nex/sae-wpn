<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SAE Web Push Notifications</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">

        <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
        <script>
            var OneSignal = window.OneSignal || [];
            OneSignal.push(function() {
                OneSignal.init({
                    appId: "4d6ac746-a6a2-45c8-baaf-ef15c5d850a9",
                    autoRegister: false,
                    notifyButton: {
                        enable: true,
                    },
                });
            });
        </script>

        </head>
    <body>
    <div class="wrapper">
        <main>
            <header>
                <img src="img/brand.gif" alt="">
                <h1>WEB PUSH NOTIFICATIONS</h1>
                <button>Subscribe</button>
            </header>
        </main>
    </div>
    </body>
</html>
