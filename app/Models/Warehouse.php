<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'admin_id',
        'name',
        'address',
        'latitude',
        'longitude'
    ];

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function storages()
    {
        return $this->hasManyThrough(WarehouseStorage::class, WarehouseAisle::class);
    }
}
