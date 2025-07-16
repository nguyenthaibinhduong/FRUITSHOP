<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Position;

class PositionSeeder extends Seeder
{
    public function run(): void
    {
        $positions = [
            [
                'name' => 'Header',
                'code' => 'header',
                'type' => 1,
                'row' => 1,
                'col' => 1,
                'width' => 12,
                'width_sm' => 12,
                'width_md' => 12,
                'width_lg' => 12,
                'align' => 'center',
                'order' => 1,
            ],
            [
                'name' => 'Banner Top',
                'code' => 'banner_top',
                'type' => 1,
                'row' => 2,
                'col' => 1,
                'width' => 12,
                'width_sm' => 12,
                'width_md' => 12,
                'width_lg' => 12,
                'align' => 'center',
                'order' => 1,
            ],
            [
                'name' => 'Sidebar Left',
                'code' => 'sidebar_left',
                'type' => 1,
                'row' => 3,
                'col' => 1,
                'width' => 3,
                'width_sm' => 12,
                'width_md' => 6,
                'width_lg' => 3,
                'align' => 'left',
                'order' => 1,
            ],
            [
                'name' => 'Main Content',
                'code' => 'main_content',
                'type' => 1,
                'row' => 3,
                'col' => 2,
                'width' => 9,
                'width_sm' => 12,
                'width_md' => 6,
                'width_lg' => 9,
                'align' => 'left',
                'order' => 1,
            ],
            [
                'name' => 'Footer',
                'code' => 'footer',
                'type' => 1,
                'row' => 5,
                'col' => 1,
                'width' => 12,
                'width_sm' => 12,
                'width_md' => 12,
                'width_lg' => 12,
                'align' => 'center',
                'order' => 1,
            ],
        ];

        foreach ($positions as $position) {
            Position::create($position);
        }
    }
}
