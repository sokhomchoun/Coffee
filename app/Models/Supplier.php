<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $table = "suppliers";
    protected $fillable = [
        'id',
        'name',
        'email',
        'phone_number',
        'country',
        'city',
        'address'
    ];
    public function purchaseOrders(){
        return $this->belongsTo(purchaseOrders::class,'supplier_id','id');
    }
}
