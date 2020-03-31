<div class="form-group">
    <label for="MpropM">MpropDisplayM</label>
    <input
            type="text"
            class="form-control flex-fill @error('MpropM') is-invalid @enderror"
            id="MpropM"
            name="MpropM"
            placeholder=""
            value="{{ $McamelCaseM->MpropM }}"
    >
    @error('MpropM')
    <div class="invalid-feedback">
        {{  $errors->first('MpropM') }}
    </div>
    @enderror
</div>
