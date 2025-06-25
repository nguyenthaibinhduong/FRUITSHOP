<?php

namespace App\Http\Controllers;

use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use Illuminate\Http\Request;

class ProductAttributeController extends Controller
{
    protected $view_path = 'admin.attribute.';
    protected $route_path = 'attribute';

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
        $request->validate([
            'name' => 'required|string|unique:product_attributes,name',
            'values' => 'required|array|min:1',
            'values.*' => 'required|string|distinct'
        ], [
            'values.required' => 'Vui lòng thêm ít nhất một giá trị thuộc tính.',
            'values.*.required' => 'Giá trị thuộc tính không được để trống.',
            'values.*.distinct' => 'Các giá trị không được trùng nhau.'
        ]);

        $attribute = ProductAttribute::create(['name' => $request->name]);

        foreach ($request->values as $value) {
            $attribute->values()->create(['value' => trim($value)]);
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
            'values' => 'required|array|min:1',
            'values.*' => 'required|string|distinct'
        ], [
            'values.required' => 'Vui lòng nhập ít nhất một giá trị.',
            'values.*.required' => 'Giá trị thuộc tính không được để trống.',
            'values.*.distinct' => 'Các giá trị không được trùng nhau.'
        ]);

        $attribute = ProductAttribute::with('values')->findOrFail($id);
        $attribute->update(['name' => $request->name]);

        $newValues = collect($request->values)->map(fn($v) => trim($v))->filter();

        // Lấy danh sách giá trị hiện tại
        $existingValues = $attribute->values->pluck('value')->toArray();

        // Tìm giá trị cần xoá
        $valuesToDelete = array_diff($existingValues, $newValues->toArray());
        if (!empty($valuesToDelete)) {
            $attribute->values()->whereIn('value', $valuesToDelete)->delete();
        }

        // Tìm giá trị cần thêm mới
        $valuesToAdd = array_diff($newValues->toArray(), $existingValues);
        foreach ($valuesToAdd as $value) {
            $attribute->values()->create(['value' => $value]);
        }

        if ($request->expectsJson()) {
            return response()->json($attribute->load('values'));
        }

        return redirect()->route('attribute.index')->with('success', 'Cập nhật thành công');
    }

    // Xoá thuộc tính
    public function delete(Request $request, $id)
    {
        $attribute = ProductAttribute::findOrFail($id);
        $attribute->delete();

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Đã xoá thuộc tính']);
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
}
