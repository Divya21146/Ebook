@extends('layouts.app')

@section('title', 'Edit PDF')

@section('content')
    <h1>Edit PDF: {{ $pdf->title }}</h1>

    <form method="POST" action="{{ route('pdfs.update', $pdf->id) }}">
        @csrf
        @method('PUT')  <!--  Important:  Use the PUT method for updates -->

        <div>
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="{{ $pdf->title }}" required class="form-control">
        </div>

        <div>
            <label for="description">Description:</label>
            <textarea id="description" name="description" class="form-control">{{ $pdf->description }}</textarea>
        </div>

        <div>
            <label for="price">Price:</label>
            <input type="number" step="0.01" id="price" name="price" value="{{ $pdf->price }}" required class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection