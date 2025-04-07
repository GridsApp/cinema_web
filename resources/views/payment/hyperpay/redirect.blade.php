<html>

<head>
    @php

        $config = config('omnipay');
        if (!isset($config[$provider_key])) {
            dd('Please setup your omnipay.php file');
        }
        // $provider = $config[$provider_key]['provider'];
        $data = $config[$provider_key]['data'];

        // $url_success = env('APP_URL') . '/payment/response/' . $attempt_id;


        $url_success = route('payment.response' , ['payment_attempt_id' => $attempt_id]);


        $hyperpay_cc_domain = $config[$provider_key]['data']['domain'];
        $nonce_id = uniqid();
    @endphp


    <meta http-equiv="Content-Security-Policy"
        content="
             style-src 'self' {{ $hyperpay_cc_domain }} 'unsafe-inline' ;
             frame-src 'self' {{ $hyperpay_cc_domain }};
             script-src 'self' {{ $hyperpay_cc_domain }} 'nonce-{{ $nonce_id }}' ;
             connect-src 'self' {{ $hyperpay_cc_domain }};
             img-src 'self' {{ $hyperpay_cc_domain }};
             ">

    <script src="{{ $data['url'] }}/paymentWidgets.js?checkoutId={{ $checkout_id }}" integrity="{{ $integrity }}"
        crossorigin="anonymous"></script>

    @if (in_array('APPLEPAY', $data['brands']))
        <script nonce="{{ $nonce_id }}" type="text/javascript">
            var supportedNetworks = "{{ implode(',', $data['brands']) }}";
            var supportedNetworksArray = supportedNetworks.split(",");

            supportedNetworksArray = supportedNetworksArray.map(network => {
                return network.replace(/(?:^\w|[A-Z]|\b\w|\s+)/g, function(match, index) {
                    if (+match === 0) return "";
                    return index === 0 ? match.toLowerCase() : match.toUpperCase();
                });
            });

            var wpwlOptions = {
                paymentTarget: "_top",
                applePay: {
                    merchantCapabilities: ["supports3DS"],
                    supportedNetworks: supportedNetworksArray,
                    countryCode: "{{ $data['country_code'] }}",
                }
            }
        </script>
    @else
        <script nonce="{{ $nonce_id }}" type="text/javascript">
            var wpwlOptions = {
                paymentTarget: "_top",

            }
        </script>
    @endif
</head>

<body>



    <form action="{{ $url_success }}" class="paymentWidgets" data-brands="{{ implode(' ', $data['brands']) }}"></form>



</body>

</html>
