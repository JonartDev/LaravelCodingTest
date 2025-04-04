<div class="form-group mb-3">
    <label for="title">Product Title</label>
    <input type="text" name="title" id="title"
        class="form-control @error('title') is-invalid @enderror"
        value="{{ old('title', $product->title ?? '') }}" required>
    @error('title')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group mb-3">
    <label for="body">Body</label>
    <textarea name="body" id="body" rows="3"
        class="form-control @error('body') is-invalid @enderror" required>{{ old('body', $product->body ?? '') }}</textarea>
    @error('body')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="row mb-3">
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

<div class="form-group mb-3">
    <label for="image">Product Image</label>
    <input type="file" name="image" id="image"
        class="form-control-file @error('image') is-invalid @enderror">
    @error('image')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    @if(isset($product) && $product->image_path)
    <div class="mt-2">
        <img src="{{ asset('storage/'.$product->image_path) }}"
            alt="Current Image" width="100" class="img-thumbnail">
        <p class="text-muted">Current Image</p>
    </div>
    @endif
</div>