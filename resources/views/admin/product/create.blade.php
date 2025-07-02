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
        <li class="breadcrumb-item breadcrumb-active" aria-current="page">Thêm</li>
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
    <form action="{{ route($object . '.store') }}" enctype="multipart/form-data" method="post">
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
                                                    <input name="name" value="{{ old('name') }}" type="text"
                                                        class="form-control" placeholder="Nhập tên sản phẩm"
                                                        autocomplete="off">
                                                    @error('name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="mb-3 form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="is_variable"
                                                        name="is_variable" {{ old('is_variable') ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="is_variable">Sản phẩm có biến
                                                        thể</label>
                                                </div>

                                            </div>
                                            <div class="col-sm-12 col-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Thương hiệu<span
                                                            class="text-red">*</span></label>
                                                    <select class="form-control" name="brand_id" id="">
                                                        <option value="">Chọn thương hiệu</option>
                                                        @foreach ($brands as $brand)
                                                            <option value="{{ $brand->id }}"
                                                                {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                                                {{ $brand->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('brand_id')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-12">
                                                <div class="mb-0">
                                                    <label class="form-label">Danh mục<span
                                                            class="text-red">*</span></label>
                                                    <select class="form-control" name="category_id[]" id=""
                                                        multiple>
                                                        {!! $option !!}
                                                    </select>
                                                    @error('category_id')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row" id="simple-product-fields">
                                                <div class="col-sm-6 col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Giá sản phẩm<span
                                                                class="text-red">*</span></label>
                                                        <div class="input-group">
                                                            <input name="price" type="text" class="form-control"
                                                                placeholder="Nhập giá sản phẩm 1000đ - 10.000.000đ"
                                                                autocomplete="off">
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
                                                            <input value="0" type="text" name="sale_percent"
                                                                class="form-control" placeholder="Nhập % giảm giá"
                                                                autocomplete="off">
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
                                                        <input name="quantity" type="text" class="form-control"
                                                            placeholder="Nhập số lượng tồn kho" autocomplete="off">
                                                        @error('quantity')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                </div>
                                            </div>

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
                                                        <select class="form-control" name="uploaded" id="">
                                                            <option value="1">Đăng ngay</option>
                                                            <option value="0">Chưa đăng</option>
                                                        </select>
                                                        @error('uploaded')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div id="variant-section" class="d-none">
                                                    <div class="mb-3">
                                                        <label class="form-label">Chọn thuộc tính</label>
                                                        <select id="attribute-selector" class="form-select" multiple>
                                                            {{-- <option value="">-- Chọn thuộc tính --</option> --}}
                                                            @foreach ($attributes as $attribute)
                                                                <option value="{{ $attribute->id }}">
                                                                    {{ $attribute->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    {{-- <div id="attribute-values-box" class="mb-3 d-none">
                                                        <label class="form-label">Chọn giá trị thuộc tính</label>
                                                        <select id="attribute-values" class="form-select"
                                                            name="attribute_values[]" multiple>
                                                            <!-- Option sẽ được đổ bằng JavaScript -->
                                                        </select>
                                                    </div> --}}
                                                    <div id="attribute-values-container" class="mb-3"></div>
                                                    <button type="button" class="btn btn-outline-primary mt-2"
                                                        id="generate-variants">
                                                        <i class="bi bi-plus-circle"></i> Tạo biến thể
                                                    </button>
                                                </div>

                                                <div id="variant-combinations"></div>
                                            </div>
                                            <div class="col-sm-12 col-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Mô tả chung<span
                                                            class="text-red">*</span></label>
                                                    <textarea name="description" rows="4" class="form-control" placeholder="Điền mô tả chung sản phẩm">{{ old('description') }}</textarea>
                                                    @error('description')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-12">
                                                <div class="mb-0">
                                                    <label class="form-label">Mô tả chi tiết<span
                                                            class="text-red">*</span></label>
                                                    <textarea id="my-editor" name="longdescription" rows="4" class="form-control"
                                                        placeholder="Nhập mô tả chi tiết">{{ old('longdescription') }}</textarea>
                                                    @error('longdescription')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-12">
                                <div class="card-border">
                                    <div class="card-border-title">Hình ảnh</div>
                                    <div class="card-border-body">
                                        <label for="image">Ảnh sản phẩm</label>
                                        <input type="file" class="form-control" name="image">
                                        @error('image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <br>
                                        <label for="thump">Ảnh mô tả</label>
                                        <input type="file" class="form-control" name="thump[]" multiple>
                                        @error('thump')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-12">
                                <div class="custom-btn-group flex-end">
                                    <button type="submit" class="btn btn-success">Thêm</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </form>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggle = document.getElementById('is_variable');
            const simpleFields = document.getElementById('simple-product-fields');
            const variantSection = document.getElementById('variant-section');
            const generateBtn = document.getElementById('generate-variants');
            const combinationBox = document.getElementById('variant-combinations');

            toggle.addEventListener('change', () => {
                const isChecked = toggle.checked;
                simpleFields.classList.toggle('d-none', isChecked);
                variantSection.classList.toggle('d-none', !isChecked);
            });

            generateBtn.addEventListener('click', () => {
                const variantBox = document.getElementById('variant-combinations');
                variantBox.innerHTML = '';

                // Tìm tất cả các select giá trị
                const selects = document.querySelectorAll('#attribute-values-container select');

                let valueGroups = [];

                selects.forEach(select => {
                    const attrId = select.name.match(/\d+/)[0]; // Lấy id thuộc tính
                    const attrLabel = select.previousElementSibling.textContent.trim().replace(
                        "Giá trị cho:", "").trim();

                    const selected = Array.from(select.selectedOptions).map(option => ({
                        attr_id: attrId,
                        attr_name: attrLabel,
                        value_id: option.value,
                        value_label: option.text
                    }));

                    if (selected.length) valueGroups.push(selected);
                });

                if (valueGroups.length < 1) {
                    alert("Vui lòng chọn giá trị thuộc tính.");
                    return;
                }

                // Hàm tạo tổ hợp cartesian product
                function cartesian(arr) {
                    return arr.reduce((a, b) => a.flatMap(d => b.map(e => [].concat(d, e))));
                }

                const combinations = cartesian(valueGroups);

                combinations.forEach((combo, index) => {
                    const display = combo.map(v => `${v.attr_name}: ${v.value_label}`).join(' | ');
                    const comboInput = JSON.stringify(combo);

                    variantBox.innerHTML += `
            <div class="card p-2 mb-2">
                <strong>Biến thể ${index + 1}: ${display}</strong>
                <input type="hidden" name="variants[${index}][attributes]" value='${comboInput}'>
                <div class="row mt-2">
                    <div class="col">
                        <input type="text" name="variants[${index}][sku]" class="form-control" placeholder="SKU">
                    </div>
                    <div class="col">
                        <input type="number" name="variants[${index}][price]" class="form-control" placeholder="Giá" required>
                    </div>
                    <div class="col">
                        <input type="number" name="variants[${index}][sale_percent]" class="form-control" placeholder="% Giảm">
                    </div>
                    <div class="col">
                        <input type="number" name="variants[${index}][stock]" class="form-control" placeholder="Tồn kho" required>
                    </div>
                    <div class="col">
                        <input type="file" name="variants[${index}][image]" class="form-control">
                    </div>
                    <div class="col">
                        <select name="variants[${index}][uploaded]" class="form-select">
                            <option value="1">Đăng</option>
                            <option value="0">Không đăng</option>
                        </select>
                    </div>
                </div>
            </div>
        `;
                });
            });

        });
        const attrSelector = document.getElementById('attribute-selector');
        const valuesContainer = document.getElementById('attribute-values-container');

        attrSelector.addEventListener('change', function() {
            const selectedAttributes = Array.from(this.selectedOptions).map(opt => ({
                id: opt.value,
                name: opt.text
            }));

            valuesContainer.innerHTML = ''; // Clear cũ nếu cần (hoặc kiểm tra trùng)

            selectedAttributes.forEach(attr => {
                fetch(`/api/attribute/${attr.id}/values`)
                    .then(res => res.json())
                    .then(data => {
                        const block = document.createElement('div');
                        block.classList.add('mb-2');

                        block.innerHTML = `
                            <label class="form-label">Giá trị cho: <strong>${attr.name}</strong></label>
                            <select name="attribute_values[${attr.id}][]" class="form-select" multiple>
                                ${data.map(item =>
                                    `<option value="${item.id}">${item.label ?? item.value}</option>`).join('')}
                            </select>
                        `;

                        valuesContainer.appendChild(block);
                    });
            });
        });
    </script>
@endsection
