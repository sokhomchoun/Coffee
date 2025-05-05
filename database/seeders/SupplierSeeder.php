<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Supplier::create([
            'name' => 'ABC Supplies Co.',
            'email' => 'abc@example.com',
            'phone_number' => '0123456789',
            'country' => 'Cambodia',
            'city' => 'Phnom Penh',
            'address' => '123 Market Street',
        ]);

        Supplier::create([
            'name' => 'XYZ Traders',
            'email' => 'xyz@example.com',
            'phone_number' => '0987654321',
            'country' => 'Thailand',
            'city' => 'Bangkok',
            'address' => '456 Business Road',
        ]);
    }
}
