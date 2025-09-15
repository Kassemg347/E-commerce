@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add New Category</h1>

    @if($errors->any())
        <div style="color:red;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div>
            <label>Name:</label>
            <input type="text" name="name" value="{{ old('name') }}">
        </div>
        <div>
            <label>Description:</label>
            <textarea name="description">{{ old('description') }}</textarea>
        </div>
        <button type="submit">Save Category</button>
    </form>

    <a href="{{ route('categories.index') }}">Back to List</a>
</div>
@endsection
