<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> @yield('title', __('Checkout')) </title>

    @if (theme_option('favicon'))
        <link rel="shortcut icon" href="{{ RvMedia::getImageUrl(theme_option('favicon')) }}">
    @endif

    {!! Html::style('//stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css') !!}
    {!! Html::style('//use.fontawesome.com/releases/v5.0.13/css/all.css') !!}
    {!! Html::style('vendor/core/plugins/ecommerce/css/order.css') !!}
    {!! Html::style('vendor/core/plugins/ecommerce/css/address.css') !!}
    {!! Html::style('vendor/core/plugins/ecommerce/css/front-theme.css') !!}
    {!! Html::style('vendor/core/libraries/toastr/toastr.min.css') !!}

    {!! Html::script('https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js') !!}
</head>
<body class="checkout-page">
    <div class="checkout-content-wrap">
        <div class="container">
            <div class="row">
                @yield('content')
            </div>
        </div>
    </div>

    {!! Html::script('//stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js') !!}
    {!! Html::script('vendor/core/plugins/ecommerce/js/utilities.js') !!}
    {!! Html::script('vendor/core/plugins/ecommerce/libraries/validate/jquery.validate.min.js') !!}
    {!! Html::script('vendor/core/libraries/toastr/toastr.min.js') !!}
    {!! Html::script('vendor/core/plugins/ecommerce/js/checkout.js') !!}

    @if (session()->has('success_msg') || session()->has('error_msg') || isset($errors))
        <script type="text/javascript">
            $(document).ready(function () {
                @if (session()->has('success_msg'))
                    MainCheckout.showNotice('success', '{{ session('success_msg') }}');
                @endif
                @if (session()->has('error_msg'))
                    MainCheckout.showNotice('error', '{{ session('error_msg') }}');
                @endif
                @if (isset($errors))
                    @foreach ($errors->all() as $error)
                        MainCheckout.showNotice('error', '{{ $error }}');
                    @endforeach
                @endif
            });
        </script>
    @endif

</body>
</html>
