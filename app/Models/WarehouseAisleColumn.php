<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseAisleColumn extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'code',
        'warehouse_aisle_id'
    ];

    public function aisle()
    {
        return $this->belongsTo(WarehouseAisle::class, 'warehouse_aisle_id');
    }
}
