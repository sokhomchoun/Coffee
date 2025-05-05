<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, InteractsWithMedia, SoftDeletes;
    protected $table = 'products';
    protected $fillable = [
        'id',
        'name',
        'category_id',
        'brand_id',
        'branch_id',
        'unit_id',
        'product_cost',
        'stock_alert'
    ];
    public function purchaseItems()
    {
        return $this->hasMany(purchaseItems::class, 'product_id', localKey: 'id');
    }
}
