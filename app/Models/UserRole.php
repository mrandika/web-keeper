<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name'
    ];

    public $timestamps = false;

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
