<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory, InteractsWithMedia, SoftDeletes;
    protected $table = "brands";
    protected $fillable = [
        'id',
        'name',
        'status'
    ];
}
