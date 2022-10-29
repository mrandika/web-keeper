<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseStorage extends Model
{
    use HasFactory, HasUuids;

    public function aisle()
    {
        return $this->belongsTo(WarehouseAisle::class, 'warehouse_aisle_id');
    }

    public function column()
    {
        return $this->belongsTo(WarehouseAisleColumn::class, 'warehouse_aisle_column_id');
    }

    public function row()
    {
        return $this->belongsTo(WarehouseAisleRow::class, 'warehouse_aisle_row_id');
    }
}
