

<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SAE Web Push Notifications</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <link rel="manifest" href="/manifest.json">
    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
    <script>
        var OneSignal = window.OneSignal || [];
        OneSignal.push(["init", {
            appId: "4d6ac746-a6a2-45c8-baaf-ef15c5d850a9",
            autoRegister: false, /* Set to true to automatically prompt visitors */
            notifyButton: {
                enable: false /* Set to false to hide */
            }
        }]);
    </script>
</head>
<body>
<div class="wrapper">
    <main>
        <header>
            <img src="img/brand.gif" alt="">
            <h1>WEB PUSH NOTIFICATIONS</h1>

        </header>

        <button a href="#" id="my-notification-button" style="display: none;">Subscribe</a>> </button>







        {{--ONESIGNAL SCRIPT--}}

        <script>
            function onManageWebPushSubscriptionButtonClicked(event) {
                getSubscriptionState().then(function(state) {
                    if (state.isPushEnabled) {
                        /* Subscribed, opt them out */
                        OneSignal.setSubscription(false);
                    } else {
                        if (state.isOptedOut) {
                            /* Opted out, opt them back in */
                            OneSignal.setSubscription(true);
                        } else {
                            /* Unsubscribed, subscribe them */
                            OneSignal.registerForPushNotifications();
                        }
                    }
                });
                event.preventDefault();
            }
            function updateMangeWebPushSubscriptionButton(buttonSelector) {
                var hideWhenSubscribed = false;
                var subscribeText = "Subscribe";
                var unsubscribeText = "Unsubscribe";
                getSubscriptionState().then(function(state) {
                    var buttonText = !state.isPushEnabled || state.isOptedOut ? subscribeText : unsubscribeText;
                    var element = document.querySelector(buttonSelector);
                    if (element === null) {
                        return;
                    }
                    element.removeEventListener('click', onManageWebPushSubscriptionButtonClicked);
                    element.addEventListener('click', onManageWebPushSubscriptionButtonClicked);
                    element.textContent = buttonText;
                    if (state.hideWhenSubscribed && state.isPushEnabled) {
                        element.style.display = "none";
                    } else {
                        element.style.display = "";
                    }
                });
            }
            function getSubscriptionState() {
                return Promise.all([
                    OneSignal.isPushNotificationsEnabled(),
                    OneSignal.isOptedOut()
                ]).then(function(result) {
                    var isPushEnabled = result[0];
                    var isOptedOut = result[1];
                    return {
                        isPushEnabled: isPushEnabled,
                        isOptedOut: isOptedOut
                    };
                });
            }
            var OneSignal = OneSignal || [];
            var buttonSelector = "#my-notification-button";
            /* This example assumes you've already initialized OneSignal */
            OneSignal.push(function() {
                // If we're on an unsupported browser, do nothing
                if (!OneSignal.isPushNotificationsSupported()) {
                    return;
                }
                updateMangeWebPushSubscriptionButton(buttonSelector);
                OneSignal.on("subscriptionChange", function(isSubscribed) {
                    /* If the user's subscription state changes during the page's session, update the button text */
                    updateMangeWebPushSubscriptionButton(buttonSelector);
                });
            });

            //OneSignal user_id + mocking student_id will be posted to the route

            OneSignal.push(function() {
                OneSignal.on('subscriptionChange', function(isSubscribed) {
                    if (isSubscribed) {
                        // The user is subscribed
                        //   Either the user subscribed for the first time
                        //   Or the user was subscribed -> unsubscribed -> subscribed
                        OneSignal.getUserId( function(userId) {
                            // Make a POST call to your server with the user ID
                            axios.get('/setUserID/23/'+userId)
                                .then(function (response) {
                                    console.log(response);
                                })
                                .catch(function (error) {
                                    console.log(error);
                                });
                        });
                    }
                });
            });
        </script>





    </main>
</div>
</body>
</html>
