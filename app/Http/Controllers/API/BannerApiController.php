<?php

namespace App\Http\Controllers\API;

use App\Models\Banner;

class BannerApiController extends BaseApiController
{
    public function __construct()
    {
        $this->model = Banner::class;
    }
}
