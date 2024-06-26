<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- force IE browsers in compatibility mode to use their most aggressive rendering engine -->

    <meta charset="utf-8">
    <title>CakeAlliance Status</title>
    <meta name="description" content="Welcome to OpenAI&#39;s home for real-time and historical data on system performance.">

    <!-- Mobile viewport optimization -->
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">

    <!-- Time this page was rendered - http://purl.org/dc/terms/issued -->
    <meta name="issued" content="1708358666">

    <!-- Mobile IE allows us to activate ClearType technology for smoothing fonts for easy reading -->
    <meta http-equiv="cleartype" content="on">

    <!-- Le fonts -->
    <style>
        @font-face {
            font-family: 'proxima-nova';
            src: url('https://dka575ofm4ao0.cloudfront.net/assets/ProximaNovaLight-f0b2f7c12b6b87c65c02d3c1738047ea67a7607fd767056d8a2964cc6a2393f7.eot?host=status.openai.com');
            src: url('https://dka575ofm4ao0.cloudfront.net/assets/ProximaNovaLight-f0b2f7c12b6b87c65c02d3c1738047ea67a7607fd767056d8a2964cc6a2393f7.eot?host=status.openai.com#iefix') format('embedded-opentype'),
            url('https://dka575ofm4ao0.cloudfront.net/assets/ProximaNovaLight-e642ffe82005c6208632538a557e7f5dccb835c0303b06f17f55ccf567907241.woff?host=status.openai.com') format('woff'),
            url('https://dka575ofm4ao0.cloudfront.net/assets/ProximaNovaLight-0f094da9b301d03292f97db5544142a16f9f2ddf50af91d44753d9310c194c5f.ttf?host=status.openai.com') format('truetype');
            font-weight:300;
            font-style:normal;
        }

        @font-face {
            font-family: 'proxima-nova';
            src: url('https://dka575ofm4ao0.cloudfront.net/assets/ProximaNovaRegular-366d17769d864aa72f27defaddf591e460a1de4984bb24dacea57a9fc1d14878.eot?host=status.openai.com');
            src: url('https://dka575ofm4ao0.cloudfront.net/assets/ProximaNovaRegular-366d17769d864aa72f27defaddf591e460a1de4984bb24dacea57a9fc1d14878.eot?host=status.openai.com#iefix') format('embedded-opentype'),
            url('https://dka575ofm4ao0.cloudfront.net/assets/ProximaNovaRegular-2ee4c449a9ed716f1d88207bd1094e21b69e2818b5cd36b28ad809dc1924ec54.woff?host=status.openai.com') format('woff'),
            url('https://dka575ofm4ao0.cloudfront.net/assets/ProximaNovaRegular-a40a469edbd27b65b845b8000d47445a17def8ba677f4eb836ad1808f7495173.ttf?host=status.openai.com') format('truetype');
            font-weight:400;
            font-style:normal;
        }

        @font-face {
            font-family: 'proxima-nova';
            src: url('https://dka575ofm4ao0.cloudfront.net/assets/ProximaNovaRegularIt-0bf83a850b45e4ccda15bd04691e3c47ae84fec3588363b53618bd275a98cbb7.eot?host=status.openai.com');
            src: url('https://dka575ofm4ao0.cloudfront.net/assets/ProximaNovaRegularIt-0bf83a850b45e4ccda15bd04691e3c47ae84fec3588363b53618bd275a98cbb7.eot?host=status.openai.com#iefix') format('embedded-opentype'),
            url('https://dka575ofm4ao0.cloudfront.net/assets/ProximaNovaRegularIt-0c394ec7a111aa7928ea470ec0a67c44ebdaa0f93d1c3341abb69656cc26cbdd.woff?host=status.openai.com') format('woff'),
            url('https://dka575ofm4ao0.cloudfront.net/assets/ProximaNovaRegularIt-9e43859f8015a4d47d9eaf7bafe8d1e26e3298795ce1f4cdb0be0479b8a4605e.ttf?host=status.openai.com') format('truetype');
            font-weight:400;
            font-style:italic;
        }

        @font-face {
            font-family: 'proxima-nova';
            src: url('https://dka575ofm4ao0.cloudfront.net/assets/ProximaNovaSemibold-09566917307251d22021a3f91fc646f3e45f8d095209bcd2cded8a1979f06e54.eot?host=status.openai.com');
            src: url('https://dka575ofm4ao0.cloudfront.net/assets/ProximaNovaSemibold-09566917307251d22021a3f91fc646f3e45f8d095209bcd2cded8a1979f06e54.eot?host=status.openai.com#iefix') format('embedded-opentype'),
            url('https://dka575ofm4ao0.cloudfront.net/assets/ProximaNovaSemibold-86724fb2152613d735ba47c3f47a9ad2424b898bea4bece213dacee40344f966.woff?host=status.openai.com') format('woff'),
            url('https://dka575ofm4ao0.cloudfront.net/assets/ProximaNovaSemibold-cf3e4eb7fbdf6fb83e526cc2a0141e55b01097e6e1abfd4cbdc3eda75d183f74.ttf?host=status.openai.com') format('truetype');
            font-weight:500;
            font-style:normal;
        }

        @font-face {
            font-family: 'proxima-nova';
            src: url('https://dka575ofm4ao0.cloudfront.net/assets/ProximaNovaBold-622ea489d20e12e691663f83217105e957e2d3d09703707d40155a29c06cc9d9.eot?host=status.openai.com');
            src: url('https://dka575ofm4ao0.cloudfront.net/assets/ProximaNovaBold-622ea489d20e12e691663f83217105e957e2d3d09703707d40155a29c06cc9d9.eot?host=status.openai.com#iefix') format('embedded-opentype'),
            url('https://dka575ofm4ao0.cloudfront.net/assets/ProximaNovaBold-c8dc577ff7f76d2fc199843e38c04bb2e9fd15889421358d966a9f846c2ed1cd.woff?host=status.openai.com') format('woff'),
            url('https://dka575ofm4ao0.cloudfront.net/assets/ProximaNovaBold-27177fe9242acbe089276ee587feef781446667ffe9b6fdc5b7fe21ad73e12f3.ttf?host=status.openai.com') format('truetype');
            font-weight:700;
            font-style:normal;
        }
    </style>


    <link rel="shortcut icon" type="image/x-icon" href="//dka575ofm4ao0.cloudfront.net/pages-favicon_logos/original/221342/openai-logomark_20x.png" />

    <link rel="shortcut icon" href='//dka575ofm4ao0.cloudfront.net/pages-favicon_logos/original/221342/openai-logomark_20x.png'>

    <link rel="alternate" type="application/atom+xml" href="https://status.openai.com/history.atom" title="OpenAI Status History - Atom Feed">
    <link rel="alternate" type="application/rss+xml" href="https://status.openai.com/history.rss" title="OpenAI Status History - RSS Feed">

    <!-- Canonical Link to ensure that only the custom domain is indexed when present -->
    <link rel="canonical" href="https://status.openai.com">

    <meta name="_globalsign-domain-verification" content="y_VzfckMy4iePo5oDJNivyYIjh8LffYa4jzUndm_bZ"/>


    <link rel="alternate" type="application/atom+xml" title="ATOM" href="https://status.openai.com/history.atom" />

    <!-- Le styles -->
    <link rel="stylesheet" media="screen" href="https://dka575ofm4ao0.cloudfront.net/packs/0.60b241c10cde3d45e15b.css" />
    <link rel="stylesheet" media="all" href="https://dka575ofm4ao0.cloudfront.net/assets/status/status_manifest-cc9fd99d26ea5cca6f3352190ad1a451683d356cd9a12bb1c7d57870bed73318.css" />

    <script src="https://dka575ofm4ao0.cloudfront.net/assets/jquery-3.5.1.min-729e416557a365062a8a20f0562f18aa171da57298005d392312670c706c68de.js"></script>

    <script>
        window.pageColorData = {"blue":"#2E95D3","border":"#E0E0E0","body_background":"#F7FBFB","font":"#050505","graph":"#2E95D3","green":"#10A37F","light_font":"#AAAAAA","link":"#10A37F","orange":"#E86C09","red":"#EF4146","yellow":"#F4AC36","no_data":"#B3BAC5"};
    </script>
    <style>
        /* BODY BACKGROUND */ /* BODY BACKGROUND */ /* BODY BACKGROUND */ /* BODY BACKGROUND */ /* BODY BACKGROUND */
        body,
        .layout-content.status.status-api .section .example-container .example-opener .color-secondary,
        .grouped-items-selector,
        .layout-content.status.status-full-history .history-nav a.current,
        div[id^="subscribe-modal"] .modal-footer,
        div[id^="subscribe-modal"],
        div[id^="updates-dropdown"] .updates-dropdown-section,
        #uptime-tooltip .tooltip-box {
            background-color:#F7FBFB;
        }

        #uptime-tooltip .pointer-container .pointer-smaller {
            border-bottom-color:#F7FBFB;
        }




        /* PRIMARY FONT COLOR */ /* PRIMARY FONT COLOR */ /* PRIMARY FONT COLOR */ /* PRIMARY FONT COLOR */
        body.status,
        .color-primary,
        .color-primary:hover,
        .layout-content.status-index .status-day .update-title.impact-none a,
        .layout-content.status-index .status-day .update-title.impact-none a:hover,
        .layout-content.status-index .timeframes-container .timeframe.active,
        .layout-content.status-full-history .month .incident-container .impact-none,
        .layout-content.status.status-index .incidents-list .incident-title.impact-none a,
        .incident-history .impact-none,
        .layout-content.status .grouped-items-selector.inline .grouped-item.active,
        .layout-content.status.status-full-history .history-nav a.current,
        .layout-content.status.status-full-history .history-nav a:not(.current):hover,
        div[id^="subscribe-modal"] .modal-header .close,
        .grouped-item-label,
        #uptime-tooltip .tooltip-box .tooltip-content .related-events .related-event a.related-event-link {
            color:#050505;
        }

        .layout-content.status.status-index .components-statuses .component-container .name {
            color:#050505;
            color:rgba(5,5,5,.8);
        }




        /* SECONDARY FONT COLOR */ /* SECONDARY FONT COLOR */ /* SECONDARY FONT COLOR */ /* SECONDARY FONT COLOR */
        small,
        .layout-content.status .table-row .date,
        .color-secondary,
        .layout-content.status .grouped-items-selector.inline .grouped-item,
        .layout-content.status.status-full-history .history-footer .pagination a.disabled,
        .layout-content.status.status-full-history .history-nav a,
        #uptime-tooltip .tooltip-box .tooltip-content .related-events #related-event-header {
            color:#AAAAAA;
        }




        /* BORDER COLOR */  /* BORDER COLOR */  /* BORDER COLOR */  /* BORDER COLOR */  /* BORDER COLOR */  /* BORDER COLOR */
        body.status .layout-content.status .border-color,
        hr,
        .tooltip-base,
        .markdown-display table,
        div[id^="subscribe-modal"],
        #uptime-tooltip .tooltip-box {
            border-color:#E0E0E0;
        }

        div[id^="subscribe-modal"] .modal-footer,
        .markdown-display table td {
            border-top-color:#E0E0E0;
        }

        .markdown-display table td + td, .markdown-display table th + th {
            border-left-color:#E0E0E0;
        }

        div[id^="subscribe-modal"] .modal-header,
        #uptime-tooltip .pointer-container .pointer-larger {
            border-bottom-color:#E0E0E0;
        }

        #uptime-tooltip .tooltip-box .outage-field {
            /*
              Generate the background-color for the outage-field from the css_body_background_color and css_border_color.

              For the default background (#ffffff) and default css_border_color (#e0e0e0), use the luminosity of the default background with a magic number to arrive at
              the original outage-field background color (#f4f5f7). I used the formula Target Color = Color * alpha + Background * (1 - alpha) to find the magic number of ~0.08.

              For darker css_body_background_color, luminosity values are lower so alpha trends toward becoming transparent (thus outage-field background becomes same as css_body_background_color).
            */
            background-color: rgba(224,224,224,0.3);

            /*
              outage-field border-color alpha is inverse to the luminosity of css_body_background_color.
              That is to say, with a default white background this border is transparent, but on a black background, it's opaque css_border_color.
            */
            border-color: rgba(224,224,224,0.0);
        }




        /* CSS REDS */ /* CSS REDS */ /* CSS REDS */ /* CSS REDS */ /* CSS REDS */ /* CSS REDS */ /* CSS REDS */
        .layout-content.status.status-index .status-day .update-title.impact-critical a,
        .layout-content.status.status-index .status-day .update-title.impact-critical a:hover,
        .layout-content.status.status-index .page-status.status-critical,
        .layout-content.status.status-index .unresolved-incident.impact-critical .incident-title,
        .flat-button.background-red {
            background-color:#EF4146;
        }

        .layout-content.status-index .components-statuses .component-container.status-red:after,
        .layout-content.status-full-history .month .incident-container .impact-critical,
        .layout-content.status-incident .incident-name.impact-critical,
        .layout-content.status.status-index .incidents-list .incident-title.impact-critical a,
        .status-red .icon-indicator,
        .incident-history .impact-critical,
        .components-container .component-inner-container.status-red .component-status,
        .components-container .component-inner-container.status-red .icon-indicator {
            color:#EF4146;
        }

        .layout-content.status.status-index .unresolved-incident.impact-critical .updates {
            border-color:#EF4146;
        }




        /* CSS ORANGES */ /* CSS ORANGES */ /* CSS ORANGES */ /* CSS ORANGES */ /* CSS ORANGES */ /* CSS ORANGES */
        .layout-content.status.status-index .status-day .update-title.impact-major a,
        .layout-content.status.status-index .status-day .update-title.impact-major a:hover,
        .layout-content.status.status-index .page-status.status-major,
        .layout-content.status.status-index .unresolved-incident.impact-major .incident-title {
            background-color:#E86C09;
        }

        .layout-content.status-index .components-statuses .component-container.status-orange:after,
        .layout-content.status-full-history .month .incident-container .impact-major,
        .layout-content.status-incident .incident-name.impact-major,
        .layout-content.status.status-index .incidents-list .incident-title.impact-major a,
        .status-orange .icon-indicator,
        .incident-history .impact-major,
        .components-container .component-inner-container.status-orange .component-status,
        .components-container .component-inner-container.status-orange .icon-indicator {
            color:#E86C09;
        }

        .layout-content.status.status-index .unresolved-incident.impact-major .updates {
            border-color:#E86C09;
        }




        /* CSS YELLOWS */ /* CSS YELLOWS */ /* CSS YELLOWS */ /* CSS YELLOWS */ /* CSS YELLOWS */ /* CSS YELLOWS */
        .layout-content.status.status-index .status-day .update-title.impact-minor a,
        .layout-content.status.status-index .status-day .update-title.impact-minor a:hover,
        .layout-content.status.status-index .page-status.status-minor,
        .layout-content.status.status-index .unresolved-incident.impact-minor .incident-title,
        .layout-content.status.status-index .scheduled-incidents-container .tab {
            background-color:#F4AC36;
        }

        .layout-content.status-index .components-statuses .component-container.status-yellow:after,
        .layout-content.status-full-history .month .incident-container .impact-minor,
        .layout-content.status-incident .incident-name.impact-minor,
        .layout-content.status.status-index .incidents-list .incident-title.impact-minor a,
        .status-yellow .icon-indicator,
        .incident-history .impact-minor,
        .components-container .component-inner-container.status-yellow .component-status,
        .components-container .component-inner-container.status-yellow .icon-indicator,
        .layout-content.status.manage-subscriptions .confirmation-infobox .fa {
            color:#F4AC36;
        }

        .layout-content.status.status-index .unresolved-incident.impact-minor .updates,
        .layout-content.status.status-index .scheduled-incidents-container {
            border-color:#F4AC36;
        }




        /* CSS BLUES */ /* CSS BLUES */ /* CSS BLUES */ /* CSS BLUES */ /* CSS BLUES */ /* CSS BLUES */
        .layout-content.status.status-index .status-day .update-title.impact-maintenance a,
        .layout-content.status.status-index .status-day .update-title.impact-maintenance a:hover,
        .layout-content.status.status-index .page-status.status-maintenance,
        .layout-content.status.status-index .unresolved-incident.impact-maintenance .incident-title,
        .layout-content.status.status-index .scheduled-incidents-container .tab {
            background-color:#2E95D3;
        }

        .layout-content.status-index .components-statuses .component-container.status-blue:after,
        .layout-content.status-full-history .month .incident-container .impact-maintenance,
        .layout-content.status-incident .incident-name.impact-maintenance,
        .layout-content.status.status-index .incidents-list .incident-title.impact-maintenance a,
        .status-blue .icon-indicator,
        .incident-history .impact-maintenance,
        .components-container .component-inner-container.status-blue .component-status,
        .components-container .component-inner-container.status-blue .icon-indicator {
            color:#2E95D3;
        }

        .layout-content.status.status-index .unresolved-incident.impact-maintenance .updates,
        .layout-content.status.status-index .scheduled-incidents-container {
            border-color:#2E95D3;
        }




        /* CSS GREENS */ /* CSS GREENS */ /* CSS GREENS */ /* CSS GREENS */ /* CSS GREENS */ /* CSS GREENS */ /* CSS GREENS */
        .layout-content.status.status-index .page-status.status-none {
            background-color:#10A37F;
        }
        .layout-content.status-index .components-statuses .component-container.status-green:after,
        .status-green .icon-indicator,
        .components-container .component-inner-container.status-green .component-status,
        .components-container .component-inner-container.status-green .icon-indicator {
            color:#10A37F;
        }




        /* CSS LINK COLOR */  /* CSS LINK COLOR */  /* CSS LINK COLOR */  /* CSS LINK COLOR */  /* CSS LINK COLOR */  /* CSS LINK COLOR */
        a,
        a:hover,
        .layout-content.status-index .page-footer span a:hover,
        .layout-content.status-index .timeframes-container .timeframe:not(.active):hover,
        .layout-content.status-incident .subheader a:hover {
            color:#10A37F;
        }

        .flat-button,
        .masthead .updates-dropdown-container .show-updates-dropdown,
        .layout-content.status-full-history .show-filter.open  {
            background-color:#10A37F;
        }




        /* CUSTOM COLOR OVERRIDES FOR UPTIME SHOWCASE */
        .components-section .components-uptime-link {
            color: #aaaaaa;
        }

        .layout-content.status .shared-partial.uptime-90-days-wrapper .legend .legend-item {
            color: #aaaaaa;
            opacity: 0.8;
        }
        .layout-content.status .shared-partial.uptime-90-days-wrapper .legend .legend-item.light {
            color: #aaaaaa;
            opacity: 0.5;
        }
        .layout-content.status .shared-partial.uptime-90-days-wrapper .legend .spacer {
            background: #aaaaaa;
            opacity: 0.3;
        }
    </style>


    <!-- custom css -->

    <!-- polyfills -->
    <script crossorigin="anonymous" src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

    <!-- Le HTML5 shim -->
    <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- injection for static -->



