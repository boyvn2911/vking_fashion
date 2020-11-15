@extends('core/base::layouts.master')
@section('content')
    <div class="max-width-1200" id="main-order">
        <create-order currency="{{ get_application_currency()->symbol }}"></create-order>
    </div>
@stop

@push('footer')
    <script>
        "use strict";

        window.trans = {
            "Order": "{{ __('Order') }}",
        }
    </script>
@endpush
