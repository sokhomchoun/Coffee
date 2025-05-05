<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class purchaseOrders extends Model
{
    use HasFactory;
    protected $table    = "purchases";
    protected $fillable = [
        'id',
        'date',
        'supplier_id',
        'branch_id',
    ];

    public function purchaseItems()
    {
        return $this->hasMany(purchaseItems::class, 'purchase_id', localKey: 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id',  'id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

}
