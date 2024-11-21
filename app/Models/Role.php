<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'condition_id',
    ];

    public function idCards()
    {
        return $this->hasMany(IdCard::class);
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

}
