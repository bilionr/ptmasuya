<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $fillable = [
        'transaction_id',
        'no_inv',
        'product_id',
        'kode_produk',
        'nama_produk',
        'qty',
        'harga',
        'disc1',
        'disc2',
        'disc3',
        'harga_net',
        'jumlah',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
