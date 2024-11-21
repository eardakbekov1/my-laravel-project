<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'project_task');
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

}
