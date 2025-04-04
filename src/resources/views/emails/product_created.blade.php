<h1>New Product Created!</h1>

<p><strong>Title:</strong> {{ $product->title }}</p>
<p><strong>Quantity:</strong> {{ $product->quantity }}</p>

<p>
    <a href="{{ route('products.show', $product->id) }}">
        View Product Details
    </a>
</p>
