<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceSequence extends Model
{
    public static function generateKodeInvoice(): string
    {
        $prefix = 'INV';
        $yearMonth = now()->format('ym'); 

        return DB::transaction(function () use ($prefix, $yearMonth) {
            $last = self::where('kode_customer', 'like', "{$prefix}/{$yearMonth}/%")
                ->lockForUpdate()
                ->orderByDesc('kode_customer')
                ->first();

            if ($last) {
                $lastNumber = (int) substr($last->kode_customer, -4);
                $nextNumber = $lastNumber + 1;
            } else {
                $nextNumber = 1;
            }

            return sprintf('%s/%s/%04d', $prefix, $yearMonth, $nextNumber);
        });
    }
}
