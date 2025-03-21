<!DOCTYPE html>
<html>
<head>
    <title>PDF Downloads</title>
</head>
<body>
    <h1>Available PDFs</h1>

    <ul>
        @foreach ($pdfs as $pdf)
            <li>
                <a href="{{ route('pdf.show', $pdf->id) }}">{{ $pdf->title }}</a> - ₹{{ $pdf->price }}
            </li>
        @endforeach
    </ul>
</body>
</html>