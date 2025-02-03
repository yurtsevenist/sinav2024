<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Admin;
use App\Models\Permission;
use App\Models\RolePermission;
use App\Models\AdminRole;
use Illuminate\Database\Seeder;

class RoleAndPermissionSeeder extends Seeder
{
    public function run()
    {
        // Roller
        $roles = [
            [
                'name' => 'Süper Admin',
                'description' => 'Tüm yetkilere sahip yönetici'
            ],
            [
                'name' => 'Ürün Yöneticisi',
                'description' => 'Ürün ve kategori yönetimi yapabilen yönetici'
            ],
            [
                'name' => 'Sipariş Yöneticisi',
                'description' => 'Sipariş ve ödeme yönetimi yapabilen yönetici'
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

        // İzinler
        $permissions = [
            // Ürün yönetimi
            ['name' => 'Ürün Görüntüleme', 'code' => 'view_products', 'module' => 'products'],
            ['name' => 'Ürün Ekleme', 'code' => 'create_products', 'module' => 'products'],
            ['name' => 'Ürün Düzenleme', 'code' => 'edit_products', 'module' => 'products'],
            ['name' => 'Ürün Silme', 'code' => 'delete_products', 'module' => 'products'],

            // Kategori yönetimi
            ['name' => 'Kategori Görüntüleme', 'code' => 'view_categories', 'module' => 'categories'],
            ['name' => 'Kategori Ekleme', 'code' => 'create_categories', 'module' => 'categories'],
            ['name' => 'Kategori Düzenleme', 'code' => 'edit_categories', 'module' => 'categories'],
            ['name' => 'Kategori Silme', 'code' => 'delete_categories', 'module' => 'categories'],

            // Sipariş yönetimi
            ['name' => 'Sipariş Görüntüleme', 'code' => 'view_orders', 'module' => 'orders'],
            ['name' => 'Sipariş Düzenleme', 'code' => 'edit_orders', 'module' => 'orders'],
            ['name' => 'Sipariş Silme', 'code' => 'delete_orders', 'module' => 'orders'],

            // Kullanıcı yönetimi
            ['name' => 'Kullanıcı Görüntüleme', 'code' => 'view_users', 'module' => 'users'],
            ['name' => 'Kullanıcı Ekleme', 'code' => 'create_users', 'module' => 'users'],
            ['name' => 'Kullanıcı Düzenleme', 'code' => 'edit_users', 'module' => 'users'],
            ['name' => 'Kullanıcı Silme', 'code' => 'delete_users', 'module' => 'users'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        // Süper Admin'e tüm izinleri ver
        $superAdminRole = Role::where('name', 'Süper Admin')->first();
        $allPermissions = Permission::all();
        
        foreach ($allPermissions as $permission) {
            RolePermission::create([
                'role_id' => $superAdminRole->id,
                'permission_id' => $permission->id
            ]);
        }

        // Ürün Yöneticisi izinleri
        $productManagerRole = Role::where('name', 'Ürün Yöneticisi')->first();
        $productPermissions = Permission::whereIn('module', ['products', 'categories'])->get();
        
        foreach ($productPermissions as $permission) {
            RolePermission::create([
                'role_id' => $productManagerRole->id,
                'permission_id' => $permission->id
            ]);
        }

        // Sipariş Yöneticisi izinleri
        $orderManagerRole = Role::where('name', 'Sipariş Yöneticisi')->first();
        $orderPermissions = Permission::where('module', 'orders')->get();
        
        foreach ($orderPermissions as $permission) {
            RolePermission::create([
                'role_id' => $orderManagerRole->id,
                'permission_id' => $permission->id
            ]);
        }

        // Yöneticilere rol atama
        $superAdmin = Admin::where('username', 'superadmin')->first();
        $productManager = Admin::where('username', 'productmanager')->first();
        $orderManager = Admin::where('username', 'ordermanager')->first();

        AdminRole::create([
            'admin_id' => $superAdmin->id,
            'role_id' => $superAdminRole->id
        ]);

        AdminRole::create([
            'admin_id' => $productManager->id,
            'role_id' => $productManagerRole->id
        ]);

        AdminRole::create([
            'admin_id' => $orderManager->id,
            'role_id' => $orderManagerRole->id
        ]);
    }
} 