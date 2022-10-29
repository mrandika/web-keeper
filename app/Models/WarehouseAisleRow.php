<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseAisleRow extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'code',
        'warehouse_aisle_column_id'
    ];

    public function column()
    {
        return $this->belongsTo(WarehouseAisleColumn::class, 'warehouse_aisle_column_id');
    }
}
