<?php

namespace App\Http\Controllers\API;

use App\Models\Brand;

class BrandApiController extends BaseApiController
{
    public function __construct()
    {
        $this->model = Brand::class;
    }
}
