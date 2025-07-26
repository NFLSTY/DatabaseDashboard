@extends('layouts.app')

@section('title', 'Edit Store')

@section('contents')
<h1 class="h3 mb-4 text-gray-800">Edit Store</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Edit Store Form</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('stores.update', $store->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Store Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $store->name }}" required>
            </div>
            <div class="form-group">
                <label for="user_id">Store Owner</label>
                <select name="user_id" id="user_id" class="form-control" required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $store->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->first_name }} {{ $user->last_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{ $store->description }}</textarea>
            </div>
            <div class="form-group">
                <label for="is_active">Status</label>
                <select name="is_active" id="is_active" class="form-control" required>
                    <option value="1" {{ $store->is_active ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ !$store->is_active ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Store</button>
            <a href="{{ route('stores.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection