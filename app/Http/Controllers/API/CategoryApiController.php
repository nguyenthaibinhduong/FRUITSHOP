<?php

namespace App\Http\Controllers\API;

use App\Models\Category;

class CategoryApiController extends BaseApiController
{
    public function __construct()
    {
        $this->model = Category::class;
    }
}
