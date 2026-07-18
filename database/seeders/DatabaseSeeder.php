<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. POPULATE DATA PRODUCTS
        $products = [
            [
                'kode_produk' => 'PRD001',
                'nama_produk' => 'Minyak Goreng SunCo 2L',
                'harga' => 45000.00,
                'stok' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_produk' => 'PRD002',
                'nama_produk' => 'Beras Pandan Wangi 5kg',
                'harga' => 85000.00,
                'stok' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_produk' => 'PRD003',
                'nama_produk' => 'Gula Pasir Gulaku 1kg',
                'harga' => 18000.00,
                'stok' => 200,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_produk' => 'PRD004',
                'nama_produk' => 'Indomie Goreng Spasial (Kardus)',
                'harga' => 115000.00,
                'stok' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('products')->insert($products);

        // 2. POPULATE DATA CUSTOMERS
        $customers = [
            [
                'kode_customer' => 'CST001',
                'nama_customer' => 'Toko Kelontong Berkah',
                'alamat_lengkap' => 'Jl. Raya Darmo No. 45',
                'provinsi' => 'Jawa Timur',
                'kota' => 'Surabaya',
                'kecamatan' => 'Wonokromo',
                'kelurahan' => 'Darmo',
                'kode_pos' => '60241',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_customer' => 'CST002',
                'nama_customer' => 'CV. Maju Jaya Makmur',
                'alamat_lengkap' => 'Sudirman Central Business District Blk. M-10',
                'provinsi' => 'DKI Jakarta',
                'kota' => 'Jakarta Selatan',
                'kecamatan' => 'Kebayoran Baru',
                'kelurahan' => 'Senayan',
                'kode_pos' => '12190',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('customers')->insert($customers);

        // 3. SIMULASI TRANSAKSI
        // Kita ambil ID data yang baru dimasukkan agar relasinya valid
        $dbProducts = DB::table('products')->get()->keyBy('kode_produk');
        $dbCustomers = DB::table('customers')->get()->keyBy('kode_customer');

        // Setup Tanggal Transaksi (Simulasi bulan Juli 2026 sesuai dengan format period_key)
        $tglTransaksi = Carbon::create(2026, 7, 17);
        $periodKey = $tglTransaksi->format('yM'); // Hasil: 2607 (YYMM)

        // Inisialisasi awal sequence untuk bulan 2607
        DB::table('invoice_sequences')->insert([
            'period_key' => $periodKey,
            'last_number' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // --- TRANSAKSI 1 (Customer 1 membeli 2 produk) ---
        $this->createDummyTransaction(
            $dbCustomers['CST001'], 
            $tglTransaksi, 
            $periodKey,
            [
                [
                    'product' => $dbProducts['PRD001'],
                    'qty' => 5,
                    'disc1' => 10.00, // 10%
                    'disc2' => 5.00,  // lalu 5%
                    'disc3' => 0.00,
                ],
                [
                    'product' => $dbProducts['PRD003'],
                    'qty' => 10,
                    'disc1' => 0.00,
                    'disc2' => 0.00,
                    'disc3' => 0.00,
                ]
            ]
        );

        // --- TRANSAKSI 2 (Customer 2 membeli 1 produk) ---
        $this->createDummyTransaction(
            $dbCustomers['CST002'], 
            $tglTransaksi, 
            $periodKey,
            [
                [
                    'product' => $dbProducts['PRD004'],
                    'qty' => 2,
                    'disc1' => 5.00,
                    'disc2' => 2.00,
                    'disc3' => 1.00,
                ]
            ]
        );
    }

    /**
     * Helper untuk membuat data transaksi, detail transaksi, beserta kalkulasi otomatisnya.
     */
    private function createDummyTransaction($customer, $date, $periodKey, $items)
    {
        // 1. Ambil & update nomor urut invoice terakhir
        $sequence = DB::table('invoice_sequences')->where('period_key', $periodKey)->first();
        $nextNumber = $sequence->last_number + 1;
        
        DB::table('invoice_sequences')
            ->where('period_key', $periodKey)
            ->update(['last_number' => $nextNumber, 'updated_at' => now()]);

        // Format nomor invoice: INV/2607/0001
        $noInv = 'INV/' . $periodKey . '/' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        // Gabungkan alamat untuk snapshot histori
        $alamatSnapshot = implode(', ', array_filter([
            $customer->alamat_lengkap, 
            $customer->kelurahan, 
            $customer->kecamatan, 
            $customer->kota, 
            $customer->provinsi, 
            $customer->kode_pos
        ]));

        // 2. Insert Header Transaksi terlebih dahulu untuk mendapatkan ID
        $transactionId = DB::table('transactions')->insertGetId([
            'no_inv' => $noInv,
            'customer_id' => $customer->id,
            'kode_customer' => $customer->kode_customer,
            'nama_customer' => $customer->nama_customer,
            'alamat_customer' => substr($alamatSnapshot, 0, 500),
            'tgl_inv' => $date->format('Y-m-d'),
            'total' => 0, // di-update nanti setelah detail dihitung
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $grandTotal = 0;

        // 3. Proses input items ke detail transaksi
        foreach ($items as $item) {
            $prod = $item['product'];
            $qty = $item['qty'];
            
            // Rumus Diskon Bertingkat (Compound Discount)
            $hargaNet = $prod->harga;
            $hargaNet -= $hargaNet * ($item['disc1'] / 100);
            $hargaNet -= $hargaNet * ($item['disc2'] / 100);
            $hargaNet -= $hargaNet * ($item['disc3'] / 100);
            
            $jumlah = $hargaNet * $qty;
            $grandTotal += $jumlah;

            DB::table('transaction_details')->insert([
                'transaction_id' => $transactionId,
                'no_inv' => $noInv,
                'product_id' => $prod->id,
                'kode_produk' => $prod->kode_produk,
                'nama_produk' => $prod->nama_produk,
                'qty' => $qty,
                'harga' => $prod->harga,
                'disc1' => $item['disc1'],
                'disc2' => $item['disc2'],
                'disc3' => $item['disc3'],
                'harga_net' => $hargaNet,
                'jumlah' => $jumlah,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 4. Update total uang belanjaan asli pada table header transaksi
        DB::table('transactions')
            ->where('id', $transactionId)
            ->update(['total' => $grandTotal]);
    
    }
}
