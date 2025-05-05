<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class variation_types extends Model
{
    use HasFactory;
    protected $table = "variation_types";
    protected $fillable = [
        'id',
        'variation_id',
        'name',
    ];

    public function variation(){
        return $this->belongsTo(variation::class, 'variation_id', 'id');
    }
}
