<?php

namespace Database\Seeders;
use App\Models\Game;
use App\Models\BannerPromo;
use App\Models\Item;
use App\Models\TipeItem;
use App\Models\MetodePembayaran;
use App\Models\Saldo;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // User::factory(10)->create();
        $this->call([
            GameSeeder::class,
            BannerPromoSeeder::class,
            TipeItemSeeder::class,
            ItemSeeder::class,
            MetodePembayaranSeeder::class,
        ]);
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);
    }
}

class TipeItemSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'name' => 'Diamond',
                'description' => 'Mata uang premium untuk membeli item eksklusif',
                'image' => 'games/diamond.png',
            ],
            [
                'name' => 'Voucher',
                'description' => 'Kode voucher untuk berbagai layanan dan game',
                'image' => 'games/voucher.png',
            ],
            [
                'name' => 'BattlePass',
                'description' => 'Pass permainan untuk membuka konten eksklusif',
                'image' => 'games/battlepass.png',
            ],
            [
                'name' => 'Membership',
                'description' => 'Keanggotaan premium untuk bonus dan keuntungan',
                'image' => 'games/membership.png',
            ],
        ];

        foreach ($types as $type) {
            TipeItem::firstOrCreate(
                ['name' => $type['name']],
                $type
            );
        }
    }
}

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $mobileLegends = Game::where('name', 'Mobile Legends')->first();
        $freeFire = Game::where('name', 'Free Fire')->first();
        $steam = Game::where('name', 'Steam Wallet')->first();

        $diamond = TipeItem::where('name', 'Diamond')->first();
        $voucher = TipeItem::where('name', 'Voucher')->first();

        if ($mobileLegends && $diamond) {
            $mlItems = [
                ['nama' => '55 Diamond', 'item_id' => 'ML55', 'harga' => 11700, 'harga_coret' => 13700, 'discount_percent' => 25],
                ['nama' => '86 Diamond', 'item_id' => 'ML86', 'harga' => 18000, 'harga_coret' => 18450, 'discount_percent' => 22],
                ['nama' => '165 Diamond', 'item_id' => 'ML165', 'harga' => 35070, 'harga_coret' => 37000, 'discount_percent' => 21],
                ['nama' => '172 Diamond', 'item_id' => 'ML172', 'harga' => 36600, 'harga_coret' => 46000, 'discount_percent' => 20],
            ];

            foreach ($mlItems as $item) {
                $createdItem = Item::create(array_merge($item, [
                    'tipe_item_id' => $diamond->id,
                ]));
                $mobileLegends->items()->attach($createdItem->id, ['quantity' => 1]);
            }
        }

        if ($freeFire && $diamond) {
            $ffItems = [
                ['nama' => '50 Diamond', 'harga' => 7000, 'harga_coret' => 8500, 'discount_percent' => 18],
                ['nama' => '140 Diamond', 'harga' => 19000, 'harga_coret' => 23000, 'discount_percent' => 17],
            ];

            foreach ($ffItems as $item) {
                $createdItem = Item::create(array_merge($item, [
                    'tipe_item_id' => $diamond->id,
                ]));
                $freeFire->items()->attach($createdItem->id, ['quantity' => 1]);
            }
        }

        if ($steam && $voucher) {
            $steamItems = [
                ['nama' => 'Steam Wallet IDR 12.000', 'harga' => 13000, 'harga_coret' => 14000, 'discount_percent' => 7],
                ['nama' => 'Steam Wallet IDR 60.000', 'harga' => 62000, 'harga_coret' => 66000, 'discount_percent' => 6],
            ];

            foreach ($steamItems as $item) {
                $createdItem = Item::create(array_merge($item, [
                    'tipe_item_id' => $voucher->id,
                ]));
                $steam->items()->attach($createdItem->id, ['quantity' => 1]);
            }
        }
    }
}

class GameSeeder extends Seeder
{
    public function run(): void
    {
        $games = [
            [
                'name' => 'Mobile Legends',
                'description' => 'Mobile Legends: Bang Bang adalah game MOBA 5v5 terbaik di perangkat mobile. Bergabunglah dengan teman-temanmu dalam pertempuran 5v5! 10 detik matchmaking, 10 menit pertempuran. Raih kemenangan dengan strategi tim terbaikmu!',
                'image' => 'games/MobileLegends.jpg',
                'tipe' => 'game',
            ],
            [
                'name' => 'Free Fire',
                'description' => 'Garena Free Fire adalah game battle royale terpopuler di mobile. Setiap pertempuran 10 menit menempatkan Anda di pulau terpencil dengan 49 pemain lainnya. Pemain bebas memilih posisi awal mereka, mengambil senjata dan perlengkapan, dan bertahan hidup.',
                'image' => 'games/FreeFire.jpg',
                'tipe' => 'game',
            ],
            [
                'name' => 'Steam Wallet',
                'description' => 'Steam Wallet Code dapat digunakan di Steam untuk pembelian Games, Software, DLC dan item komunitas Steam lainnya. Anda bisa membeli apa saja yang tersedia di Steam menggunakan Steam Wallet.',
                'image' => 'games/Steam.jpg',
                'tipe' => 'voucher',
            ],
        ];

        foreach ($games as $game) {
            Game::create($game);
        }
    }
}

