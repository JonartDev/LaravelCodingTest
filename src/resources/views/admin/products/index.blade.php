<table class="table table-hover">
    <thead>
        <tr>
            <th>Image</th>
            <th>Title</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
            <tr>
                <td>
                    <img src="{{ $product->image_url }}" alt="{{ $product->title }}" width="50" class="img-thumbnail">
                </td>
                <td>{{ $product->title }}</td>
                <td>${{ number_format($product->price, 2) }}</td>
                <td>
                    <span class="badge badge-{{ $product->isInStock() ? 'success' : 'danger' }}">
                        {{ $product->quantity }} in stock
                    </span>
                </td>
                <td>
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $products->links() }}