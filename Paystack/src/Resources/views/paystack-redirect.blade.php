<?php $paystack = app('Webkul\Paystack\Payment\Paystack') ?>

<body data-gr-c-s-loaded="true" cz-shortcut-listen="true">
    You will be redirected to the Paystack website in a few seconds.
    

    <form action="{{ route('paystack.pay') }}" id="paystack_checkout" method="POST">
        <input value="Click here if you are not redirected within 10 seconds..." type="submit">

        @foreach ($paystack->getFormFields() as $name => $value)

            <input type="hidden" name="{{ $name }}" value="{{ $value }}">

        @endforeach
    </form>

    <script type="text/javascript">
        document.getElementById("paystack_checkout").submit();
    </script>
</body>