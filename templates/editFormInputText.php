<div class="form-group">
    <label for="name">Name</label>
    <input
        type="text"
        class="form-control flex-fill @error('name') is-invalid @enderror"
        id="name"
        name="name"
        placeholder=""
        value="{{ $template->name }}"
    >
    @error('name')
    <div class="invalid-feedback">
        {{  $errors->first('name') }}
    </div>
    @enderror
</div>
