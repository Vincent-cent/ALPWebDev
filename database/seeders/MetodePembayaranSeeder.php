<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MetodePembayaran;

class MetodePembayaranSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $methods = [
            // Virtual Account Methods
            [
                'name' => 'BCA Virtual Account',
                'fee' => 4500,
                'type' => 'bank_transfer',
                'logo' => 'payments/bca.png',
                'is_active' => true,
            ],
            [
                'name' => 'BRI Virtual Account',
                'fee' => 4500,
                'type' => 'bank_transfer', 
                'logo' => 'payments/bri.png',
                'is_active' => true,
            ],
            [
                'name' => 'BNI Virtual Account',
                'fee' => 4500,
                'type' => 'bank_transfer',
                'logo' => 'payments/bni.png',
                'is_active' => true,
            ],
            [
                'name' => 'Mandiri Virtual Account',
                'fee' => 4500,
                'type' => 'bank_transfer',
                'logo' => 'payments/mandiri.png',
                'is_active' => true,
            ],
            [
                'name' => 'Permata Virtual Account',
                'fee' => 4500,
                'type' => 'bank_transfer',
                'logo' => 'payments/permata.png',
                'is_active' => true,
            ],
            [
                'name' => 'BNC Virtual Account',
                'fee' => 4500,
                'type' => 'bank_transfer',
                'logo' => 'payments/bnc.png',
                'is_active' => true,
            ],
            [
                'name' => 'Danamon Virtual Account',
                'fee' => 4500,
                'type' => 'bank_transfer',
                'logo' => 'payments/danamon.png',
                'is_active' => true,
            ],
            [
                'name' => 'CIMB Virtual Account',
                'fee' => 4500,
                'type' => 'bank_transfer',
                'logo' => 'payments/cimb.png',
                'is_active' => true,
            ],
            [
                'name' => 'BSI Virtual Account',
                'fee' => 4500,
                'type' => 'bank_transfer',
                'logo' => 'payments/bsi.png',
                'is_active' => true,
            ],
            [
                'name' => 'BTN Virtual Account',
                'fee' => 4500,
                'type' => 'bank_transfer',
                'logo' => 'payments/btn.png',
                'is_active' => true,
            ],
            // QRIS
            [
                'name' => 'QRIS',
                'fee' => 750, // 0.7% fee
                'type' => 'qris',
                'logo' => 'payments/qris.png',
                'is_active' => true,
            ],
            // User Saldo
            [
                'name' => 'Saldo TOSHOP',
                'fee' => 0,
                'type' => 'saldo',
                'logo' => 'payments/saldo.png',
                'is_active' => true,
            ],
        ];

        foreach ($methods as $method) {
            MetodePembayaran::create($method);
        }
    }
}