class BannerPromoSeeder extends Seeder
{
    public function run(): void
    {
        $mlGame = Game::where('name', 'Mobile Legends')->first();
        $ffGame = Game::where('name', 'Free Fire')->first();
        $steamGame = Game::where('name', 'Steam Wallet')->first();

        $banners = [
            [
                'name' => 'Mobile Legends Promo',
                'image' => 'banner/BannerMobileLegends.png',
                'is_active' => true,
                'order' => 1,
                'game_id' => $mlGame?->id,
            ],
            [
                'name' => 'Free Fire Sale',
                'image' => 'banner/BannerFreeFire.jpg',
                'is_active' => true,
                'order' => 2,
                'game_id' => $ffGame?->id,
            ],
            [
                'name' => 'Steam Wallet Discount',
                'image' => 'banner/BannerSteam.jpg',
                'is_active' => true,
                'order' => 3,
                'game_id' => $steamGame?->id,
            ],
        ];

        foreach ($banners as $banner) {
            BannerPromo::create($banner);
        }
    }
}

class MetodePembayaranSeeder extends Seeder
{
    public function run(): void
    {
        $methods = [
            // Virtual Account Methods
            [
                'name' => 'BCA Virtual Account',
                'fee' => 4500,
                'type' => 'bank_transfer',
                'logo' => 'MetodePembayaran/BCA.png',
                'is_active' => true,
            ],
            [
                'name' => 'BRI Virtual Account',
                'fee' => 4500,
                'type' => 'bank_transfer', 
                'logo' => 'MetodePembayaran/BRI.png',
                'is_active' => true,
            ],
            [
                'name' => 'BNI Virtual Account',
                'fee' => 4500,
                'type' => 'bank_transfer',
                'logo' => 'MetodePembayaran/BNI.png',
                'is_active' => true,
            ],
            [
                'name' => 'Mandiri Virtual Account',
                'fee' => 4500,
                'type' => 'bank_transfer',
                'logo' => 'MetodePembayaran/Mandiri.png',
                'is_active' => true,
            ],
            [
                'name' => 'Permata Virtual Account',
                'fee' => 4500,
                'type' => 'bank_transfer',
                'logo' => 'MetodePembayaran/Permata.png',
                'is_active' => true,
            ],
            [
                'name' => 'BNC Virtual Account',
                'fee' => 4500,
                'type' => 'bank_transfer',
                'logo' => 'MetodePembayaran/BNC.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Danamon Virtual Account',
                'fee' => 4500,
                'type' => 'bank_transfer',
                'logo' => 'MetodePembayaran/Danamon.png',
                'is_active' => true,
            ],
            [
                'name' => 'CIMB Virtual Account',
                'fee' => 4500,
                'type' => 'bank_transfer',
                'logo' => 'MetodePembayaran/CIMB.png',
                'is_active' => true,
            ],
            [
                'name' => 'BSI Virtual Account',
                'fee' => 4500,
                'type' => 'bank_transfer',
                'logo' => 'MetodePembayaran/BSI.png',
                'is_active' => true,
            ],
            [
                'name' => 'BTN Virtual Account',
                'fee' => 4500,
                'type' => 'bank_transfer',
                'logo' => 'MetodePembayaran/BTN.png',
                'is_active' => true,
            ],
            // QRIS
            [
                'name' => 'QRIS',
                'fee' => 750, // 0.7% fee
                'type' => 'qris',
                'logo' => 'MetodePembayaran/QRIS.png',
                'is_active' => true,
            ],
            // User Saldo
            [
                'name' => 'Saldo TOSHOP',
                'fee' => 0,
                'type' => 'saldo',
                'logo' => 'MetodePembayaran/TOSHOP.png',
                'is_active' => true,
            ],
        ];

        foreach ($methods as $method) {
            MetodePembayaran::create($method);
        }
    }
}