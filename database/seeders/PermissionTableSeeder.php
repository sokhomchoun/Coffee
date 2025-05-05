<?php

namespace Database\Seeders;

use App\Libraries\AppLibrary;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'title'      => 'Dashboard',
                'name'       => 'dashboard',
                'guard_name' => 'sanctum',
                'url'        => 'dashboard',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'Items',
                'name'       => 'items',
                'guard_name' => 'sanctum',
                'url'        => 'items',
                'created_at' => now(),
                'updated_at' => now(),
                'children'   => [
                    [
                        'title'      => 'Items Create',
                        'name'       => 'items_create',
                        'guard_name' => 'sanctum',
                        'url'        => 'items/create',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Items Edit',
                        'name'       => 'items_edit',
                        'guard_name' => 'sanctum',
                        'url'        => 'items/edit',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Items Delete',
                        'name'       => 'items_delete',
                        'guard_name' => 'sanctum',
                        'url'        => 'items/delete',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Items Show',
                        'name'       => 'items_show',
                        'guard_name' => 'sanctum',
                        'url'        => 'items/show',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                ]
            ],
            [
                'title'      => 'POS',
                'name'       => 'pos',
                'guard_name' => 'sanctum',
                'url'        => 'pos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'POS Orders',
                'name'       => 'pos-orders',
                'guard_name' => 'sanctum',
                'url'        => 'pos-orders',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'Online Orders',
                'name'       => 'online-orders',
                'guard_name' => 'sanctum',
                'url'        => 'online-orders',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'Coupons',
                'name'       => 'coupons',
                'guard_name' => 'sanctum',
                'url'        => 'coupons',
                'created_at' => now(),
                'updated_at' => now(),
                'children'   => [
                    [
                        'title'      => 'Coupons Create',
                        'name'       => 'coupons_create',
                        'guard_name' => 'sanctum',
                        'url'        => 'coupons/create',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Coupons Edit',
                        'name'       => 'coupons_edit',
                        'guard_name' => 'sanctum',
                        'url'        => 'coupons/edit',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Coupons Delete',
                        'name'       => 'coupons_delete',
                        'guard_name' => 'sanctum',
                        'url'        => 'coupons/delete',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Coupons Show',
                        'name'       => 'coupons_show',
                        'guard_name' => 'sanctum',
                        'url'        => 'coupons/show',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                ]
            ],
            [
                'title'      => 'Offers',
                'name'       => 'offers',
                'guard_name' => 'sanctum',
                'url'        => 'offers',
                'created_at' => now(),
                'updated_at' => now(),
                'children'   => [
                    [
                        'title'      => 'Offers Create',
                        'name'       => 'offers_create',
                        'guard_name' => 'sanctum',
                        'url'        => 'offers/create',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Offers Edit',
                        'name'       => 'offers_edit',
                        'guard_name' => 'sanctum',
                        'url'        => 'offers/edit',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Offers Delete',
                        'name'       => 'offers_delete',
                        'guard_name' => 'sanctum',
                        'url'        => 'offers/delete',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Offers Show',
                        'name'       => 'offers_show',
                        'guard_name' => 'sanctum',
                        'url'        => 'offers/show',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                ]
            ],
            [
                'title'      => 'Push Notifications',
                'name'       => 'push-notifications',
                'guard_name' => 'sanctum',
                'url'        => 'push-notifications',
                'created_at' => now(),
                'updated_at' => now(),
                'children'   => [
                    [
                        'title'      => 'Push Notifications Create',
                        'name'       => 'push-notifications_create',
                        'guard_name' => 'sanctum',
                        'url'        => 'push-notifications/create',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Push Notifications Edit',
                        'name'       => 'push-notifications_edit',
                        'guard_name' => 'sanctum',
                        'url'        => 'push-notifications/edit',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Push Notifications Delete',
                        'name'       => 'push-notifications_delete',
                        'guard_name' => 'sanctum',
                        'url'        => 'push-notifications/delete',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Push Notifications Show',
                        'name'       => 'push-notifications_show',
                        'guard_name' => 'sanctum',
                        'url'        => 'push-notifications/show',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                ]
            ],
            [
                'title'      => 'Messages',
                'name'       => 'messages',
                'guard_name' => 'sanctum',
                'url'        => 'messages',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'Subscribers',
                'name'       => 'subscribers',
                'guard_name' => 'sanctum',
                'url'        => 'subscribers',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'Administrators',
                'name'       => 'administrators',
                'guard_name' => 'sanctum',
                'url'        => 'administrators',
                'created_at' => now(),
                'updated_at' => now(),
                'children'   => [
                    [
                        'title'      => 'Administrators Create',
                        'name'       => 'administrators_create',
                        'guard_name' => 'sanctum',
                        'url'        => 'administrators/create',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Administrators Edit',
                        'name'       => 'administrators_edit',
                        'guard_name' => 'sanctum',
                        'url'        => 'administrators/edit',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Administrators Delete',
                        'name'       => 'administrators_delete',
                        'guard_name' => 'sanctum',
                        'url'        => 'administrators/delete',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Administrators Show',
                        'name'       => 'administrators_show',
                        'guard_name' => 'sanctum',
                        'url'        => 'administrators/show',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                ]
            ],
            [
                'title'      => 'Delivery Boys',
                'name'       => 'delivery-boys',
                'guard_name' => 'sanctum',
                'url'        => 'delivery-boys',
                'created_at' => now(),
                'updated_at' => now(),
                'children'   => [
                    [
                        'title'      => 'Delivery Boys Create',
                        'name'       => 'delivery-boys_create',
                        'guard_name' => 'sanctum',
                        'url'        => 'delivery-boys/create',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Delivery Boys Edit',
                        'name'       => 'delivery-boys_edit',
                        'guard_name' => 'sanctum',
                        'url'        => 'delivery-boys/edit',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Delivery Boys Delete',
                        'name'       => 'delivery-boys_delete',
                        'guard_name' => 'sanctum',
                        'url'        => 'delivery-boys/delete',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Delivery Boys Show',
                        'name'       => 'delivery-boys_show',
                        'guard_name' => 'sanctum',
                        'url'        => 'delivery-boys/show',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                ]
            ],
            [
                'title'      => 'Customers',
                'name'       => 'customers',
                'guard_name' => 'sanctum',
                'url'        => 'customers',
                'created_at' => now(),
                'updated_at' => now(),
                'children'   => [
                    [
                        'title'      => 'Customers Create',
                        'name'       => 'customers_create',
                        'guard_name' => 'sanctum',
                        'url'        => 'customers/create',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Customers Edit',
                        'name'       => 'customers_edit',
                        'guard_name' => 'sanctum',
                        'url'        => 'customers/edit',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Customers Delete',
                        'name'       => 'customers_delete',
                        'guard_name' => 'sanctum',
                        'url'        => 'customers/delete',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Customers Show',
                        'name'       => 'customers_show',
                        'guard_name' => 'sanctum',
                        'url'        => 'customers/show',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                ]
            ],
            [
                'title'      => 'Employees',
                'name'       => 'employees',
                'guard_name' => 'sanctum',
                'url'        => 'employees',
                'created_at' => now(),
                'updated_at' => now(),
                'children'   => [
                    [
                        'title'      => 'Employees Create',
                        'name'       => 'employees_create',
                        'guard_name' => 'sanctum',
                        'url'        => 'employees/create',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Employees Edit',
                        'name'       => 'employees_edit',
                        'guard_name' => 'sanctum',
                        'url'        => 'employees/edit',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Employees Delete',
                        'name'       => 'employees_delete',
                        'guard_name' => 'sanctum',
                        'url'        => 'employees/delete',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Employees Show',
                        'name'       => 'employees_show',
                        'guard_name' => 'sanctum',
                        'url'        => 'employees/show',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                ]
            ],
            [
                'title'      => 'Transactions',
                'name'       => 'transactions',
                'guard_name' => 'sanctum',
                'url'        => 'transactions',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'Sales Report',
                'name'       => 'sales-report',
                'guard_name' => 'sanctum',
                'url'        => 'sales-report',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'Items Report',
                'name'       => 'items-report',
                'guard_name' => 'sanctum',
                'url'        => 'items-report',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'Credit Balance Report',
                'name'       => 'credit-balance-report',
                'guard_name' => 'sanctum',
                'url'        => 'credit-balance-report',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'Settings',
                'name'       => 'settings',
                'guard_name' => 'sanctum',
                'url'        => 'settings',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'title'      => 'Variation',
                'name'       => 'variation',
                'guard_name' => 'sanctum',
                'url'        => 'variation',
                'created_at' => now(),
                'updated_at' => now(),
                'children'   => [
                    [
                        'title'      => 'Variation Create',
                        'name'       => 'variation_create',
                        'guard_name' => 'sanctum',
                        'url'        => 'variation/create',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Variation Edit',
                        'name'       => 'variation_edit',
                        'guard_name' => 'sanctum',
                        'url'        => 'variation/edit',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Variation Delete',
                        'name'       => 'variation_delete',
                        'guard_name' => 'sanctum',
                        'url'        => 'variation/delete',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],

                ]
            ],
            [
                'title'      => 'Stocks',
                'name'       => 'Stocks',
                'guard_name' => 'sanctum',
                'url'        => 'stocks',
                'created_at' => now(),
                'updated_at' => now(),
                'children'   => [
                    [
                        'title'      => 'Stock Create',
                        'name'       => 'stock_create',
                        'guard_name' => 'sanctum',
                        'url'        => 'stock/create',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Stock Edit',
                        'name'       => 'Stock_edit',
                        'guard_name' => 'sanctum',
                        'url'        => 'stock/edit',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'stock Delete',
                        'name'       => 'stock_delete',
                        'guard_name' => 'sanctum',
                        'url'        => 'stock/delete',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],

                ]
            ],
            [
                'title'      => 'StockAlert',
                'name'       => 'StockAlert',
                'guard_name' => 'sanctum',
                'url'        => 'stockalert',
                'created_at' => now(),
                'updated_at' => now(),
                'children'   => [
                    [
                        'title'      => 'StockAlert Create',
                        'name'       => 'stockalert_create',
                        'guard_name' => 'sanctum',
                        'url'        => 'stockalert/create',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'StockAlert Edit',
                        'name'       => 'StockAlert_edit',
                        'guard_name' => 'sanctum',
                        'url'        => 'stockalert/edit',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'StockAlert Delete',
                        'name'       => 'stockalert_delete',
                        'guard_name' => 'sanctum',
                        'url'        => 'stockalert/delete',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],

                ]
            ],
            [
                'title'      => 'Products',
                'name'       => 'product',
                'guard_name' => 'sanctum',
                'url'        => 'product',
                'created_at' => now(),
                'updated_at' => now(),
                'children'   => [
                    [
                        'title'      => 'Product Create',
                        'name'       => 'product_create',
                        'guard_name' => 'sanctum',
                        'url'        => 'product/create',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Product Edit',
                        'name'       => 'Product_edit',
                        'guard_name' => 'sanctum',
                        'url'        => 'product/edit',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Product Delete',
                        'name'       => 'product_delete',
                        'guard_name' => 'sanctum',
                        'url'        => 'product/delete',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],

                ]
            ],
            [
                'title'      => 'Brands',
                'name'       => 'brand',
                'guard_name' => 'sanctum',
                'url'        => 'brand',
                'created_at' => now(),
                'updated_at' => now(),
                'children'   => [
                    [
                        'title'      => 'Brand Create',
                        'name'       => 'brand_create',
                        'guard_name' => 'sanctum',
                        'url'        => 'brand/create',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Brand Edit',
                        'name'       => 'brand_edit',
                        'guard_name' => 'sanctum',
                        'url'        => 'brand/edit',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Brand Delete',
                        'name'       => 'brand_delete',
                        'guard_name' => 'sanctum',
                        'url'        => 'brand/delete',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],

                ]
            ],
            [
                'title'      => 'Product Unit',
                'name'       => 'unit',
                'guard_name' => 'sanctum',
                'url'        => 'unit',
                'created_at' => now(),
                'updated_at' => now(),
                'children'   => [
                    [
                        'title'      => 'Unit Create',
                        'name'       => 'unit_create',
                        'guard_name' => 'sanctum',
                        'url'        => 'unit/create',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Unit Edit',
                        'name'       => 'unit_edit',
                        'guard_name' => 'sanctum',
                        'url'        => 'unit/edit',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Unit Delete',
                        'name'       => 'unit_delete',
                        'guard_name' => 'sanctum',
                        'url'        => 'unit/delete',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],

                ]
            ],
            [
                'title'      => 'Supplier',
                'name'       => 'supplier',
                'guard_name' => 'sanctum',
                'url'        => 'supplier',
                'created_at' => now(),
                'updated_at' => now(),
                'children'   => [
                    [
                        'title'      => 'Supplier Create',
                        'name'       => 'supplier_create',
                        'guard_name' => 'sanctum',
                        'url'        => 'supplier/create',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Supplier Edit',
                        'name'       => 'supplier_edit',
                        'guard_name' => 'sanctum',
                        'url'        => 'supplier/edit',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Supplier Delete',
                        'name'       => 'supplier_delete',
                        'guard_name' => 'sanctum',
                        'url'        => 'supplier/delete',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],

                ]
            ],
            [
                'title'      => 'Purchase Orders',
                'name'       => 'purchase_orders',
                'guard_name' => 'sanctum',
                'url'        => 'purchase_orders',
                'created_at' => now(),
                'updated_at' => now(),
                'children'   => [
                    [
                        'title'      => 'Purchase Orders Create',
                        'name'       => 'purchase_orders_create',
                        'guard_name' => 'sanctum',
                        'url'        => 'purchase_orders/create',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Purchase Orders Edit',
                        'name'       => 'purchase_orders_edit',
                        'guard_name' => 'sanctum',
                        'url'        => 'purchase_orders/edit',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title'      => 'Purchase Orders Delete',
                        'name'       => 'purchase_orders_delete',
                        'guard_name' => 'sanctum',
                        'url'        => 'purchase_orders/delete',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],

                ]
            ],

        ];

        $permissions = AppLibrary::associativeToNumericArrayBuilder($permissions);
        Permission::insert($permissions);
    }
}