</head>


<body class="status index status-none">




<div class="layout-content status status-index starter">
    <div class="masthead-container basic">

        <div class="masthead has-logo">
            <div class="logo-container">
                {{--                <a href="https://cakealliance.net/"><img alt="Page logo" src="https://s.dou.ua/CACHE/images/img/static/companies/cake_2_png/043969e639022444f2129c0dc8824075.png" /></a>--}}
            </div>



            <script>
                $(function () {
                    const phoneNumberInput = $('#phone-number');
                    const errorDiv = $('#sms-atl-error')
                    if(errorDiv.length){
                        function checkSelectedCountry() {
                            const selectedCountry = $('#phone-country').val();
                            const isOtpEnabled = $('#phone-number-country-code').attr('data-otp-enabled') === 'true';
                            const form = document.getElementById('subscribe-form-sms');
                            form.action = '/subscriptions/new-sms';
                            const isOtpFlow = document.getElementById('otp_verify_flow');
                            document.getElementById('otp-container').style.display = "none";
                            if(false && selectedCountry === 'sg') { // Replace 'SG' with the actual value representing Singapore in your select tag
                                phoneNumberInput.prop('disabled', true);
                                errorDiv.html(`Due to new Singapore government regulations, we're currently not supporting text subscriptions in Singapore.<a href="https://community.atlassian.com/t5/Statuspage-articles/Attention-SMS-notifications-will-be-disabled-on-August-1st-2023/ba-p/2424398" target="_blank"> Learn more.</a> <br> Select another method to subscribe.`);
                            } else {
                                phoneNumberInput.prop('readonly', false);
                                errorDiv.html('');
                                if(true){
                                    if(isOtpEnabled){
                                        document.getElementById('subscribe-btn-sms').value = "Send OTP";
                                    }
                                    else {
                                        isOtpFlow.value = false;
                                        document.getElementById('subscribe-btn-sms').value = "Subscribe via Text Message";
                                    }
                                }
                            }
                        }

                        $('#phone-country').on('change', checkSelectedCountry);
                        checkSelectedCountry();
                    }
                });

                document.addEventListener('DOMContentLoaded', function() {
                    const dropdown = document.querySelector('#phone-number-country-code .phone-country');
                    if (dropdown){
                        const wrapperDiv = document.getElementById('phone-number-country-code');
                        const selectedOption = dropdown.options[dropdown.selectedIndex];
                        const otpEnabled = selectedOption.getAttribute('data-otp-enabled');

                        wrapperDiv.setAttribute('data-otp-enabled', otpEnabled);

                        dropdown.addEventListener('change', function() {
                            const selectedOption = dropdown.options[dropdown.selectedIndex];
                            const otpEnabled = selectedOption.getAttribute('data-otp-enabled');

                            wrapperDiv.setAttribute('data-otp-enabled', otpEnabled);
                        });
                    }
                });

                var countdownTimer;
                var resendBtn = document.getElementById('resend');
                var timer = document.getElementById('timer');
                var form = document.getElementById('subscribe-form-sms');
                var RESEND_TIMER = 30;
                $(function() {
                    $('#subscribe-form-sms').on('ajax:success', function(e, data, status, xhr){
                        const form = this;
                        const action = form.getAttribute('action');
                        if (data.type === 'success' && data.otp_flow === true) {
                            document.getElementById('subscriber_code').value = data.subscriber_code
                            document.getElementById('otp-container').style.display = "block";
                            $('#phone-number').prop('readonly', true);
                            var display = document.getElementById('countdown');
                            disableResend();
                            startTimer(RESEND_TIMER, display)
                            document.getElementById('subscribe-btn-sms').value = "Verify OTP and Subscribe";
                            document.getElementById('otp_verify_flow').value = true;
                            form.action = '/subscriptions/verify-otp';
                        } else if (data.type === 'success' && action.includes('verify')){
                            document.getElementById('otp-container').style.display = "none";
                            $('#phone-number').val('').prop('readonly', false);
                            $('#otp').val('');
                            document.getElementById('subscribe-btn-sms').value = "Send OTP";
                            document.getElementById('otp_verify_flow').value = false;
                            form.action = '/subscriptions/new-sms';
                            SP.currentPage.updatesDropdown.hide();
                        }
                    });
                    $("#btn-subcriber-change-number").on('click', () => {
                        document.getElementById('otp-container').style.display = "none";
                        $('#phone-number').prop('readonly', false);
                        document.getElementById('subscribe-btn-sms').value = "Send OTP";
                        form.action = '/subscriptions/new-sms';
                        return false
                    })
                    $('#resend-otp-btn').on('click', function(e) {
                        e.preventDefault();
                        let phoneNumber = $('#phone-number').val();
                        let countryCode = $('.phone-country').val();
                        $.ajax({
                            type: 'POST',
                            url: "/subscriptions/new-sms",
                            data: {
                                phone_number: phoneNumber,
                                phone_country: countryCode,
                                type: 'resend'
                            },
                        }).done(function(data) {
                            var messageOptions = (data.type !== undefined && data.type !== null) ? { cssClass: data.type } : {};
                            HRB.utils.notify(data.text, messageOptions);
                            var display = document.getElementById('countdown');
                            disableResend();
                            timer.style.display = "none"
                            if (data.type === 'success') {
                                startTimer(RESEND_TIMER, display);
                            }
                        })
                    });
                })

                function startTimer(duration, display){
                    var timer = duration, seconds;
                    clearInterval(countdownTimer);
                    countdownTimer = setInterval(function () {
                        seconds = parseInt(timer % 60, 10);
                        display.textContent = seconds;
                        if(--timer < 0){
                            enableResend();
                            clearInterval(countdownTimer);
                        }
                    }, 1000);
                    disableResend();
                }
                function enableResend(){
                    resendBtn.style.display = "block";
                    timer.style.display = "none"
                }
                function disableResend(){
                    resendBtn.style.display = "none";
                    timer.style.display = "block"
                }

                $(function() {
                    $('#subscribe-form-email').on('submit', function() {
                        var tokenField = document.getElementById('email-otp-token-field');
                        let page_code = "jbxzcdv9xc4d"
                        let key = keyForEmailOtpToken($('#email').val(), page_code);
                        tokenField.value = localStorage.getItem(key);
                    });
                });

                var emailOtpCountdownTimer;
                var emailOtpResendBtn = document.getElementById('resend-email-otp');
                var emailOtpTimer = document.getElementById('email-otp-timer');
                var emailOtpForm = document.getElementById('subscribe-form-email');
                var EMAIL_OTP_RESEND_TIMER = 120;
                $(function() {
                    $('#subscribe-form-email').on('ajax:success', function(e, data, status, xhr){
                        const form = this;
                        const action = form.getAttribute('action');
                        if (data.type === 'success' && data.email_otp_verify_flow === true) {
                            document.getElementById('email-otp-container').style.display = "block";
                            var display = document.getElementById('email-otp-countdown');
                            display.textContent = EMAIL_OTP_RESEND_TIMER;
                            disableEmailOtpResend();
                            startEmailOtpTimer(EMAIL_OTP_RESEND_TIMER, display)
                            document.getElementById('subscribe-btn-email').value = "Verify OTP and Subscribe";
                            document.getElementById('email_otp_verify_flow').value = true;
                            form.action = '/subscriptions/verify-email-otp';
                        } else if (data.type === 'success' && action.includes('verify')){
                            let email =  $('#email')
                            let page_code = "jbxzcdv9xc4d"
                            let key = keyForEmailOtpToken(email.val(), page_code);
                            localStorage.setItem(key, data.email_otp_auth_token);

                            document.getElementById('email-otp-container').style.display = "none";
                            email.val('').prop('readonly', false);
                            $('#email-otp').val('');
                            document.getElementById('subscribe-btn-email').value = "Send OTP";
                            document.getElementById('otp_verify_flow').value = false;
                            form.action = '/subscriptions/new-email';
                            SP.currentPage.updatesDropdown.hide();
                        }
                    });
                    $('#resend-email-otp-btn').on('click', function(e) {
                        e.preventDefault();
                        let email = $('#email').val();
                        $.ajax({
                            type: 'POST',
                            url: "/subscriptions/new-email",
                            data: {
                                email: email
                            },
                        }).done(function(data) {
                            var messageOptions = (data.type !== undefined && data.type !== null) ? { cssClass: data.type } : {};
                            HRB.utils.notify(data.text, messageOptions);
                            if (data.type === 'success') {
                                var display = document.getElementById('email-otp-countdown');
                                display.textContent = EMAIL_OTP_RESEND_TIMER;
                                disableEmailOtpResend();
                                emailOtpTimer.style.display = "none"
                                startEmailOtpTimer(EMAIL_OTP_RESEND_TIMER, display);
                            }
                        })
                    });
                })

                function startEmailOtpTimer(duration, display){
                    var timer = duration, seconds;
                    clearInterval(emailOtpCountdownTimer);
                    emailOtpCountdownTimer = setInterval(function () {
                        seconds = parseInt(timer, 10);
                        display.textContent = seconds;
                        if(--timer < 0){
                            enableEmailOtpResend();
                            clearInterval(emailOtpCountdownTimer);
                        }
                    }, 1000);
                    disableEmailOtpResend();
                }

                function enableEmailOtpResend(){
                    emailOtpResendBtn.style.display = "block";
                    emailOtpTimer.style.display = "none"
                }
                function disableEmailOtpResend(){
                    emailOtpResendBtn.style.display = "none";
                    emailOtpTimer.style.display = "block"
                }
                function keyForEmailOtpToken(email, pageCode) {
                    return email + '|' + pageCode+ '|SUBSCRIBE_VIA_EMAIL';
                }
            </script>

            <div class="clearfix"></div>
        </div>

    </div>


    <div class="container">
        <div class="page-status status-none">
          <span class="status font-large">
            CakeAlliance websites status info
          </span>
            <span class="last-updated-stamp  font-small"></span>
        </div>

        <div class="components-section font-regular">
            <i class="component-status hidden major_outage"></i>
            <div class="components-uptime-link history-footer-link">
                Uptime over the past <var data-var="num" data-pluralize="90">90</var> days.
                Last check: {{$lastCheck}} (Kyiv timezone)
            </div>
            <div class="components-container one-column">

                @foreach($sitesStatusInfo as $siteName => $siteStatusInfo)
                    <div class="component-container border-color">

                        <div data-component-id="{{$siteStatusInfo['brand_id']}}"
                             class="component-inner-container status-green showcased"
                             data-component-status="operational"
                             data-js-hook="">

                       <span class="name">
                          <a target="_blank" href="{{$siteName}}"> {{$siteName}} </a>
                       </span>

                            <span class="component-status " title="">
                                Operational
                            </span>

                            <span class="tool icon-indicator fa fa-check" title="Operational"></span>

                            <div class="shared-partial uptime-90-days-wrapper">
                                <svg class="availability-time-line-graphic" id="uptime-component-{{$siteStatusInfo['brand_id']}}" preserveAspectRatio="none" height="34" viewBox="0 0 448 34">

                                    @php
                                        $x = 0;
                                        $day = 0;
                                    @endphp
                                    @foreach($siteStatusInfo['days'] as $statusInfo)
                                        <rect height="34" width="3" x="{{$x}}" y="0"
                                              @if($statusInfo['failed_checks'] >= 50)
                                                  fill="#ef4146"
                                              @elseif($statusInfo['failed_checks'] >= 10)
                                                  fill="#f3a632"
                                              @elseif($statusInfo['failed_checks'] > 0)
                                                  fill="#a3a950"
                                              @elseif($statusInfo['failed_checks'] === 0)
                                                  fill="#10a37f"
                                              @else
                                                  fill="#778899"
                                              @endif
                                              role="tab" class="uptime-day component-{{$siteStatusInfo['brand_id']}} day-{{$day}}"
                                              data-html="true" tabindex="-1" aria-describedby="uptime-tooltip" />
                                        @php($x += 5)
                                        @php($day++)
                                    @endforeach
                                </svg>

                                <div class="legend ">
                                    <div class="legend-item light legend-item-date-range">
                                        <span class="availability-time-line-legend-day-count">90</span> days ago
                                    </div>
                                    <div class="spacer">

                                    </div>
                                    <div class="legend-item legend-item-uptime-value legend-item-{{$siteStatusInfo['brand_id']}}">
                                    <span id="uptime-percent-{{$siteStatusInfo['brand_id']}}">
                                      <var data-var="uptime-percent">{{ $siteStatusInfo['uptime_percent'] }}</var>
                                    </span>
                                        % uptime
                                    </div>
                                    <div class="spacer">

                                    </div>
                                    <div class="legend-item light legend-item-date-range">Today</div>
                                </div>

                            </div>

                        </div>

                    </div>
                @endforeach
            </div>

        </div>

        <script type="text/javascript" charset="utf-8">

            function calculateViewbox (dayCount, rectWidth, rectPadding) {
                var viewBox = [];
                if (dayCount === 90) {
                    viewBox.push(0);
                } else {
                    var offset = 90 - dayCount;
                    viewBox.push((offset * rectWidth) + (rectPadding * (offset))); // x origin
                }
                viewBox.push(0); // y origin
                viewBox.push((rectWidth * dayCount) + (rectPadding * (dayCount - 1))); // svg width
                viewBox.push(34); // svg height
                return viewBox.join(' ');
            }

            document.addEventListener('DOMContentLoaded', function () {

                var MAX_WIDTH_30_DAYS = 600,
                    MAX_WIDTH_60_DAYS = 1024,
                    svgs = document.getElementsByClassName('availability-time-line-graphic'),
                    rects = svgs[0].getElementsByTagName('rect'),
                    rectWidth = parseInt(rects[0].getAttribute('width')),
                    rectPadding = parseInt(rects[1].getAttribute('x')) - parseInt(rects[0].getAttribute('x')) - rectWidth,
                    throttled = false,
                    delay = 150,
                    timeoutId;

                function getKeyAndCount(width) {
                    if (width <= MAX_WIDTH_30_DAYS) {
                        return { dayCount: 30, uptimeKey: 'thirty'}
                    } else if (width <= MAX_WIDTH_60_DAYS) {
                        return { dayCount: 60, uptimeKey: 'sixty'}
                    } else {
                        return { dayCount: 90, uptimeKey: 'ninety'}
                    }
                }

                function setUptimeValue(values, uptimeKey) {
                    var queryID = '.legend-item-' + values.component;
                    var currentUptime = document.querySelector(queryID);
                    if (currentUptime) {
                        // Faster than setting innerHTML to "" then adding nodes
                        var clone = currentUptime.cloneNode(false);
                        var uptimeSpan = document.createElement('span');
                        uptimeSpan.id = 'uptime-percent-' + values.component
                        uptimeSpan.innerText = values[uptimeKey]
                        clone.appendChild(uptimeSpan);
                        var appendText = document.createTextNode(' % uptime');
                        clone.appendChild(appendText);
                        currentUptime.parentNode.replaceChild(clone, currentUptime);
                    }
                }

                function setDayCount(el, dayCount) {
                    // Faster than setting innerHTML to "" then adding nodes
                    var clone = el.cloneNode(false);
                    var dateSpan = document.createElement('span')
                    dateSpan.className = "availability-time-line-legend-day-count"
                    dateSpan.innerText= dayCount;
                    clone.appendChild(dateSpan);
                    var appendText = document.createTextNode(' days ago');
                    clone.appendChild(appendText);
                    el.parentNode.replaceChild(clone, el);
                }

                function resizeSvgViewBoxes () {
                    var width = window.innerWidth;
                    var columnInfo = getKeyAndCount(width);
                    var dayCount = columnInfo.dayCount,
                        uptimeKey = columnInfo.uptimeKey;
                    var newViewboxValue = calculateViewbox(dayCount, rectWidth, rectPadding);

                    // If a user quickly resizes from < 450 to > 900 without stopping,
                    // it will retain the same 30 day info as it wont have changed, but this only
                    // impacts 30 day display as it is the only one with shortened text
                    if (newViewboxValue !== svgs[0].getAttribute('viewBox')) {
                        for (var i = 0; i < svgs.length; i++) {
                            var el = svgs[i];
                            if (el.getAttribute('viewBox') !== newViewboxValue) {
                                el.setAttribute('viewBox', newViewboxValue);
                            }
                        }

                        var dayCountElements = document.querySelectorAll('.legend-item-date-range:first-of-type');

                        for (var i = 0; i < dayCountElements.length; i++) {
                            setDayCount(dayCountElements[i], dayCount);
                        }

                        uptimeValues = [{"component":"scd0s93nldpb","ninety":99.84,"sixty":99.77,"thirty":99.55},{"component":"tbwycthtqm69","ninety":99.79,"sixty":99.74,"thirty":99.61},{"component":"csm9vdtjbsf0","ninety":100.0,"sixty":100.0,"thirty":100.0},{"component":"p4pvx4j7r7n7","ninety":100.0,"sixty":100.0,"thirty":100.0}];

                        for (var i = 0; i < uptimeValues.length; i++) {
                            setUptimeValue(uptimeValues[i], uptimeKey)
                        }

                        const uptimeLinkVar = document.querySelector('.components-uptime-link > var')
                        if (uptimeLinkVar) {
                            uptimeLinkVar.innerHTML = dayCount;
                        }
                    }
                }

                window.addEventListener('resize', function () {
                    clearTimeout(timeoutId);
                    timeoutId = setTimeout(function () {
                        resizeSvgViewBoxes();
                    }, delay);
                });

                resizeSvgViewBoxes();
            });
        </script>

        <div id="uptime-tooltip">
            <div class="pointer-container">
                <div class="pointer-larger"></div>
                <div class="pointer-smaller"></div>
            </div>
            <div class="tooltip-box">
                <div class="tooltip-content">
                    <div class="tooltip-close">
                        <i class="fa fa-times"></i>
                    </div>
                    <div class="date"></div>
                    <div class="outages">
                        <div class="outage-field major">
                              <span class="label">
                                <i class="component-status page-colors text-color major_outage"></i>
                                Major outage
                              </span>
                            <span class="value-hrs"></span>
                            <span class="value-mins"></span>
                        </div>
                        <div class="outage-field partial">
                              <span class="label">
                                <i class="component-status page-colors text-color partial_outage"></i>
                                Partial outage
                              </span>
                            <span class="value-hrs"></span>
                            <span class="value-mins"></span>
                        </div>
                        <div class="no-outages-msg">
                            No downtime recorded on this day.
                        </div>
                        <div class="no-data-msg">
                            No data exists for this day.
                        </div>
                        <div id="major-outage-group-count" class="outage-count">
                            <i class="component-status page-colors text-color major_outage"></i>
                            <span class="count"></span>
                            had a major outage.
                        </div>
                        <div id="partial-outage-group-count" class="outage-count">
                            <i class="component-status page-colors text-color partial_outage"></i>
                            <span class="count"></span>
                            had a partial outage.
                        </div>
                    </div>
                    <div class="related-events">
                        <h3 id="related-event-header">Related</h3>
                        <ul id="related-events-list"></ul>
                    </div>
                    <div class="no-related-msg">
                        <p>No incidents or maintenance related to this downtime.</p>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://dka575ofm4ao0.cloudfront.net/assets/vendor/bowser-1643ca34a6d589b2d4d42163a891e4512d5d7657125e09bb5f3d44288114e6bd.js"></script>
        <script type="text/javascript">
            /**
             This file contains the code needed to handle display of the uptime tooltips on status.
             Note: because it's in ERB, only ES5 syntax is allowed.
             */
            var uptimeData = {{ Js::from($jsData) }};
            var timeoutId;
            var monthStrings = [
                'Jan', 'Feb', 'Mar',
                'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep',
                'Oct', 'Nov', 'Dec'
            ];
            var EVENT_MAX_LENGTH = 90;

            // Detect device (desktop vs. touch device)
            function touchDevice() {
                var browser = bowser.getParser(window.navigator.userAgent);
                // if type is either mobile or tablet, return true
                return browser.parse().parsedResult.platform.type !== 'desktop';
            }

            // Class is in format day-<number>. Convert to just number
            function dayNumberFromClass(className) {
                return parseInt(className.split('-')[1]);
            }

            // Class is in format component-<code>. Convert to just code
            function componentCodeFromClass(className) {
                return className.split('-')[1];
            }

            // Convert number to string pixel measurement
            function intToPixels(number) {
                return number.toString() + 'px';
            }

            function truncate(str) {
                return str.substring(0, EVENT_MAX_LENGTH) +
                    (str.length > EVENT_MAX_LENGTH ? '...' : '');
            }

            // Tooltip Handling class constructor
            function UptimeTooltipHandler(frameWidth) {
                this.visible = false;
                this.activeDay = {
                    hovered: false
                };
                this.tooltip = document.getElementById('uptime-tooltip');
                this.frameWidth = frameWidth === undefined ? window.innerWidth : frameWidth;
                this.scrolling = false;

                window.addEventListener('mousemove', this.tooltipListener.bind(this));
                window.addEventListener('orientationchange', this.orientationListener.bind(this));

                // on tooltip creation, determine whether to display touch-specific controls
                var tooltipCloseButton = document.querySelector('.tooltip-close');

                if (touchDevice()) {
                    var componentsContainer = document.querySelector('.components-container');
                    componentsContainer.addEventListener('touchstart', this.handleTouch.bind(this));

                    tooltipCloseButton.addEventListener('touchstart', this.unhoverTooltip.bind(this));
                } else {
                    window.addEventListener('resize', this.resizeListener.bind(this));
                    // classList not supported by IE < 9
                    tooltipCloseButton.className += ' hidden';
                }

                // Handle toggle of group elements
                var groupComponents = document.querySelectorAll('[data-js-hook=component-group-opener]');
                for (var i = 0; i < groupComponents.length; i++) {
                    groupComponents[i].addEventListener('click', this.hideTooltip.bind(this));
                }

                var tooltipBox = document.querySelector('#uptime-tooltip .tooltip-box');
                tooltipBox.addEventListener('mouseenter', this.mouseEnteredTooltip.bind(this));
                tooltipBox.addEventListener('mouseleave', this.unhoverTooltip.bind(this));
            }

            document.querySelectorAll('.uptime-day').forEach(function (rect) {
                rect.addEventListener('focus', function (event) {
                    var tooltipHandler = new UptimeTooltipHandler();
                    tooltipHandler.updateHoveredDay(event);
                    tooltipHandler.updateTooltip(event);
                });

                rect.addEventListener('blur', function () {
                    var tooltipHandler = new UptimeTooltipHandler();
                    tooltipHandler.unhoverTooltip();
                });

                rect.addEventListener('keydown', function (event) {
                    if (event.key === 'Escape' || event.keyCode === 27) {
                        var tooltipHandler = new UptimeTooltipHandler();
                        tooltipHandler.unhoverTooltip();
                    }
                });
            });

            UptimeTooltipHandler.prototype.tooltipListener = function(event) {
                if (!this.tooltipHovered) {
                    this.updateHoveredDay(event);
                    this.updateTooltip(event);
                }
            }

            // this handler will accommodate for mobile orientation change
            UptimeTooltipHandler.prototype.orientationListener = function(event) {
                // just close the tooltip
                this.unhoverTooltip();
            }

            UptimeTooltipHandler.prototype.resizeListener = function(event) {
                this.frameWidth = window.innerWidth;
            }

            UptimeTooltipHandler.prototype.handleTouch = function (event) {
                if (event.target.classList.contains('uptime-day')) {
                    event.stopPropagation();
                    this.bladeTouched(event);
                }
            }

            UptimeTooltipHandler.prototype.mouseEnteredTooltip = function() {
                // Necessary to clear the timeout set for closing the tooltip when the mouse
                // moves off the blade or timeline, so the tooltip isnt closed on hover
                clearTimeout(timeoutId);
                // Sets it to null so the timeout can be set later, as clearTimeout only
                // cancels the timer, and we need to allow it to be reset in the mouse
                // move handler below
                timeoutId = null;
                this.tooltipHovered = true;
            }

            UptimeTooltipHandler.prototype.unhoverTooltip = function() {
                this.tooltipHovered = false;
                this.activeDay.hovered = false;
                this.hideTooltip();
            }

            UptimeTooltipHandler.prototype.bladeTouched = function (event) {
                event.preventDefault();
                var classes = event.target.getAttribute('class').split(' ');
                var componentCode = componentCodeFromClass(classes[1])
                var index = dayNumberFromClass(classes[2]);

                // If open and tapped on same component and day, close tooltip
                if (this.visible && this.activeDay.component === componentCode && this.activeDay.index === index) {
                    this.hideTooltip();
                } else {
                    this.updateHoveredDay(event);
                    this.updateTooltip(event);
                }
            }

            UptimeTooltipHandler.prototype.updateHoveredDay = function(event) {
                var classes = event.target.getAttribute('class'); // classList doesn't work in IE
                var onDay = classes != null && classes.split(' ').indexOf('uptime-day') !== -1;

                if (onDay) {
                    classes = classes.split(' ');

                    var componentCode = componentCodeFromClass(classes[1]);
                    this.activeDay = {
                        index: dayNumberFromClass(classes[2]),
                        component: componentCode,
                        bounds: event.target.getBoundingClientRect(),
                        isGroup: uptimeData[componentCode].component.isGroup,
                        hovered: true
                    }
                } else {
                    this.activeDay.hovered = false;
                }
            }

            UptimeTooltipHandler.prototype.updateTooltip = function(event) {
                var classes = event.target.getAttribute('class'); // classList doesn't work in IE
                var hoveredOnGraphic = classes != null && classes.split(' ').indexOf('availability-time-line-graphic') !== -1;

                if (this.activeDay.hovered) {
                    this.updateTooltipData();
                    this.positionTooltip();
                } else if (this.visible && !this.activeDay.hovered && !hoveredOnGraphic) {
                    // Important: since this is on mouse move it will be called multiple times
                    // which will clear timeoutId and reset it to the new value, meaning
                    // it is a race condition to cancel it
                    if (!timeoutId) {
                        var _this = this;
                        timeoutId = setTimeout(function() {
                            _this.hideTooltip();
                            timeoutId = null;
                        }, 250);
                    }
                }
            }

            UptimeTooltipHandler.prototype.updateTooltipData = function() {
                // Get the data for the day we're hovered on
                var day = uptimeData[this.activeDay.component].days[this.activeDay.index];

                // Update the date for the tooltip
                var date = new Date(day.date);

                // Get the component's start date.  Note that it will be undefined here unless it is populated in our database
                var startDay = uptimeData[this.activeDay.component].component.startDate;
                var startDate = startDay ? new Date(startDay) : null;

                // Determine whether current date falls before component's start date.
                var beforeStartDate = startDate ? date.getTime() < startDate.getTime() : false;

                // UTC necessary since days are passed yyyy-mm-dd, and new Date uses midnight UTC, so local times
                // are presented as the day before
                var dateString = date.getUTCDate() + " " + monthStrings[date.getUTCMonth()] + " " + date.getUTCFullYear();
                document.querySelector('#uptime-tooltip .date').innerHTML = dateString;

                // Update the outage fields
                if (this.activeDay.isGroup) {
                    this.updateGroupOutageFields()
                } else {
                    this.updateOutageFields(day.outages.p, day.outages.m, day.outages.total, day.related_events, beforeStartDate);
                }
            }

            UptimeTooltipHandler.prototype.hoursFromSeconds = function(s) {
                return Math.floor(s / 3600);
            }

            UptimeTooltipHandler.prototype.minutesFromSeconds = function(s) {
                // If less than a minute, round up to 1 minute to show that some outage existed
                if (s > 0 && s < 60) {
                    return 1;
                }

                // Otherwise use floor
                return Math.floor((s % 3600) / 60);
            }

            UptimeTooltipHandler.prototype.updateGroupOutageFields = function() {
                // Hide time info
                document.querySelector('#uptime-tooltip .outage-field.major').style.display = 'none';
                document.querySelector('#uptime-tooltip .outage-field.partial').style.display = 'none';
                document.querySelector(".related-events h3").style.display = 'none';
                document.querySelector('.no-related-msg').style.display = 'none';

                var eventList = document.getElementById("related-events-list")
                var cloneList = eventList.cloneNode(false);
                eventList.parentNode.replaceChild(cloneList, eventList);

                var partialCount = 0;
                var majorCount = 0;
                var totalCount = 0;

                /**
                 We were originally using the operationalCount as part of the no outage copy for group components,
                 but ultimately decided not to use it. I opted to leave the variable in place in case we ever
                 decide to use it in the future.
                 */
                var operationalCount = 0;
                var noDataCount = 0;
                var showcasedComponentsCount = 0;

                var components = uptimeData[this.activeDay.component].component.group

                for (var i = 0; i < components.length; i++) {
                    if (!uptimeData[components[i]]) continue;

                    showcasedComponentsCount++;

                    var outages = uptimeData[components[i]].days[this.activeDay.index].outages;

                    var currentDay = uptimeData[components[i]].days[this.activeDay.index];
                    var currentDate = new Date(currentDay.date);

                    // Get the component's start date.  Note that it will be undefined here unless it is populated in our database
                    var startDay = uptimeData[components[i]].component.startDate;
                    var startDate = startDay ? new Date(startDay) : null;

                    if (outages.p) {
                        partialCount += 1;
                    }

                    if (outages.m) {
                        majorCount += 1;
                    }

                    if (outages.total) {
                        totalCount += 1;
                    }

                    // Only increase operational count if component has data for this day
                    if (!outages.p && !outages.m) {
                        if (startDate && currentDate.getTime() < startDate.getTime()) {
                            noDataCount +=1;
                        }
                        else {
                            operationalCount +=1;
                        }
                    }
                }

                document.querySelector('#major-outage-group-count').style.display = majorCount ? 'block' : 'none';
                document.querySelector('#partial-outage-group-count').style.display = partialCount ? 'block' : 'none';

                document.querySelector('#major-outage-group-count .count').innerText = majorCount + (majorCount === 1 ? " component" : " components");
                document.querySelector('#partial-outage-group-count .count').innerText = partialCount + (partialCount === 1 ? " component" : " components ");

                // Show no data message only if we do not have data for any showcased components in the group
                var showNoDataMessage = noDataCount === showcasedComponentsCount;

                // Show no outages message if we have data for the components and no outages in that data
                document.querySelector('#uptime-tooltip .no-outages-msg .no-outages-msg').style.display = (majorCount || partialCount || showNoDataMessage) ? 'none' : 'block';
                document.querySelector('#uptime-tooltip .no-data-msg').style.display = showNoDataMessage ? 'block' : 'none';
            }

            UptimeTooltipHandler.prototype.updateOutageFields = function(partial, major, total, relatedEvents, beforeStartDate) {
                // Hide group info
                document.querySelector('#major-outage-group-count').style.display = 'none';
                document.querySelector('#partial-outage-group-count').style.display = 'none';

                // Show the message that no outage present, if none is present
                if (partial || major || beforeStartDate) {
                    document.querySelector('#uptime-tooltip .no-outages-msg').style.display = 'none';
                } else {
                    document.querySelector('#uptime-tooltip .no-outages-msg').style.display = 'block';
                    var element = document.querySelector('#uptime-tooltip .no-outages-msg');
                    element.textContent = "No downtime recorded on this day." + ' Checks count: ' + total;
                }

                if (beforeStartDate) {
                    document.querySelector('#uptime-tooltip .no-data-msg').style.display = 'block';
                }
                else {
                    document.querySelector('#uptime-tooltip .no-data-msg').style.display = 'none';
                }

                // Update partial outage field if an outage exists, otherwise hide it
                if (partial) {
                    var hrs = this.hoursFromSeconds(partial);
                    var mins = this.minutesFromSeconds(partial);
                    document.querySelector('#uptime-tooltip .outage-field.partial .value-hrs').innerHTML = hrs.toString() + ' hrs';
                    document.querySelector('#uptime-tooltip .outage-field.partial .value-mins').innerHTML = mins.toString() + ' mins';
                    document.querySelector('#uptime-tooltip .outage-field.partial').style.display = 'flex';
                } else {
                    document.querySelector('#uptime-tooltip .outage-field.partial').style.display = 'none';
                }

                // Update major outage field if an outage exists, otherwise hide it
                if (major) {
                    var hrs = this.hoursFromSeconds(major);
                    var mins = this.minutesFromSeconds(major);
                    document.querySelector('#uptime-tooltip .outage-field.major .value-hrs').innerHTML = hrs.toString() + ' hrs';
                    document.querySelector('#uptime-tooltip .outage-field.major .value-mins').innerHTML = mins.toString() + ' mins';
                    document.querySelector('#uptime-tooltip .outage-field.major').style.display = 'flex';
                } else {
                    document.querySelector('#uptime-tooltip .outage-field.major').style.display = 'none';
                }

                var eventList = document.getElementById("related-events-list")
                var cloneList = eventList.cloneNode(false);
                document.querySelector(".related-events h3").style.display = (relatedEvents.length ? 'block' : 'none');

                for (var i = 0; i < relatedEvents.length; i++) {
                    var listItem = document.createElement("li");
                    listItem.className = "related-event";
                    var anchor = document.createElement("a");
                    anchor.className = "related-event-link";
                    anchor.target = "_blank";
                    anchor.href = window.Routes.incident_path(relatedEvents[i].code);


                    var text = document.createTextNode(truncate(relatedEvents[i].name));
                    anchor.appendChild(text);
                    listItem.appendChild(anchor);
                    cloneList.appendChild(listItem);
                }

                const displayNoRelatedMsg = ((major || partial) && !relatedEvents.length);
                document.querySelector('.no-related-msg').style.display = (displayNoRelatedMsg ? 'block' : 'none');

                eventList.parentNode.replaceChild(cloneList, eventList);
            }

            UptimeTooltipHandler.prototype.positionTooltip = function() {
                this.calculatePointerCenter();
                this.calculateBoxPosition();

                // show tooltip
                this.tooltip.style.display = 'block';

                // position pointer
                var pointer = this.tooltip.getElementsByClassName('pointer-container')[0];
                pointer.style.left = intToPixels(this.pointerCenter.x - 8);
                pointer.style.top = intToPixels(this.pointerCenter.y - 5);

                // position display box
                var box = this.tooltip.getElementsByClassName('tooltip-box')[0];
                box.style.left = intToPixels(this.boxLeft);
                box.style.top = intToPixels(this.pointerCenter.y + 5);

                this.visible = true;
            }

            UptimeTooltipHandler.prototype.calculatePointerCenter = function() {
                var bounds = this.activeDay.bounds;
                var rectLeft = bounds.left + window.pageXOffset;
                var rectBottom = bounds.bottom + window.pageYOffset;
                var rectWidth = bounds.right - bounds.left;

                this.pointerCenter = {
                    x: rectLeft + Math.floor(rectWidth / 2),
                    y: rectBottom + 5
                }
            }

            UptimeTooltipHandler.prototype.calculateBoxPosition = function() {
                var sideWidth = 162.5;
                if (this.pointerCenter.x - sideWidth < 0) {
                    this.boxLeft = 0;
                } else if (this.pointerCenter.x + sideWidth > this.frameWidth) {
                    this.boxLeft = this.frameWidth - sideWidth * 2;
                } else {
                    this.boxLeft = this.pointerCenter.x - sideWidth;
                }
            }

            UptimeTooltipHandler.prototype.hideTooltip = function() {
                this.tooltip.style.display = 'none';
                this.visible = false;
            }

            new UptimeTooltipHandler();

        </script>



        <div class="page-footer border-color font-small">
            {{--            <a href="/history" class="history-footer-link"><span style="font-family:arial">&larr;</span> Incident History</a>--}}

            <span class="color-secondary powered-by"><a class="color-secondary" target="_blank" rel="noopener noreferrer nofollow">Powered by CakeAlliance IT team</a></span>
        </div>
    </div>



