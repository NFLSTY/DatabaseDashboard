@extends('layouts.app')

@section('title', 'Category Management')

@section('contents')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Categories</h1>
    <a href="{{ route('categories.create') }}" class="btn btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Add New Category
    </a>
</div>

<!-- Display Messages -->
@if(Session::has('success'))
<div class="alert alert-success" role="alert">
    {{ Session::get('success') }}
</div>
@endif
@if(Session::has('error'))
<div class="alert alert-danger" role="alert">
    {{ Session::get('error') }}
</div>
@endif


<!-- Category Table Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Category List</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" width="100%" cellspacing="0">
                <thead class="table-primary">
                    <tr>
                        <th width="10%">#</th>
                        <th>Name</th>
                        <th>Products Count</th>
                        <th width="20%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($categories->count() > 0)
                        @foreach($categories as $category)
                            <tr>
                                <td class="align-middle">{{ $loop->iteration + $categories->firstItem() - 1 }}</td>
                                <td class="align-middle">{{ $category->name }}</td>
                                <td class="align-middle">{{ $category->products_count }}</td>
                                <td class="align-middle">
                                    <div class="btn-group" role="group" aria-label="Category Actions">
                                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        
                                        @if($category->products_count > 0)
                                            <!-- If category has products, show a disabled button with a tooltip -->
                                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Cannot delete category with associated products">
                                                <button class="btn btn-danger btn-sm" style="pointer-events: none;" type="button" disabled>
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </span>
                                        @else
                                            <!-- Otherwise, show the normal delete button -->
                                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="text-center" colspan="4">No categories found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <!-- Pagination Links -->
        <nav class="d-flex justify-content-center">
            {!! $categories->links() !!}
        </nav>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Initialize Bootstrap tooltips for the disabled buttons
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
@endpush