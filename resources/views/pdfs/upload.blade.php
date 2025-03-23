@extends('layouts.app')

@section('title', 'Upload PDF')

@section('content')
    <h1>Upload a New PDF</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('pdfs.store') }}" enctype="multipart/form-data">
        @csrf

        <div>
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required class="form-control">
        </div>

        <div>
            <label for="description">Description:</label>
            <textarea id="description" name="description" class="form-control"></textarea>
        </div>

        <div>
            <label for="price">Price:</label>
            <input type="number" step="0.01" id="price" name="price" required class="form-control">
        </div>

        <div>
            <label for="pdf_file">PDF File:</label>
            <input type="file" id="pdf_file" name="pdf_file" accept=".pdf" required class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
@endsection