</div>







<script src="https://dka575ofm4ao0.cloudfront.net/assets/status_manifest-64fb5687d71f873d27a1c3416b1bca684775b3e6b440b314056936b10bf9555d.js"></script>
<div id="cpt-notification-container"></div>





<!-- all of the content_for stuff -->
<script src="https://dka575ofm4ao0.cloudfront.net/assets/register_subscription_form-589b657fec607087fc5c740c568270907310bc4f6aaa20256e70f01b103025ca.js"></script>

<script type="text/javascript">
    $(function() {
        SP.currentPage.registerSubscriptionForm('email');

        SP.currentPage.registerSubscriptionForm('sms');

        SP.currentPage.registerSubscriptionForm('webhook');

    });





</script>
<script src="https://dka575ofm4ao0.cloudfront.net/assets/register_subscription_form-589b657fec607087fc5c740c568270907310bc4f6aaa20256e70f01b103025ca.js"></script>
<script>
    SP.pollForChanges('/api/v2/status.json');
</script>

<script>
    $(function() {
        $('.tool').tooltipster({
            animationDuration: 100,
            contentAsHTML: true,
            delay: 100,
            theme: 'tooltipster-borderless',
            functionInit: function (instance, helper) {
                var $origin = $(helper.origin),
                    dataOptions = $origin.attr('data-tooltip-config');
                if (dataOptions){
                    dataOptions = JSON.parse(dataOptions);
                    $.each(dataOptions, function(name, option){
                        instance.option(name, option);
                    });
                }
            }
        });
        // clicks on first tab in subscribe popout since we won't know which is first
        // upon construction in the ruby code
        $('.updates-dropdown-nav > a').eq(0).click();

        // twitter follow button needs some margin
        $('.twitter-follow-button').css('margin-right', '6px');
    });

    $(function() {
        // open/close component groups
        HRB.utils.djshook('component-group-opener').on('click', function() {
            var groupParentIndicator = $(this).find('.group-parent-indicator');
            groupParentIndicator.toggleClass('fa-plus-square-o').toggleClass('fa-minus-square-o').end().parent().toggleClass('open');
            toggleGroup(groupParentIndicator)
        });
    });

    $(function() {
        HRB.utils.djshook('component-group-opener').on('keydown', function(event) {
            if (event.key !== "Enter" && event.key !== " ") {
                return;
            }
            event.preventDefault()
            var groupParentIndicator = $(this).find('.group-parent-indicator');
            groupParentIndicator.toggleClass('fa-plus-square-o').toggleClass('fa-minus-square-o').end().parent().toggleClass('open');
            toggleGroup(groupParentIndicator)
        });
    });

    function toggleGroup(groupParentIndicator) {
        var isOpen = groupParentIndicator.attr('aria-expanded')
        if (isOpen == 'false') {
            groupParentIndicator.attr('aria-expanded', 'true');
        } else {
            groupParentIndicator.attr('aria-expanded', 'false');
        }
    }

    $(function() {
        $(document).on('ajax:complete', '.modal.in', function(e) {
            // Close the active modal.
            $('.modal.in').modal('hide');
        });
    });

