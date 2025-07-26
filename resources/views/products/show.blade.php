@extends('layouts.app')

@section('title', 'Product Details')

@section('contents')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Product Details</h1>
    <a href="{{ route('products.index') }}" class="btn btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to List
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">{{ $products->name }}</h6>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-4">
                <strong>Name:</strong>
            </div>
            <div class="col-md-8">
                {{ $products->name }}
            </div>
        </div>
        <hr>
        <div class="row mb-3">
            <div class="col-md-4">
                <strong>Slug:</strong>
            </div>
            <div class="col-md-8">
                {{ $products->slug }}
            </div>
        </div>
        <hr>
        <div class="row mb-3">
            <div class="col-md-4">
                <strong>Store:</strong>
            </div>
            <div class="col-md-8">
                {{ $products->store->name }}
            </div>
        </div>
        <hr>
        <div class="row mb-3">
            <div class="col-md-4">
                <strong>Category:</strong>
            </div>
            <div class="col-md-8">
                {{ $products->category->name }}
            </div>
        </div>
        <hr>
        <div class="row mb-3">
            <div class="col-md-4">
                <strong>Price:</strong>
            </div>
            <div class="col-md-8">
                Rp {{ number_format($products->price, 2, ',', '.') }}
            </div>
        </div>
        <hr>
        <div class="row mb-3">
            <div class="col-md-4">
                <strong>Quantity:</strong>
            </div>
            <div class="col-md-8">
                {{ $products->quantity }} units
            </div>
        </div>
        <hr>
        <div class="row mb-3">
            <div class="col-md-4">
                <strong>Tags:</strong>
            </div>
            <div class="col-md-8">
                @forelse($products->tags as $tag)
                    <span class="badge badge-info mr-1">{{ $tag->name }}</span>
                @empty
                    <span class="badge badge-secondary">No tags assigned</span>
                @endforelse
            </div>
        </div>
        <hr>
        <div class="row mb-3">
            <div class="col-md-4">
                <strong>Description:</strong>
            </div>
            <div class="col-md-8">
                <p>{{ $products->description ?: 'N/A' }}</p>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-4">
                <strong>Created At:</strong>
            </div>
            <div class="col-md-8">
                {{ $products->created_at->format('d M Y, H:i:s') }}
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <strong>Updated At:</strong>
            </div>
            <div class="col-md-8">
                {{ $products->updated_at->format('d M Y, H:i:s') }}
            </div>
        </div>
    </div>
</div>
@endsection
