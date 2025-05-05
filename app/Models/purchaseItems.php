<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\purchases;

class purchaseItems extends Model
{
    use HasFactory;
    protected $table = "purchase_items";
    protected $fillable = [
        'id',
        'purchase_id',
        'product_id',
        'unit',
        'qty',
    ];
    public function purchaseOrders(){
        return $this->belongsTo(purchaseOrders::class,'purchase_id','id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id',  'id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit', 'id');
    }


}