</script>


<script>
    /** INITIALIZATION **/
    var recaptchaIds = {}

    // Unfortunately there's no unique selectors on the parent divs that recaptcha adds. The first unique selector
    // is the iframe rendered 2 levels deep. So this waits until the iframes are added to the page, then finds
    // the parent div and sets the z index so that it'll render above our modals & dropdowns from the start.
    function setZIndex(captchaCount, startTime) {
        // bail after 10s just in case so we don't do this forever if something whaky happens
        if (new Date() - startTime > 10000) {
            return;
        }

        var iframes = document.querySelectorAll('iframe[title="recaptcha challenge"]');
        if (iframes.length != captchaCount) {
            setTimeout(function() {
                setZIndex(captchaCount, startTime);
            }, 500);
        }

        for (var i = 0; i < iframes.length; i++) {
            // incident subscribe modal is 1050, so this has to be above that
            iframes[i].parentElement.parentElement.style.zIndex = "1100";
        }
    }

    function updateCaptchaIframeTitle(captchaCount, startTime, updates=0) {

        if (new Date() - startTime > 10000 || captchaCount === updates) {
            return;
        }
        var iframesWithTitle = document.querySelectorAll('iframe[title="recaptcha challenge expires in two minutes"]');

        if (iframesWithTitle.length != captchaCount) {
            setTimeout(function() {
                updateCaptchaIframeTitle(captchaCount, startTime, iframesWithTitle.length + updates);
            }, 500);
        }

        for (var i = 0; i < iframesWithTitle.length; i++) {
            iframesWithTitle[i].title = "recaptcha";
        }
    }

    function addIncidentCaptcha() {
        var incidentCaptcha = document.createElement('div');
        incidentCaptcha.setAttribute('id', 'subscribe-incident-recaptcha');
        incidentCaptcha.setAttribute('class', 'g-recaptcha');
        incidentCaptcha.setAttribute('data-sitekey', '6LcZ-b0UAAAAAENi956aWzynTT2ZJ80dGU3F80Op');
        incidentCaptcha.setAttribute('data-callback', 'submitIncidentSubscriberSuccess');
        incidentCaptcha.setAttribute('data-error-callback', 'submitIncidentSubscriberError');
        incidentCaptcha.setAttribute('data-size', 'invisible');
        document.body.appendChild(incidentCaptcha);
        var incidentCode = document.createElement('input');
        incidentCode.setAttribute('type', 'hidden');
        incidentCode.setAttribute('id', 'submit_incident_code');
        document.body.appendChild(incidentCode);
    }

    var onloadCallback = function() {
        // if there is an incident, then add incident captcha element
        if (document.getElementsByClassName('modal-open-incident-subscribe').length > 0) {
            addIncidentCaptcha();
        }

        var captchas = document.getElementsByClassName("g-recaptcha");

        for(var i = 0; i < captchas.length; i++) {
            var elId = captchas[i].id;
            recaptchaIds[elId] = grecaptcha.enterprise.render(elId);
        }

        setZIndex(captchas.length, new Date());
        updateCaptchaIframeTitle(captchas.length, new Date());
    }


    /** SUBSCRIBE DROPDOWN */

    // callbacks for captcha success
    function submitNewSubscriber(type, error) {
        if (error) document.querySelector('#subscribe-form-' + type + ' #captcha_error').value = 'true';

        document.getElementById('subscribe-form-' + type).dispatchEvent(new Event('submit', {bubbles: true, cancelable: true}));
        grecaptcha.enterprise.reset(recaptchaIds['subscribe-btn-' + type]);
    }
    function submitNewEmailSubscriber(token) {
        submitNewSubscriber('email');
    }
    function submitNewSmsSubscriber(token) {
        submitNewSubscriber('sms');
    }
    function submitNewWebhookSubscriber(token) {
        submitNewSubscriber('webhook');
    }
    function submitIncidentSubscriber(token, error) {
        var incidentCode = document.getElementById('submit_incident_code').value;
        var incidentForm = document.getElementById('subscribe-form-' + incidentCode);

        incidentForm.querySelector('input[name="captcha_error"]').value = error;
        incidentForm.querySelector('input[name="g-recaptcha-response"]').value = token;
        incidentForm.dispatchEvent(new Event('submit', {bubbles: true, cancelable: true}));
        grecaptcha.enterprise.reset(recaptchaIds['subscribe-incident-recaptcha']);
    }
    function submitIncidentSubscriberSuccess(token) {
        submitIncidentSubscriber(token, 'false');
    }

    // callbacks if we get captcha network errors
    function emailSubscriberCaptchaError(token) {
        submitNewSubscriber('email', true);
    }
    function smsSubscriberCaptchaError(token) {
        submitNewSubscriber('sms', true);
    }
    function webhookSubscriberCaptchaError(token) {
        submitNewSubscriber('webhook', true);
    }
    function submitIncidentSubscriberError(token) {
        submitIncidentSubscriber(token, 'true');
    }

    // tracking clicks
    ['email', 'sms', 'webhook'].forEach(function(type) {
        var el = document.getElementById('subscribe-btn-' + type);
        el && el.addEventListener("click", function() {
            $.ajax({
                type: "POST",
                url: "/subscriptions/track_attempt",
                data: {
                    type: type
                }
            })
        })
    })

    // form submission success callbacks
    $('#subscribe-form-email').on('ajax:success', function(e, data, status, xhr){
        if (data.type === 'success') {
            SP.currentPage.updatesDropdown.hide();
            document.getElementById('email').value = '';
        }
    });
    $('#subscribe-form-sms').on('ajax:success', function(e, data, status, xhr){
        if (data.type === 'success' && data.otp_flow !== true) {
            SP.currentPage.updatesDropdown.hide();
            document.getElementById('phone-number').value = '';
        }
    });
    $('#subscribe-form-webhook').on('ajax:success', function(e, data, status, xhr){
        if (data.type === 'success') {
            SP.currentPage.updatesDropdown.hide();
            document.getElementById('endpoint-webhooks').value = '';
            document.getElementById('email-webhooks').value = '';
        }
    });

    $('a.subscribe').on('click', function() {
        document.body.style.overflow = "hidden";
        document.body.style.height = "100vh";
    });

    $('div.modal-open-incident-subscribe').on('hidden', function(){
        document.body.style.overflow = "";
        document.body.style.height = "";
    });

    function submitCaptchaIncidentSubscribe(event) {
        var incidentCode = event.target.id.split('-')[2];
        event.preventDefault();

        $.ajax({
            type: "POST",
            url: "/subscriptions/track_attempt",
            data: {
                type: 'incident'
            }
        })

        document.getElementById('submit_incident_code').value = incidentCode;
        grecaptcha.enterprise.execute(recaptchaIds['subscribe-incident-recaptcha']);
    }
