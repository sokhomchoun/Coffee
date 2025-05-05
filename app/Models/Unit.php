<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use HasFactory, InteractsWithMedia, SoftDeletes;
    protected $table = "units";
    protected $fillable = [
        'id',
        'name',
        'status'
    ];
    public function purchaseItems()
    {
        return $this->hasMany(purchaseItems::class, 'unit', localKey: 'id');
    }
}
