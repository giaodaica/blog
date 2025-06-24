<div class="row variant-item mb-3">

    <!-- Size -->
    <div class="col-lg-2">
        <select class="form-select @error('variants.' . $index . '.size_id') is-invalid @enderror"
            name="variants[{{ $index }}][size_id]" required>
            <option value="">Size</option>
            @foreach ($sizes as $size)
                <option value="{{ $size->id }}"
                    {{ old('variants.' . $index . '.size_id', $variant['size_id'] ?? '') == $size->id ? 'selected' : '' }}>
                    {{ $size->size_name }}
                </option>
            @endforeach
        </select>
        @error('variants.' . $index . '.size_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Color -->
    <div class="col-lg-2">
        <select class="form-select @error('variants.' . $index . '.color_id') is-invalid @enderror"
            name="variants[{{ $index }}][color_id]" required>
            <option value="">Color</option>
            @foreach ($colors as $color)
                <option value="{{ $color->id }}"
                    {{ old('variants.' . $index . '.color_id', $variant['color_id'] ?? '') == $color->id ? 'selected' : '' }}>
                    {{ $color->color_name }}
                </option>
            @endforeach
        </select>
        @error('variants.' . $index . '.color_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Import Price -->
    <div class="col-lg-2">
        <input type="number" class="form-control @error('variants.' . $index . '.import_price') is-invalid @enderror"
            name="variants[{{ $index }}][import_price]"
            value="{{ old('variants.' . $index . '.import_price', $variant['import_price'] ?? '') }}"
            placeholder="Giá nhập" min="0" required>
        @error('variants.' . $index . '.import_price')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Listed Price -->
    <div class="col-lg-2">
        <input type="number" class="form-control @error('variants.' . $index . '.listed_price') is-invalid @enderror"
            name="variants[{{ $index }}][listed_price]"
            value="{{ old('variants.' . $index . '.listed_price', $variant['listed_price'] ?? '') }}"
            placeholder="Giá niêm yết" min="0" required>
        @error('variants.' . $index . '.listed_price')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Sale Price -->
    <div class="col-lg-2">
        <input type="number" class="form-control @error('variants.' . $index . '.sale_price') is-invalid @enderror"
            name="variants[{{ $index }}][sale_price]"
            value="{{ old('variants.' . $index . '.sale_price', $variant['sale_price'] ?? '') }}"
            placeholder="Giá khuyến mãi" min="0">
        @error('variants.' . $index . '.sale_price')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Stock -->
    <div class="col-lg-2">
        <input type="number" class="form-control @error('variants.' . $index . '.stock') is-invalid @enderror"
            name="variants[{{ $index }}][stock]"
            value="{{ old('variants.' . $index . '.stock', $variant['stock'] ?? '') }}"
            placeholder="Số lượng" min="0" required>
        @error('variants.' . $index . '.stock')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Variant Image -->
    <div class="col-lg-2 mt-2">
        <div class="input-group">
            <input type="file"
                class="form-control variant-image-input @error('variants.' . $index . '.variant_image') is-invalid @enderror"
                name="variants[{{ $index }}][variant_image]" accept="image/*" id="variant-image-{{ $index }}"
                data-index="{{ $index }}">
        </div>

        <!-- Preview -->
        <div id="variant-image-preview-{{ $index }}" class="mt-2">
            @if (!empty($variant['temp_variant_image_url']))
                <img src="{{ $variant['temp_variant_image_url'] }}" alt="Preview" width="100">
            @endif
        </div>

        <!-- Ẩn đường dẫn ảnh tạm -->
        <input type="hidden" name="variants[{{ $index }}][temp_variant_image_url]"
            value="{{ old('variants.' . $index . '.temp_variant_image_url', $variant['temp_variant_image_url'] ?? '') }}">

        @error('variants.' . $index . '.variant_image')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

</div>