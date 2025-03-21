<!DOCTYPE html>
<html>
<head>
    <title>{{ $pdf->title }}</title>
</head>
<body>
    <h1>{{ $pdf->title }}</h1>
    <p>{{ $pdf->description }}</p>
    <p>Price: ₹{{ $pdf->price }}</p>

    <form action="{{ route('payment.process') }}" method="POST">
        @csrf
        <input type="hidden" name="pdf_id" value="{{ $pdf->id }}">
        <button type="submit">Pay and Download</button>
    </form>
</body>
</html>