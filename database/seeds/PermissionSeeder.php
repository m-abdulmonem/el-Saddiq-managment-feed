<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * instance [admin] user
         */
        $user = User::find(1);
        /**
         * create permissions
         */
        $cruds = [
            'create' => 'إنشاء',
            'read' => 'عرض',
            'update' => 'تعديل',
            'delete' => 'حذف'
        ];
        $perms = [
            'user' => 'مشرف',
            'client' => 'عميل',
            'client_bill' => 'فاتورة عميل',
            'client_balance' => 'حساب عميل',
            'client_graph' => 'تقرير عميل',
            'category' => 'تصنيف',
            'product' => 'منتج',
            'product_history' => 'سجل المنتج',
            'product_price_history' => 'سجل اسعار المنتج',
            'stock' => 'المخزن',
            'supplier' => 'المورد',
            'supplier_bill' => 'فاتورة المورد',
            'supplier_balance' => 'حساب المورد',
            'attendance' => 'الحضور والإنصراف',
            'balance' => 'الحسابات العامة ',
            'job' => 'الوظيفة',
            'chick' => 'الكتاكيت',
            'chick_order' => 'طلبات الكتاكيت',
            'chick_booking' => 'حجوزات الكتاكيت',
            //20-12-2020
            'salary' => 'المرتبات',
            'expenses' => 'المصروفات',
            'receipts' => 'المقبوضات',
            'payments' => 'المدفوعات ',
            'banks' => 'بنوك',
            'daily' => 'اليومية',
            'medicine' => 'الادوية',
            'setting' => 'الادوية',

        ];
        foreach ($perms as $perm_key => $perm){
            foreach ($cruds as $crud_key => $crud) {
                Permission::insert([
                    'name' => "$crud_key $perm_key",
                    'name_ar' => "$crud $perm",
                    'guard_name' => 'web',
                    'created_at' => now()
                ]);

                /**
                 * give permissions to user
                 */
                $user->givePermissionTo([
                    "$crud_key $perm_key"
                ]);
            }
        }
    }
}
