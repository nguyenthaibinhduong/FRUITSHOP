<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class BaseApiController extends Controller
{
    protected $model;

    public function index(Request $request)
    {
        try {
            $query = $this->model::query();

            // 1. Tìm kiếm theo key và value
            if ($request->filled('keySearch') && $request->filled('valueSearch')) {
                $query->where($request->keySearch, 'like', '%' . $request->valueSearch . '%');
            }

            // 2. Lọc theo trường bất kỳ
            if ($request->filled('filters')) {
                foreach ($request->filters as $field => $value) {
                    if (is_array($value)) {
                        $query->whereIn($field, $value);
                    } else {
                        $query->where($field, $value);
                    }
                }
            }

            // 3. Sắp xếp
            if ($request->filled('orderBy') && $request->filled('orderType')) {
                $query->orderBy($request->orderBy, $request->orderType); // ASC | DESC
            }

            // 4. Lấy quan hệ
            if ($request->filled('with')) {
                $relations = explode(',', $request->with);
                $query->with($relations);
            }

            // 5. Ẩn trường
            if ($request->filled('hiddenFields')) {
                $fields = explode(',', $request->hiddenFields);
                $query->select(array_diff($this->model::getModel()->getFillable(), $fields));
            }

            // 6. Phân trang
            $perPage = $request->get('per_page', $request->limit ?? 10); // Mặc định 10 bản ghi
            $data = $query->paginate($perPage);

            return ResponseHelper::success($data, 'Lấy danh sách thành công');
        } catch (Exception $e) {
            return ResponseHelper::error($e->getMessage(), 500);
        }
    }


    public function store(Request $request)
    {
        try {

            $item = $this->model::create($request->all());
            return ResponseHelper::success($item, 'Tạo mới thành công', 201);
        } catch (Exception $e) {
            return ResponseHelper::error($e->getMessage(), 500);
        }
    }

    public function show($id, Request $request)
    {
        try {
            $query = $this->model::query();

            if ($request->filled('with')) {
                $relations = explode(',', $request->with);
                $query->with($relations);
            }

            $item = $query->findOrFail($id); // Dùng chính query đã cấu hình
            return ResponseHelper::success($item, 'Lấy chi tiết thành công');
        } catch (ModelNotFoundException $e) {
            return ResponseHelper::error('Không tìm thấy dữ liệu', 404);
        } catch (Exception $e) {
            return ResponseHelper::error($e->getMessage(), 500);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $item = $this->model::findOrFail($id);
            $item->update($request->all());
            return ResponseHelper::success($item, 'Cập nhật thành công');
        } catch (ModelNotFoundException $e) {
            return ResponseHelper::error('Không tìm thấy dữ liệu', 404);
        } catch (Exception $e) {
            return ResponseHelper::error($e->getMessage(), 500);
        }
    }

    public function destroy($id)
    {
        try {
            $item = $this->model::findOrFail($id);
            $item->delete();
            return ResponseHelper::success(null, 'Xóa thành công');
        } catch (ModelNotFoundException $e) {
            return ResponseHelper::error('Không tìm thấy dữ liệu', 404);
        } catch (Exception $e) {
            return ResponseHelper::error($e->getMessage(), 500);
        }
    }
}
