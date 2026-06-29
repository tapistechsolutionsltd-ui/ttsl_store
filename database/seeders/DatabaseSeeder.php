<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Super Admin ──────────────────────────────────────────────
        User::firstOrCreate(
            ['email' => 'admin@ttsolutionspng.com'],
            [
                'name'     => 'TTSL Admin',
                'phone'    => '+675 7224 3900',
                'password' => Hash::make('ttsl@100%PNG'),
                'role'     => 'super_admin',
                'status'   => 'active',
                'email_verified_at' => now(),
            ]
        );

        // ── Categories ───────────────────────────────────────────────
        $categories = [
            ['name' => 'Computers & Laptops',    'sort_order' => 1],
            ['name' => 'Office Supplies',         'sort_order' => 2],
            ['name' => 'Hardware Peripherals',    'sort_order' => 3],
            ['name' => 'Cables & Accessories',    'sort_order' => 4],
            ['name' => 'Merchandise',             'sort_order' => 5],
            ['name' => 'Carpentry',               'sort_order' => 6],
            ['name' => 'Heavy Equipment',         'sort_order' => 7],
            ['name' => 'Machines',                'sort_order' => 8],
            ['name' => 'Tools',                   'sort_order' => 9],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(
                ['name' => $cat['name']],
                array_merge($cat, ['status' => true])
            );
        }

        // ── Brands ───────────────────────────────────────────────────
        $brands = ['Dell', 'HP', 'Lenovo', 'Samsung', 'Canon', 'Epson', 'Bosch', 'Makita', 'Caterpillar'];
        foreach ($brands as $brand) {
            Brand::firstOrCreate(['name' => $brand], ['status' => true]);
        }

        // ── Sample Products ──────────────────────────────────────────
        $laptopsCat = Category::where('name', 'Computers & Laptops')->first();
        $officeCat  = Category::where('name', 'Office Supplies')->first();
        $toolsCat   = Category::where('name', 'Tools')->first();
        $dell       = Brand::where('name', 'Dell')->first();
        $hp         = Brand::where('name', 'HP')->first();

        $sampleProducts = [
            [
                'name'        => 'Dell Inspiron 15 Laptop – Intel i5, 8GB RAM, 256GB SSD',
                'description' => 'Reliable performance laptop ideal for office work, browsing, and business applications. Perfect for PNG workplaces.',
                'price'       => 2499.00,
                'sale_price'  => 2199.00,
                'stock'       => 15,
                'sku'         => 'DELL-INS-15-001',
                'status'      => 'active',
                'featured'    => true,
                'category_id' => $laptopsCat?->id,
                'brand_id'    => $dell?->id,
                'specifications' => json_encode([
                    'Processor' => 'Intel Core i5-12th Gen',
                    'RAM'       => '8GB DDR4',
                    'Storage'   => '256GB SSD',
                    'Display'   => '15.6" FHD 1080p',
                    'OS'        => 'Windows 11 Home',
                    'Battery'   => 'Up to 8 hours',
                ]),
            ],
            [
                'name'        => 'HP LaserJet Pro M404dn Printer',
                'description' => 'Professional mono laser printer for high-volume office printing. Fast, reliable, and cost-effective.',
                'price'       => 1850.00,
                'sale_price'  => null,
                'stock'       => 8,
                'sku'         => 'HP-LJ-M404DN-001',
                'status'      => 'active',
                'featured'    => true,
                'category_id' => $officeCat?->id,
                'brand_id'    => $hp?->id,
                'specifications' => json_encode([
                    'Type'        => 'Mono Laser',
                    'Print Speed' => '40 ppm',
                    'Resolution'  => 'Up to 1200 x 1200 dpi',
                    'Connectivity'=> 'USB, Ethernet',
                    'Paper Input' => '250-sheet tray',
                ]),
            ],
            [
                'name'        => 'Makita Cordless Drill 18V – 2 Batteries Included',
                'description' => 'Heavy duty cordless drill for construction and carpentry work. Ideal for PNG building and construction projects.',
                'price'       => 650.00,
                'sale_price'  => null,
                'stock'       => 20,
                'sku'         => 'MAK-DRILL-18V-001',
                'status'      => 'active',
                'featured'    => false,
                'category_id' => $toolsCat?->id,
                'brand_id'    => Brand::where('name', 'Makita')->first()?->id,
                'specifications' => json_encode([
                    'Voltage'    => '18V',
                    'Chuck Size' => '13mm',
                    'Max Torque' => '60Nm',
                    'Battery'    => 'Li-Ion, 2 × 3.0Ah included',
                    'Weight'     => '1.5kg',
                ]),
            ],
        ];

        foreach ($sampleProducts as $productData) {
            Product::firstOrCreate(
                ['sku' => $productData['sku']],
                $productData
            );
        }

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('   Admin: admin@ttsolutionspng.com / ttsl@100%PNG');
    }
}
