<!DOCTYPE html>
<html>
<head>
    <title>Razorpay Payment</title>
</head>
<body>
    <h1>Pay for {{ $pdf->title }}</h1>
    <p>Amount: ₹{{ number_format($amount / 100, 2) }}</p>

    <form action="{{ route('payment.success') }}" method="POST">
        @csrf
        <script
            src="https://checkout.razorpay.com/v1/checkout.js"
            data-key="{{ env('RAZORPAY_KEY') }}"
            data-amount="{{ $amount }}"
            data-currency="INR"
            data-order_id="{{ $orderId }}"
            data-buttontext="Pay with Razorpay"
            data-name="PDF Downloader"
            data-description="Payment for PDF: {{ $pdf->title }}"
            data-image="/images/logo.png"
            data-prefill.name="John Doe"  {{--Customize with user data later--}}
            data-prefill.email="john.doe@example.com" {{--Customize with user data later--}}
            data-theme.color="#F37254"
        ></script>
        <input type="hidden" name="_token" value="{!!csrf_token()!!}">
    </form>

    <script>
        document.querySelector('.razorpay-payment-button').style.display = 'none';
        window.onload = function(){
            document.querySelector('.razorpay-payment-button').click();
        }
    </script>

</body>
</html>