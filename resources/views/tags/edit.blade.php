@extends('layouts.app')

@section('title', 'Edit Tag')

@section('contents')
<h1 class="h3 mb-4 text-gray-800">Edit Tag</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Edit Tag Form</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('tags.update', $tag->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Tag Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $tag->name }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Tag</button>
            <a href="{{ route('tags.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
