<div class="card-body">
    <form method="POST" action="{{ $action }}" enctype="multipart/form-data">
        @csrf
        @if(isset($product))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="title">Product Title</label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                value="{{ old('title', $product->title ?? '') }}" required>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="body">Description</label>
            <textarea name="body" id="body" rows="5" class="form-control @error('body') is-invalid @enderror"
                required>{{ old('body', $product->body ?? '') }}</textarea>
            @error('body')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="price">Price ($)</label>
                    <input type="number" step="0.01" name="price" id="price"
                        class="form-control @error('price') is-invalid @enderror"
                        value="{{ old('price', $product->price ?? '') }}" required>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" name="quantity" id="quantity"
                        class="form-control @error('quantity') is-invalid @enderror"
                        value="{{ old('quantity', $product->quantity ?? '') }}" required>
                    @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="image">Product Image</label>
            <input type="file" name="image" id="image" class="form-control-file @error('image') is-invalid @enderror">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if(isset($product) && $product->image_path)
                <div class="mt-3">
                    <img src="{{ $product->image_url }}" alt="Current Image" width="150" class="img-thumbnail">
                    <p class="text-muted mt-2">Current Image</p>
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">
            {{ isset($product) ? 'Update' : 'Create' }} Product
        </button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
            Cancel
        </a>
    </form>
</div>