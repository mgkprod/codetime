<div class="form-group row">
    @if ($label)
        <label
            for="{{ $name }}"
            class="col-12">
            {{ $label }}
            @if ($required)
                <span class="text-error">*</span>
            @endif
        </label>
    @endif

    <div class="col-md-12">
        <input
            type="{{ $type }}"
            id="{{ $name }}"
            class="form-control @error($name) is-invalid @enderror"
            name="{{ $name }}"
            value="{{ old($name, $value) }}"
            {{ $required ? 'required' : '' }} />

        @error($name)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>