<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    use HasFactory;

    public function idCards()
    {
        return $this->hasMany(IdCard::class);
    }

    public function roles()
    {
        return $this->hasMany(Role::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function statuses()
    {
        return $this->hasMany(Status::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
