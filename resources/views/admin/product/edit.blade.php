@php
    $object = 'product';
    $object_title = 'sản phẩm';
@endphp
@extends('admin.layout.master')
@section('breadcrumb')
    <ol class="breadcrumb d-md-flex d-none">
        <li class="breadcrumb-item">
            <i class="bi bi-house"></i>
            <a href="{{ route($object) }}">{{ ucfirst($object) }}</a>
        </li>
        <li class="breadcrumb-item breadcrumb-active" aria-current="page">Chỉnh sửa</li>
    </ol>
@endsection
@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif(session('danger'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('danger') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <form action="{{ route($object . '.update', ['id' => $product->id]) }}" enctype="multipart/form-data" method="post">
        @csrf
        <div class="row">
            <div class="col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Thông tin sản phẩm</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-12">
                                <div class="card-border">
                                    <div class="card-border-title">Thông tin</div>
                                    <div class="card-border-body">
                                        <div class="row">
                                            <div class="col-sm-12 col-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Tên sản phẩm<span
                                                            class="text-red">*</span></label>
                                                    <input name="name" value="{{ old('name', $product->name) }}"
                                                        type="text" class="form-control" placeholder="Nhập tên sản phẩm"
                                                        autocomplete="off">
                                                    @error('name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="mb-3 form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="is_variable"
                                                        name="is_variable"
                                                        {{ $product->has_variants == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="is_variable">Sản phẩm có biến
                                                        thể</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Thương hiệu<span
                                                            class="text-red">*</span></label>
                                                    <select class="form-control" name="brand_id">
                                                        <option value="">Chọn thương hiệu</option>
                                                        @foreach ($brands as $brand)
                                                            <option value="{{ $brand->id }}"
                                                                {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                                                {{ $brand->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('brand_id')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            @php

                                            @endphp
                                            <div class="col-sm-12 col-12">
                                                <div class="mb-0">
                                                    <label class="form-label">Danh mục<span
                                                            class="text-red">*</span></label>
                                                    <select class="form-control" name="category_id[]" id=""
                                                        multiple>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}"
                                                                {{ in_array($category->id, $selected_categories) ? 'selected' : '' }}>
                                                                {{ $category->name }}</option>
                                                        @endforeach

                                                    </select>
                                                    @error('category_id')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            @if ($product->has_variants != 1)
                                                <div class="row" id="simple-product-fields">
                                                    <div class="col-sm-6 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">Giá sản phẩm<span
                                                                    class="text-red">*</span></label>
                                                            <div class="input-group">
                                                                <input
                                                                    value="{{ !$product->has_variants ? $product->price ?? '' : '' }}"
                                                                    name="price" type="text" class="form-control"
                                                                    placeholder="Nhập giá sản phẩm" autocomplete="off">
                                                                <span class="input-group-text">đ</span>
                                                            </div>
                                                            @error('price')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-12">
                                                        <div class=" mb-3">
                                                            <label class="form-label">Mức giảm giá</label>
                                                            <div class="input-group">
                                                                <input
                                                                    value="{{ !$product->has_variants ? $product->sale_percent ?? 0 : '' }}"
                                                                    type="text" name="sale_percent" class="form-control"
                                                                    placeholder="Nhập % giảm giá" autocomplete="off">
                                                                <span class="input-group-text">%</span>
                                                            </div>
                                                            @error('sale_percent')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">Số lượng tồn kho<span
                                                                    class="text-red">*</span></label>
                                                            <input
                                                                value="{{ !$product->has_variants ? $product->quantity ?? 0 : '' }}"
                                                                name="quantity" type="text" class="form-control"
                                                                placeholder="Nhập số lượng tồn kho" autocomplete="off">
                                                            @error('quantity')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div id="variant-section">
                                            <div class="mb-3">
                                                <label class="form-label">Chọn thuộc tính</label>
                                                <select id="attribute-selector" class="form-select" multiple>
                                                    @foreach ($attributes as $attribute)
                                                        <option value="{{ $attribute->id }}">{{ $attribute->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div id="attribute-values-container" class="mb-3"></div>

                                            <button type="button" class="btn btn-outline-primary" id="generate-variant">
                                                <i class="bi bi-plus-circle"></i> Thêm biến thể
                                            </button>
                                        </div>

                                        <hr>

                                        <div id="variant-combinations">
                                            {{-- Load biến thể từ $product->variants --}}
                                            @foreach ($product->variants as $index => $variant)
                                                @php
                                                    $comboInput = json_encode($variant['attributes']);
                                                    $display = collect($variant['attributes'])
                                                        ->map(function ($attr) {
                                                            return $attr['attribute']['name'] .
                                                                ': ' .
                                                                $attr['value']['label'];
                                                        })
                                                        ->implode(' | ');
                                                @endphp
                                                <div class="card p-2 mb-2 variant-item">
                                                    <input type="hidden"
                                                        name="variants[{{ $index }}][attributes]"
                                                        value='{{ $comboInput }}'>
                                                    <strong>Biến thể {{ $index + 1 }}: {{ $display }}</strong>
                                                    <div class="row mt-2">
                                                        <div class="col">
                                                            <input type="text"
                                                                name="variants[{{ $index }}][sku]"
                                                                value="{{ $variant['sku'] }}" class="form-control"
                                                                placeholder="SKU">
                                                        </div>
                                                        <div class="col">
                                                            <input type="number"
                                                                name="variants[{{ $index }}][price]"
                                                                value="{{ $variant['price'] }}" class="form-control"
                                                                placeholder="Giá">
                                                        </div>
                                                        <div class="col">
                                                            <input type="number"
                                                                name="variants[{{ $index }}][sale_percent]"
                                                                value="{{ $variant['sale_percent'] }}"
                                                                class="form-control" placeholder="% giảm">
                                                        </div>
                                                        <div class="col">
                                                            <input type="number"
                                                                name="variants[{{ $index }}][stock]"
                                                                value="{{ $variant['stock'] }}" class="form-control"
                                                                placeholder="Tồn kho">
                                                        </div>
                                                        <div class="col">
                                                            <input type="file"
                                                                name="variants[{{ $index }}][image]"
                                                                class="form-control">
                                                        </div>
                                                        <div class="col">
                                                            <select name="variants[{{ $index }}][uploaded]"
                                                                class="form-select">
                                                                <option value="1"
                                                                    {{ $variant['uploaded'] ? 'selected' : '' }}>Đăng
                                                                </option>
                                                                <option value="0"
                                                                    {{ !$variant['uploaded'] ? 'selected' : '' }}>Không
                                                                    đăng</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-auto">
                                                            <button type="button"
                                                                class="btn btn-danger remove-variant">Xóa</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                </div>

                                <div class="col-sm-12 col-12">
                                    <div class="card-border">
                                        <div class="card-border-title">Đặc tính</div>
                                        <div class="card-border-body">
                                            <div class="row">
                                                <div class="col-sm-12 col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Trạng thái<span
                                                                class="text-red">*</span></label>
                                                        <select class="form-control" name="uploaded">
                                                            <option value="1"
                                                                {{ $product->uploaded == 1 ? 'selected' : '' }}> Đăng ngay
                                                            </option>
                                                            <option value="0"
                                                                {{ $product->uploaded == 0 ? 'selected' : '' }}> Chưa đăng
                                                            </option>
                                                        </select>
                                                        @error('uploaded')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Mô tả chung<span
                                                            class="text-red">*</span></label>
                                                    <textarea name="description" rows="4" class="form-control">{{ old('description', $product->description) }}</textarea>
                                                    @error('description')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-12">
                                                <div class="mb-0">
                                                    <label class="form-label">Mô tả chi tiết<span
                                                            class="text-red">*</span></label>
                                                    <textarea name="longdescription" rows="4" class="form-control">{{ old('longdescription', $product->longdescription) }}</textarea>
                                                    @error('longdescription')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-12">
                                    <div class="card-border">
                                        <div class="card-border-title">Hình ảnh</div>
                                        <div class="card-border-body">
                                            <label> Ảnh sản phẩm </label>
                                            <input type="file" class="form-control" name="image">
                                            @error('image')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            <br>
                                            <label> Ảnh mô tả </label>
                                            <input type="file" class="form-control" name="thump[]" multiple>
                                            @error('thump')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-12">
                                    <div class="custom-btn-group flex-end">
                                        <button type="submit" class="btn btn-success">Sửa</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const attrSelector = document.getElementById('attribute-selector');
            const valuesContainer = document.getElementById('attribute-values-container');
            const variantBox = document.getElementById('variant-combinations');
            const addBtn = document.getElementById('generate-variant');

            let variantIndex = {{ count($product->variants) }};

            attrSelector.addEventListener('change', function() {
                const selected = Array.from(this.selectedOptions).map(opt => ({
                    id: opt.value,
                    name: opt.text
                }));

                valuesContainer.innerHTML = '';

                selected.forEach(attr => {
                    fetch(`/api/attribute/${attr.id}/values`)
                        .then(res => res.json())
                        .then(data => {
                            const block = document.createElement('div');
                            block.classList.add('mb-2');
                            block.innerHTML = `
                                <label class="form-label">Giá trị cho: <strong>${attr.name}</strong></label>
                                <select name="attribute_values[${attr.id}][]" class="form-select" multiple>
                                    ${data.map(val => `<option value="${val.id}">${val.label ?? val.value}</option>`).join('')}
                                </select>
                            `;
                            valuesContainer.appendChild(block);
                        });
                });
            });

            addBtn.addEventListener('click', function() {
                const selects = valuesContainer.querySelectorAll('select');
                let attributes = [];

                selects.forEach(select => {
                    const attrId = select.name.match(/\d+/)[0];
                    const attrName = select.previousElementSibling.textContent.trim().replace(
                        'Giá trị cho:', '').trim();
                    Array.from(select.selectedOptions).forEach(opt => {
                        attributes.push({
                            attribute_id: attrId,
                            attribute: {
                                name: attrName
                            },
                            value_id: opt.value,
                            value: {
                                label: opt.text
                            }
                        });
                    });
                });

                if (attributes.length === 0) {
                    alert("Chưa chọn giá trị thuộc tính nào.");
                    return;
                }

                const display = attributes.map(a => `${a.attribute.name}: ${a.value.label}`).join(' | ');
                const comboInput = JSON.stringify(attributes);

                const html = `
                    <div class="card p-2 mb-2 variant-item">
                        <input type="hidden" name="variants[${variantIndex}][attributes]" value='${comboInput}'>
                        <strong>Biến thể ${variantIndex + 1}: ${display}</strong>
                        <div class="row mt-2">
                            <div class="col"><input type="text" name="variants[${variantIndex}][sku]" class="form-control" placeholder="SKU"></div>
                            <div class="col"><input type="number" name="variants[${variantIndex}][price]" class="form-control" placeholder="Giá"></div>
                            <div class="col"><input type="number" name="variants[${variantIndex}][sale_percent]" class="form-control" placeholder="% giảm"></div>
                            <div class="col"><input type="number" name="variants[${variantIndex}][stock]" class="form-control" placeholder="Tồn kho"></div>
                            <div class="col"><input type="file" name="variants[${variantIndex}][image]" class="form-control"></div>
                            <div class="col">
                                <select name="variants[${variantIndex}][uploaded]" class="form-select">
                                    <option value="1">Đăng</option>
                                    <option value="0">Không đăng</option>
                                </select>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-danger remove-variant">Xóa</button>
                            </div>
                        </div>
                    </div>
                `;
                variantBox.insertAdjacentHTML('beforeend', html);
                variantIndex++;
            });

            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-variant')) {
                    e.target.closest('.variant-item').remove();
                }
            });
        });
    </script>
@endsection
