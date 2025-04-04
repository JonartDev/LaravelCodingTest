@extends('layouts.app')

@section('title', 'Welcome to Our Store')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="display-4">Our Products</h1>
            <p class="lead">Discover our latest collection</p>
        </div>
    </div>

    <div class="row">
        @foreach($products as $product)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-img-top" style="height: 200px; overflow: hidden;">
                    <img src="{{ asset('storage/' . $product->image_path) }}"
                        alt="{{ $product->title }}"
                        class="img-fluid w-100 h-100"
                        style="object-fit: cover;">
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $product->title }}</h5>
                    <p class="card-text text-muted">
                        {{ \Illuminate\Support\Str::limit($product->description, 100) }}
                    </p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h5 mb-0">{{ $product->quantity }} Items</span>
                        <span class="badge bg-{{ $product->quantity > 0 ? 'success' : 'danger' }}">
                            {{ $product->quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                        </span>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <div class="d-grid gap-2">
                        <a href="#" class="btn btn-outline-primary view-details" data-product-id="{{ $product->id }}">View Details</a>

                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row mt-4">
        <div class="col-12 d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    </div>
</div>

<!-- Product Details Modal -->
<div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="true" data-bs-keyboard="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalTitle">Product Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="productModalBody">
                <p>Loading product details...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btn-close" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Add to Cart</button>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const productModal = document.getElementById('productModal');

        productModal.addEventListener('hidden.bs.modal', function() {
            // Fix for any lingering modal backdrops
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) backdrop.remove();

            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
        });

        // Optional: force hide on custom logic (if you need it later)
        document.getElementById('btn-close').addEventListener('click', function() {
            const modalInstance = bootstrap.Modal.getInstance(productModal);
            document.getElementById('productModalTitle').textContent = '';
            document.getElementById('productModalBody').innerHTML = `
                            <p>Loading product details...</p>
                        `;
            if (modalInstance) modalInstance.hide();
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        document.body.addEventListener('click', function(event) {
            if (event.target.classList.contains('view-details')) {
                event.preventDefault();
                let modal = new bootstrap.Modal(document.getElementById('productModal'));
                modal.show();
                const productId = event.target.getAttribute('data-product-id');
                // Fetch product details via AJAX
                fetch(`/products/${productId}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('productModalTitle').textContent = data.title;
                        document.getElementById('productModalBody').innerHTML = `
                            <div class="row">
                                <div class="col-md-6">
                                    <img src="${data.image_path}" class="img-fluid" alt="${data.title}">
                                </div>
                                <div class="col-md-6">
                                    <p>${data.body}</p>
                                    <p><strong>Stock:</strong> ${data.quantity}</p>
                                    <p><strong>Seller:</strong> ${data.seller}</p>
                                </div>
                            </div>
                        `;

                        // Show modal
                        let modal = new bootstrap.Modal(document.getElementById('productModal'));
                        modal.show();
                    })
                    .catch(error => console.error('Error fetching product details:', error));
            }
        });
    });
</script>



@endsection