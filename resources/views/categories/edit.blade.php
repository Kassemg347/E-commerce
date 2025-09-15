@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Category</h1>

    @if($errors->any())
        <div style="color:red;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label>Name:</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}">
        </div>
        <div>
            <label>Description:</label>
            <textarea name="description">{{ old('description', $category->description) }}</textarea>
        </div>
        <button type="submit">Update Category</button>
    </form>

    <a href="{{ route('categories.index') }}">Back to List</a>
</div>
@endsection
