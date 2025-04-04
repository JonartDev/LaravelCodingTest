<div class="form-group mb-3">
    <label for="password">{{ isset($user) ? 'New ' : '' }}Password</label>
    <input type="password" name="password" id="password"
        class="form-control @error('password') is-invalid @enderror"
        {{ isset($user) ? '' : 'required' }}>
    @error('password')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group mb-3">
    <label for="password_confirmation">Confirm Password</label>
    <input type="password" name="password_confirmation" id="password_confirmation"
        class="form-control @error('password') is-invalid @enderror"
        {{ isset($user) ? '' : 'required' }}>
</div>