@extends('layouts.app')

@section('title', 'Store Management')

@section('contents')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Stores</h1>
    <a href="{{ route('stores.create') }}" class="btn btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Add New Store
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

<!-- Store Table Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Store List</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" width="100%" cellspacing="0">
                <thead class="table-primary">
                    <tr>
                        <th width="5%">#</th>
                        <th>Store Name</th>
                        <th>Owner</th>
                        <th>Products</th>
                        <th>Status</th>
                        <th width="15%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($stores->count() > 0)
                        @foreach($stores as $store)
                            <tr>
                                <td class="align-middle">{{ $loop->iteration + $stores->firstItem() - 1 }}</td>
                                <td class="align-middle">{{ $store->name }}</td>
                                <td class="align-middle">{{ $store->user->first_name }} {{ $store->user->last_name }}</td>
                                <td class="align-middle">{{ $store->products_count }}</td>
                                <td class="align-middle">
                                    @if($store->is_active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <div class="btn-group" role="group" aria-label="Store Actions">
                                        <a href="{{ route('stores.edit', $store->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($store->products_count > 0)
                                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Cannot delete store with associated products">
                                                <button class="btn btn-danger btn-sm" style="pointer-events: none;" type="button" disabled>
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </span>
                                        @else
                                            <form action="{{ route('stores.destroy', $store->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this store?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="text-center" colspan="6">No stores found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <!-- Pagination Links -->
        <nav class="d-flex justify-content-center">
            {!! $stores->links() !!}
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