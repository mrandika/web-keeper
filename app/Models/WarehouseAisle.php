<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseAisle extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'warehouse_id',
        'code'
    ];

    public function columns()
    {
        return $this->hasMany(WarehouseAisleColumn::class);
    }

    public function rows()
    {
        return $this->hasManyThrough(WarehouseAisleRow::class, WarehouseAisleColumn::class);
    }
}
