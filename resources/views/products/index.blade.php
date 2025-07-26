@extends('layouts.app')

@section('title', 'Product Management')

@section('contents')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Products</h1>
    <a href="{{ route('products.create') }}" class="btn btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Add New Product
    </a>
</div>

<!-- Display success message -->
@if(Session::has('success'))
<div class="alert alert-success" role="alert">
    {{ Session::get('success') }}
</div>
@endif

<!-- Product Table Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Product List</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" width="100%" cellspacing="0">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Store</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th width="15%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($products->count() > 0)
                        @foreach($products as $product)
                            <tr>
                                <!-- We use a formula to get the correct item number on each page -->
                                <td class="align-middle">{{ $loop->iteration + $products->firstItem() - 1 }}</td>
                                <td class="align-middle">{{ $product->name }}</td>
                                <td class="align-middle">{{ $product->store->name }}</td>
                                <td class="align-middle">{{ $product->category->name }}</td>
                                <td class="align-middle">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td class="align-middle">{{ $product->quantity }}</td>
                                <td class="align-middle">
                                    <div class="btn-group" role="group" aria-label="Product Actions">
                                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="text-center" colspan="7">No products found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <!-- Pagination Links -->
        <div class="d-flex justify-content-center">
            {!! $products->links() !!}
        </div>
    </div>
</div>
@endsection
