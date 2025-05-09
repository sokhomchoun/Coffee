<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
    use HasFactory;
    protected $table = "variation";
    protected $fillable = [
        'id',
        'name',
    ];

    public function type()
    {
        return $this->hasMany(variation_types::class, 'variation_id', 'id');
    }
}
