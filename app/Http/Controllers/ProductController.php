<?php

namespace App\Http\Controllers;

use App\Components\Recusive;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\ProductVariantAttribute;
use Carbon\Exceptions\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    protected $view_path = 'admin.product.';
    protected $route_path = 'product';
    protected $upload_path = 'img/product';
    protected $category;
    protected $brand;
    /**
     * Display a listing of the resource.
     */
    public function __construct(Category $category, Brand $brand)
    {
        $this->category = $category;
        $this->brand = $brand;
    }
    public function getCategories($parent_id)
    {
        $data = $this->category->all();
        $recusive = new Recusive($data);
        $option = $recusive->categoryRecusive($parent_id);
        return $option;
    }
    public function index()
    {
        $categories = Category::all();
        $selected_categories = DB::table('product_categories')->get();
        $images = ProductImage::where('image_type', 0)->get();
        $products = Product::with('variants')->paginate(11);
        $attributes = ProductAttribute::with('values')->get();
        // dd($products);
        return view($this->view_path . 'index', compact('products', 'images', 'selected_categories', 'categories', 'attributes'));
    }
    public function showComment($id)
    {
        $product = Product::find($id);
        $comments = $product->comments()->orderBy('created_at', 'desc')->paginate(5);
        return view('admin.product.comment', compact('comments'));
    }
    public function deleteComment($id)
    {
        try {
            Comment::find($id)->delete();
            return redirect()->back()->with('success', 'Xóa thành công');
        } catch (\Exception $e) {
            // Handle other exceptions
            return back()->with('danger', 'Đã xảy ra lỗi. Vui lòng thử lại.')->withInput();
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = $this->brand->all();
        $option = $this->getCategories($parent_id = '');
        $attributes = ProductAttribute::with('values')->get();
        return view($this->view_path . 'create', compact('brands', 'option', 'attributes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());
        //try {
        $rules = [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:1000|max:10000000',
            'sale_percent' => 'numeric|min:0|max:100',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required',
            'brand_id' => 'required|exists:brands,id',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'thump' => 'array',
            'thump.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
        if ($request->has('is_variable') && $request->is_variable === 'on') {
            unset($rules['price']);
            unset($rules['quantity']);
        }

        // Custom error messages
        $messages = [
            'required' => 'Bắt buộc nhập',
            'string' => 'Phải là kiểu kí tự',
            'numeric' => 'Phải là kiểu số',
            'integer' => 'Phải là số nguyên',
            'min' => 'Giá trị quá nhỏ',
            'max' => 'Giá trị vượt quá cho phép',
            'image' => 'Phải là file ảnh',
            'mimes' => 'Định dạng không hợp lệ',
            'exists' => 'Giá trị không tồn tại',
            'thump.array' => 'Phải là mảng',
            'thump.*.image' => 'Từng mục phải là file ảnh',
            'thump.*.mimes' => 'Từng mục phải có định dạng hợp lệ',
            'thump.*.max' => 'Từng mục có kích thước vượt quá cho phép',
        ];

        // Validate the request
        $validator = Validator::make($request->all(), $rules, $messages);

        // If validation fails, return back with errors
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price ?? 0;
        $product->sale_percent = 1 - $request->sale_percent / 100;
        $product->quantity = $request->quantity ?? 0;
        $product->description = $request->description ?? ' ';
        $product->longdescription = $request->longdescription ?? ' ';
        $product->brand_id = $request->brand_id;
        $product->has_variants = ($request->has('is_variable') && $request->is_variable === 'on') ? 1 : 0;
        $product->uploaded = $request->uploaded;
        $product->save();

        foreach ($request->category_id as $id) {
            $product->categories()->attach($id);
        }

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path($this->upload_path), $imageName);
            $url = $this->upload_path . '/' . $imageName;
            $productimage = new ProductImage();
            $productimage->url =  $url;
            $productimage->product_id =  $product->id;
            $productimage->save();
        }
        if ($request->type_update != null) {
            $stt = 1;
            foreach ($request->file('thump') as $image) {
                $imageName = time() . '_thump_' . $stt . '.' . $image->extension();
                $image->move(public_path($this->upload_path), $imageName);
                $url = $this->upload_path . '/' . $imageName;
                $productimage = new ProductImage();
                $productimage->url =  $url;
                $productimage->product_id =  $product->id;
                $productimage->image_type =  1;
                $productimage->save();
                $stt++;
            }
        }
        if ($request->has('is_variable') && $request->is_variable === 'on') {
            foreach ($request->variants as $variant) {
                $variantModel = new ProductVariant();
                $variantModel->product_id = $product->id;
                $variantModel->sku = $variant['sku'] ?? null;
                $variantModel->price = $variant['price'] ?? 0;
                $variantModel->sale_percent = $variant['sale_percent'] ?? 0;
                $variantModel->stock = $variant['stock'] ?? 0;
                $variantModel->uploaded = $variant['uploaded'] ?? 0;

                $variantModel->save();

                // Lưu các giá trị thuộc tính cho biến thể
                $attributes = json_decode($variant['attributes'], true);
                foreach ($attributes as $attr) {
                    ProductVariantAttribute::create([
                        'variant_id' => $variantModel->id,
                        'attribute_id' => $attr['attr_id'],
                        'value_id' => $attr['value_id'],
                    ]);
                }
            }
        }
        return redirect()->back()->with('success', 'Thêm thành công');
        // } catch (\Exception $e) {
        //     // Handle other exceptions
        //     return back()->with('danger', 'Đã xảy ra lỗi. Vui lòng thử lại.')->withInput();
        //}
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $selected_categories = DB::table('product_categories')
            ->where('product_id', $id)
            ->pluck('category_id')->toArray();
        $categories = Category::all();
        $brands = $this->brand->all();
        $option = $this->getCategories($parent_id = '');
        $images = ProductImage::where('product_id', $id)->get();
        $product = Product::with('variants.attributes.attribute', 'variants.attributes.value')->find($id);
        //dd($product->toJson());
        $attributes = ProductAttribute::with('values')->get();
        // dd($attributes, $product);
        return view($this->view_path . 'edit', compact('product', 'images', 'selected_categories', 'categories', 'brands', 'attributes', 'option'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // try {


        $rules = [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:1000|max:10000000',
            'sale_percent' => 'numeric|min:0|max:100',
            'quantity' => 'required|integer|min:0',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'thump' => 'array',
            'thump.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        if ($request->has('is_variable') && $request->is_variable === 'on') {
            unset($rules['price']);
            unset($rules['quantity']);
            unset($rules['sale_percent']);
        }

        // Custom error messages
        $messages = [
            'required' => 'Bắt buộc nhập',
            'string' => 'Phải là kiểu kí tự',
            'numeric' => 'Phải là kiểu số',
            'integer' => 'Phải là số nguyên',
            'min' => 'Giá trị quá nhỏ',
            'max' => 'Giá trị vượt quá cho phép',
            'image' => 'Phải là file ảnh',
            'mimes' => 'Định dạng không hợp lệ',
            'exists' => 'Giá trị không tồn tại',
            'thump.array' => 'Phải là mảng',
            'thump.*.image' => 'Từng mục phải là file ảnh',
            'thump.*.mimes' => 'Từng mục phải có định dạng hợp lệ',
            'thump.*.max' => 'Từng mục có kích thước vượt quá cho phép',
        ];
        // Validate the request
        $validator = Validator::make($request->all(), $rules, $messages);

        // If validation fails, return back with errors
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $product = Product::find($id);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path($this->upload_path), $imageName);
            $url = $this->upload_path . '/' . $imageName;
            ProductImage::where('product_id', $id)
                ->where('image_type', 0)
                ->update([
                    'url' => $url
                ]);
        }
        if ($request->type_update != null) {
            if ($request->hasFile('thump')) {
                $this->updateThump($request->type_update, $request->file('thump'), $id);
            } else {
                $this->updateThump($request->type_update, null, $id);
            }
        }

        DB::table('product_categories')->where('product_id', $id)->delete();
        foreach ($request->category_id ?? [] as $category_id) {
            $product->categories()->attach($category_id);
        }
        $product->update([
            'name' => $request->name,
            'price' => $request->price ?? 0,
            'description' => $request->description ?? ' ',
            'longdescription' => $request->longdescription ?? ' ',
            'sale_percent' => $request->sale_percent ?? 0,
            'quantity' => $request->quantity ?? 0,
            'brand_id' => $request->brand_id,
            'has_variants' => $request->has('is_variable') && $request->is_variable === 'on' ? 1 : 0,
            'uploaded' => $request->uploaded,
        ]);

        if ($request->has('variants')) {
            $productVariantIds = [];

            $productVariantIds = [];

            foreach ($request->variants ?? [] as $variantData) {
                $attributes = json_decode($variantData['attributes'], true) ?? [];

                // Chuẩn hóa thuộc tính từ request
                $attributes = array_map(function ($a) {
                    return [
                        'attribute_id' => (int) $a['attribute_id'],
                        'value_id' => (int) $a['value_id'],
                    ];
                }, $attributes);

                // Sort để chuẩn hóa thứ tự
                usort($attributes, fn($a, $b) => $a['attribute_id'] <=> $b['attribute_id']);

                $existingVariant = null;

                foreach ($product->variants as $v) {
                    $vAttrs = $v->attributes->map(function ($a) {
                        return [
                            'attribute_id' => (int) $a->attribute_id,
                            'value_id' => (int) $a->value_id,
                        ];
                    })->toArray();

                    usort($vAttrs, fn($a, $b) => $a['attribute_id'] <=> $b['attribute_id']);

                    if ($attributes == $vAttrs) {
                        $existingVariant = $v;
                        break;
                    }
                }

                if ($existingVariant) {
                    // Cập nhật variant cũ
                    $existingVariant->update([
                        'sku' => $variantData['sku'] ?? null,
                        'price' => $variantData['price'] ?? 0,
                        'sale_percent' => $variantData['sale_percent'] ?? 0,
                        'stock' => $variantData['stock'] ?? 0,
                        'uploaded' => $variantData['uploaded'] ?? 0,
                    ]);

                    if (isset($variantData['image']) && $variantData['image']) {
                        $img = $variantData['image'];
                        $imageName = time() . '_' . rand(1000, 9999) . '.' . $img->extension();
                        $img->move(public_path($this->upload_path), $imageName);
                        $existingVariant->update(['image' => $imageName]);
                    }

                    $productVariantIds[] = $existingVariant->id;
                } else {
                    // Thêm mới variant
                    $newVariant = $product->variants()->create([
                        'sku' => $variantData['sku'] ?? null,
                        'price' => $variantData['price'] ?? 0,
                        'sale_percent' => $variantData['sale_percent'] ?? 0,
                        'stock' => $variantData['stock'] ?? 0,
                        'uploaded' => $variantData['uploaded'] ?? 0,
                    ]);

                    if (isset($variantData['image']) && $variantData['image']) {
                        $img = $variantData['image'];
                        $imageName = time() . '_' . rand(1000, 9999) . '.' . $img->extension();
                        $img->move(public_path($this->upload_path), $imageName);
                        $newVariant->update(['image' => $imageName]);
                    }

                    foreach ($attributes as $attr) {
                        $newVariant->attributes()->create([
                            'attribute_id' => $attr['attribute_id'],
                            'value_id' => $attr['value_id'],
                        ]);
                    }

                    $productVariantIds[] = $newVariant->id;
                }
            }

            // Nếu muốn xóa những variant cũ không còn nằm trong danh sách:
            $product->variants()->whereNotIn('id', $productVariantIds)->delete();


            // XÓA các variant không có trong danh sách nữa
            $product->variants()->whereNotIn('id', $productVariantIds)->delete();
        }



        return redirect()->route($this->route_path)->with('success', 'Cập nhật thành công');
        // } catch (\Exception $e) {
        //     dd($e->getMessage());
        //     return back()->with('danger', 'Đã xảy ra lỗi. Vui lòng thử lại.');
        // }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        try {
            $images = ProductImage::where('product_id', $id)->get();
            foreach ($images as $image) {
                // unlink($image->url);
                $image->delete();
            }
            $product = Product::find($id);
            $product->delete();
            return redirect()->back()->with('success', 'Đã xóa thành công');
        } catch (\Exception $e) {
            // Handle other exceptions
            return back()->with('danger', 'Đã xảy ra lỗi. Vui lòng thử lại.');
        }
    }
    public function updateThump($select_update, $thump = null, $id)
    {
        switch ($select_update) {
            case 'add':
                $stt = 1;
                foreach ($thump as $image) {
                    $imageName = time() . '_thump_' . $stt . '.' . $image->extension();
                    $image->move(public_path($this->upload_path), $imageName);
                    $url = $this->upload_path . '/' . $imageName;
                    $productimage = new ProductImage();
                    $productimage->url =  $url;
                    $productimage->product_id =  $id;
                    $productimage->image_type =  1;
                    $productimage->save();
                    $stt++;
                }
                break;
            case 'delete':
                $image = ProductImage::where('product_id', $id)
                    ->where('image_type', 1)
                    ->get();
                foreach ($image as $img) {
                    unlink($img->url);
                    $img->delete();
                }
                break;
            case 'delete-add':
                $image = ProductImage::where('product_id', $id)
                    ->where('image_type', 1)
                    ->get();
                foreach ($image as $img) {
                    unlink($img->url);
                    $img->delete();
                }
                $stt = 1;
                foreach ($thump as $image) {
                    $imageName = time() . '_thump_' . $stt . '.' . $image->extension();
                    $image->move(public_path($this->upload_path), $imageName);
                    $url = $this->upload_path . '/' . $imageName;
                    $productimage = new ProductImage();
                    $productimage->url =  $url;
                    $productimage->product_id =  $id;
                    $productimage->image_type =  1;
                    $productimage->save();
                    $stt++;
                }
                break;
            default:
                $image = ProductImage::find($select_update);
                unlink($image->url);
                $image->delete();
        }
    }
}
