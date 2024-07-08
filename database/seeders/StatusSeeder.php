<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses=[
            ['name'=>'Đang chờ xử lý'],
            ['name'=>'Đã xác nhận'],
            ['name'=>'Đã thanh toán'],
            ['name'=>'Đang giao hàng'],
            ['name'=>'Hoàn thành'],
            ['name'=>'Thất bại'],
            ['name'=>'Đã hủy'],
            ['name'=>'Đã hoàn tiền'],
            ['name'=>'Đang chờ thanh toán'],
            ['name'=>'Đã trả lại'],
        ];
        foreach($statuses as $status){
            OrderStatus::updateOrCreate($status);
        }
    }
}