</script>

<script src='https://www.recaptcha.net/recaptcha/enterprise.js?onload=onloadCallback&render=explicit' async defer></script>



<script src="https://dka575ofm4ao0.cloudfront.net/packs/common-c3ca024b93f2e64d6f01.chunk.js"></script>
<script src="https://dka575ofm4ao0.cloudfront.net/packs/globals-3e964b59fb236dbfabd1.chunk.js"></script>

<script src="https://dka575ofm4ao0.cloudfront.net/packs/runtime-845beefc293f0b2f3a9a.js"></script>




<script>
    window.addEventListener('load', function () {
        const urlParams = new URLSearchParams(window.location.search);
        const messageToken = urlParams.get('slack_message_token');
        const channelName = escape(urlParams.get('channel_name'));

        if(!!messageToken) {
            switch(messageToken) {
                case 'slack_auth_error':
                    HRB.utils.notify('The Slack authorization attempt was unsuccessful. Try again.', {cssClass:'error'});
                    break;
                case 'subscribers_disabled_error':
                    HRB.utils.notify('Slack subscriptions are not enabled on this page.', {cssClass:'error'});
                    break;
                case 'direct_message_channel_error':
                    HRB.utils.notify('Subscriptions aren’t supported in direct messages. Try subscribing again and choose a channel instead.', {cssClass:'error'});
                    break
                case 'duplicate_error':
                    HRB.utils.notify("You're already subscribed to get Slack notifications in that channel.", {cssClass:'error'});
                    break;
                case 'duplicate_private_channel_error':
                    HRB.utils.notify(`You're already subscribed to get Slack notifications in #${channelName}. Invite the @Statuspage app to that channel to start getting status updates.`, {cssClass: 'error'});
                    break;
                case 'default_success':
                    HRB.utils.notify("You're now subscribed to get Statuspage updates in Slack!", {cssClass:'success'});
                    break;
                case 'private_channel_success':
                    HRB.utils.notify(`IMPORTANT: Invite the @Statuspage app to your Slack channel #${channelName} to start getting status updates.`, {cssClass:'success'});
                    break;
            }
        }
    });
</script>


<!-- FOR FLASH NOTICES -->

<!-- FOR ERROR -->


<script>
    $(function() {
        var $link = $('<span class="color-secondary powered-by"><a class="color-secondary" target="_blank" rel="noopener noreferrer nofollow" href="https://www.atlassian.com/software/statuspage?utm_campaign=status.openai.com&amp;utm_content=SP-notifications&amp;utm_medium=powered-by&amp;utm_source=inapp">Powered by Atlassian Statuspage</a></span>');

        var setPoweredByStyles = function() {
            if (!$('.powered-by').length) {
                $link.appendTo($('.page-footer'))
            }
            $('.powered-by').attr('style', 'display: inline !important; visibility:visible !important; opacity: 1 !important; position:static !important; text-indent:0px !important; transform:scale(1) !important');
        }

        setInterval(setPoweredByStyles, 1000);
    });
</script>





</body>
</html>
