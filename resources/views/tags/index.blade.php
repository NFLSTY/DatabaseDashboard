@extends('layouts.app')

@section('title', 'Tag Management')

@section('contents')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tags</h1>
    <a href="{{ route('tags.create') }}" class="btn btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Add New Tag
    </a>
</div>

<!-- Display success message -->
@if(Session::has('success'))
<div class="alert alert-success" role="alert">
    {{ Session::get('success') }}
</div>
@endif

<!-- Tag Table Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tag List</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" width="100%" cellspacing="0">
                <thead class="table-primary">
                    <tr>
                        <th width="10%">#</th>
                        <th>Name</th>
                        <th width="20%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($tags->count() > 0)
                        @foreach($tags as $tag)
                            <tr>
                                <td class="align-middle">{{ $loop->iteration + $tags->firstItem() - 1 }}</td>
                                <td class="align-middle">{{ $tag->name }}</td>
                                <td class="align-middle">
                                    <div class="btn-group" role="group" aria-label="Tag Actions">
                                        <a href="{{ route('tags.edit', $tag->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('tags.destroy', $tag->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this tag?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="text-center" colspan="3">No tags found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <!-- Pagination Links -->
        <nav class="d-flex justify-content-center">
            {!! $tags->links() !!}
        </nav>
    </div>
</div>
@endsection
