<?php

namespace App\Http\Controllers;

use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use Illuminate\Http\Request;

class ProductAttributeController extends Controller
{
    protected $view_path = 'admin.attribute.';
    protected $route_path = 'attribute';
    protected $upload_path = 'img/attribute';

    // Danh sách thuộc tính
    public function index(Request $request)
    {
        $attributes = ProductAttribute::with('values')->get();

        if ($request->expectsJson()) {
            return response()->json($attributes);
        }

        return view($this->view_path . 'index', compact('attributes'));
    }

    public function create()
    {
        return view($this->view_path . 'create');
    }

    // Tạo mới thuộc tính
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'name' => 'required|string',
            'display_type' => 'required|in:text,color,image',
            'values' => 'required|array|min:1',
        ], [
            'values.required' => 'Vui lòng thêm ít nhất một giá trị thuộc tính.'
        ]);

        $attribute = ProductAttribute::create([
            'name' => $request->name,
            'display_type' => $request->display_type,
        ]);

        foreach ($request->values as $index => $value) {
            $label = $request->value_labels[$index] ?? null;

            switch ($request->display_type) {
                case 'color':
                    $color = $request->colors[$index] ?? null;
                    if ($color) {
                        $attribute->values()->create([
                            'value' => $color,
                            'label' => $label,
                        ]);
                    }
                    break;

                case 'image':
                    if ($request->hasFile("images.$index")) {
                        $file = $request->file("images.$index");
                        $imageName = time() . "_$index." . $file->getClientOriginalExtension();
                        $file->move(public_path($this->upload_path), $imageName);
                        $url = $this->upload_path . $imageName;

                        $attribute->values()->create([
                            'value' => $url,
                            'label' => $label,
                        ]);
                    }
                    break;

                default: // text
                    if (!empty($value)) {
                        $attribute->values()->create([
                            'value' => trim($value),
                            'label' => trim($value)
                        ]);
                    }
                    break;
            }
        }

        if ($request->expectsJson()) {
            return response()->json($attribute->load('values'), 201);
        }

        return redirect()->route($this->route_path)->with('success', 'Thêm thuộc tính thành công');
    }

    public function edit($id)
    {
        $attribute = ProductAttribute::with('values')->find($id);
        return view($this->view_path . 'edit', compact("attribute"));
    }

    // Lấy chi tiết thuộc tính
    public function show(Request $request, $id)
    {
        $attribute = ProductAttribute::with('values')->findOrFail($id);

        if ($request->expectsJson()) {
            return response()->json($attribute);
        }

        return view($this->view_path . 'detail', compact('attribute'));
    }

    // Cập nhật thuộc tính
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|unique:product_attributes,name,' . $id,
            'display_type' => 'required|in:text,color,image',
            'values' => 'required|array|min:1',
            'values.*' => 'nullable|string',
            'colors.*' => 'nullable|string',
            'images.*' => 'nullable|file|image|max:2048',
            'value_labels.*' => 'nullable|string'
        ], [
            'values.required' => 'Vui lòng nhập ít nhất một giá trị.',
            'values.*.required' => 'Giá trị không được để trống.',
        ]);

        $attribute = ProductAttribute::with('values')->findOrFail($id);
        $attribute->update([
            'name' => $request->name,
            'display_type' => $request->display_type
        ]);

        // Xoá toàn bộ values cũ
        $attribute->values()->delete();

        foreach ($request->values as $index => $value) {
            $data = [];

            switch ($request->display_type) {
                case 'text':
                    if ($value) {
                        $data['value'] = $value;
                    }
                    break;

                case 'color':
                    $data['value'] = $request->colors[$index] ?? '#000000';
                    $data['label'] = $request->value_labels[$index] ?? null;
                    break;

                case 'image':
                    if ($request->hasFile("images.$index")) {
                        $imageFile = $request->file("images.$index");
                        $imageName = time() . '_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
                        $imageFile->move(public_path($this->upload_path), $imageName);
                        $data['value'] = $this->upload_path . $imageName;
                    } else {
                        $data['value'] = null; // hoặc giữ nguyên giá trị cũ nếu muốn
                    }
                    $data['label'] = $request->value_labels[$index] ?? null;
                    break;
            }

            if (!empty($data['value'])) {
                $attribute->values()->create($data);
            }
        }

        if ($request->expectsJson()) {
            return response()->json($attribute->load('values'));
        }

        return redirect()->route('attribute.index')->with('success', 'Cập nhật thành công');
    }


    // Xoá thuộc tính
    public function delete(Request $request, $id)
    {
        $attribute = ProductAttribute::with('values')->findOrFail($id);

        // Xóa ảnh nếu có
        if ($attribute->display_type === 'image') {
            foreach ($attribute->values as $value) {
                if (!empty($value->value) && file_exists(public_path($value->value))) {
                    @unlink(public_path($value->value));
                }
            }
        }

        // Xoá các giá trị con
        $attribute->values()->delete();

        // Xoá chính thuộc tính
        $attribute->delete();

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Đã xoá thuộc tính và dữ liệu liên quan']);
        }

        return redirect()->back()->with('success', 'Xoá thuộc tính thành công');
    }

    // Thêm giá trị cho thuộc tính
    public function addValue(Request $request, $attribute_id)
    {
        $request->validate([
            'value' => 'required|string'
        ]);
        $attribute = ProductAttribute::findOrFail($attribute_id);
        $value = $attribute->values()->create(['value' => $request->value]);
        if ($request->expectsJson()) {
            return response()->json($value, 201);
        }
        return redirect()->back()->with('success', 'Thêm giá trị thành công');
    }

    // Xoá giá trị thuộc tính
    public function deleteValue(Request $request, $value_id)
    {
        $value = ProductAttributeValue::findOrFail($value_id);
        $value->delete();
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Đã xoá giá trị']);
        }
        return redirect()->back()->with('success', 'Xoá giá trị thành công');
    }

    public function getValues($id)
    {
        $attribute = ProductAttribute::with('values')->findOrFail($id);
        return response()->json($attribute->values);
    }
}
