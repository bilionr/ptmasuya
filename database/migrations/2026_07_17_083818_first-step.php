<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('kode_produk', 50)->unique(); // manual, alphanumeric only
            $table->string('nama_produk', 150);
            $table->decimal('harga', 15, 2)->default(0);
            $table->integer('stok')->default(0);
            $table->timestamps();
        });
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('kode_customer', 50)->unique(); // manual, alphanumeric only
            $table->string('nama_customer', 150);
            $table->string('alamat_lengkap', 255)->nullable();
            $table->string('provinsi', 100)->nullable();
            $table->string('kota', 100)->nullable();
            $table->string('kecamatan', 100)->nullable();
            $table->string('kelurahan', 100)->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->timestamps();
        });
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('no_inv', 30)->unique();
            $table->foreignId('customer_id')->constrained('customers')->restrictOnDelete();
            $table->string('kode_customer', 50);
            $table->string('nama_customer', 150);
            $table->string('alamat_customer', 500)->nullable();

            $table->date('tgl_inv');
            $table->decimal('total', 18, 2)->default(0);
            $table->timestamps();

            $table->index('tgl_inv');
        });
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained('transactions')->cascadeOnDelete();
            $table->string('no_inv', 30);

            $table->foreignId('product_id')->constrained('products')->restrictOnDelete();

            // snapshot data produk pada saat transaksi dibuat
            $table->string('kode_produk', 50);
            $table->string('nama_produk', 150);

            $table->integer('qty');
            $table->decimal('harga', 15, 2); // default dari master produk, bisa diubah user
            $table->decimal('disc1', 5, 2)->default(0); // dalam persen
            $table->decimal('disc2', 5, 2)->default(0);
            $table->decimal('disc3', 5, 2)->default(0);
            $table->decimal('harga_net', 15, 2); // harga setelah diskon bertingkat
            $table->decimal('jumlah', 18, 2); // harga_net x qty
            $table->timestamps();

            $table->index('no_inv');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_details');
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('products');
    }
};
