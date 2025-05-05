<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageStock extends Model
{
    use HasFactory;
    protected $table    = "manage_stocks";
    protected $fillable = [
        'id',
        'branch_id',
        'product_id',
        'qty',
    ];
}
