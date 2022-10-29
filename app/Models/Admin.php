<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'status'
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
