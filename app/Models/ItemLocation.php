<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemLocation extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'item_id',
        'warehouse_storage_id',
        'stock'
    ];

    public function storage()
    {
        return $this->belongsTo(WarehouseStorage::class, 'warehouse_storage_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
