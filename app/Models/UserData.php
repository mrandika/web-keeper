<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone_number'
    ];

    public function fullname()
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
