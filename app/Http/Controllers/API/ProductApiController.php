<?php

namespace App\Http\Controllers\API;

use App\Models\Product;

class ProductApiController extends BaseApiController
{
    public function __construct()
    {
        $this->model = Product::class;
    }
}
