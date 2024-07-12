<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'super-admin', 'display_name' => 'Super Admin', 'group' => 'system'],
            ['name' => 'admin', 'display_name' => 'Admin', 'group' => 'system'],

            ['name' => 'employee', 'display_name' => 'employee', 'group' => 'system'],

            ['name' => 'manager', 'display_name' => 'manager', 'group' => 'system'],

            ['name' => 'user', 'display_name' => 'user', 'group' => 'client'],

        ];
        $permissions = [
            ['name' => 'create-user', 'display_name' => 'Create user', 'group' => 'User'],
            ['name' => 'update-user', 'display_name' => 'Update user', 'group' => 'User'],
            ['name' => 'show-user', 'display_name' => 'Show user', 'group' => 'User'],
            ['name' => 'delete-user', 'display_name' => 'Delete user', 'group' => 'User'],

            ['name' => 'create-role', 'display_name' => 'Create Role', 'group' => 'Role'],
            ['name' => 'update-role', 'display_name' => 'Update Role', 'group' => 'Role'],
            ['name' => 'show-role', 'display_name' => 'Show Role', 'group' => 'Role'],
            ['name' => 'delete-role', 'display_name' => 'Delete Role', 'group' => 'Role'],

            ['name' => 'create-category', 'display_name' => 'Create category', 'group' => 'category'],
            ['name' => 'update-category', 'display_name' => 'Update category', 'group' => 'category'],
            ['name' => 'show-category', 'display_name' => 'Show category', 'group' => 'category'],
            ['name' => 'delete-category', 'display_name' => 'Delete category', 'group' => 'category'],

            ['name' => 'create-brand', 'display_name' => 'Create brand', 'group' => 'brand'],
            ['name' => 'update-brand', 'display_name' => 'Update brand', 'group' => 'brand'],
            ['name' => 'show-brand', 'display_name' => 'Show brand', 'group' => 'brand'],
            ['name' => 'delete-brand', 'display_name' => 'Delete brand', 'group' => 'brand'],

            ['name' => 'create-product', 'display_name' => 'Create product', 'group' => 'product'],
            ['name' => 'update-product', 'display_name' => 'Update product', 'group' => 'product'],
            ['name' => 'show-product', 'display_name' => 'Show product', 'group' => 'product'],
            ['name' => 'delete-product', 'display_name' => 'Delete product', 'group' => 'product'],

            ['name' => 'create-coupon', 'display_name' => 'Create coupon', 'group' => 'coupon'],
            ['name' => 'update-coupon', 'display_name' => 'Update coupon', 'group' => 'coupon'],
            ['name' => 'show-coupon', 'display_name' => 'Show coupon', 'group' => 'coupon'],
            ['name' => 'delete-coupon', 'display_name' => 'Delete coupon', 'group' => 'coupon'],

            ['name' => 'create-banner', 'display_name' => 'Create banner', 'group' => 'banner'],
            ['name' => 'update-banner', 'display_name' => 'Update banner', 'group' => 'banner'],
            ['name' => 'show-banner', 'display_name' => 'Show banner', 'group' => 'banner'],
            ['name' => 'delete-banner', 'display_name' => 'Delete banner', 'group' => 'banner'],
            
            ['name' => 'create-post', 'display_name' => 'Create post', 'group' => 'post'],
            ['name' => 'update-post', 'display_name' => 'Update post', 'group' => 'post'],
            ['name' => 'show-post', 'display_name' => 'Show post', 'group' => 'post'],
            ['name' => 'delete-post', 'display_name' => 'Delete post', 'group' => 'post'],

            ['name' => 'create-type', 'display_name' => 'Create type', 'group' => 'type'],
            ['name' => 'update-type', 'display_name' => 'Update type', 'group' => 'type'],
            ['name' => 'show-type', 'display_name' => 'Show type', 'group' => 'type'],
            ['name' => 'delete-type', 'display_name' => 'Delete type', 'group' => 'type'],

            ['name' => 'list-customer', 'display_name' => 'list customer', 'group' => 'orders'],
            ['name' => 'list-order', 'display_name' => 'list order', 'group' => 'orders'],
            ['name' => 'update-order-status', 'display_name' => 'Update order status', 'group' => 'orders'],

            ['name' => 'list-mail', 'display_name' => 'list mail', 'group' => 'mails'],
            ['name' => 'send-mail', 'display_name' => 'send mail', 'group' => 'mails'],
            ['name' => 'delete-mail', 'display_name' => 'delete mail', 'group' => 'mails'],
            
        ];

        
        foreach($roles as $role){
            Role::updateOrCreate($role);
        }
        
        foreach($permissions as $item){
            Permission::updateOrCreate($item);
        }
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'), // Mã hóa mật khẩu // Giả sử bạn có một cột is_admin để xác định người dùng là admin
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('role_user')->insert([
            'user_id'=>1,
            'role_id'=>1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $i=1;
        foreach($permissions as $item){
            DB::table('permission_role')->insert(['role_id'=>1,'permission_id'=>$i,'created_at' => now(),'updated_at' => now(),]);
            $i++;
        }
        
        
    }
}