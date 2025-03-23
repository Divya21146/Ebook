@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1>Welcome to the Dashboard!</h1>
    <p>Here are the available PDFs:</p>

    <ul>
        @foreach ($pdfs as $pdf)
            <li>
                <a href="{{ route('pdf.show', $pdf->id) }}">{{ $pdf->title }}</a> - ₹{{ $pdf->price }}
                <!-- Add these links: -->
    <a href="{{ route('pdfs.edit', $pdf->id) }}">Edit</a>

<form method="POST" action="{{ route('pdfs.destroy', $pdf->id) }}">
    @csrf
    @method('DELETE')
    <button type="submit" onclick="return confirm('Are you sure you want to delete this PDF?')">Delete</button>
</form>
            </li>
        @endforeach
    </ul>
@endsection