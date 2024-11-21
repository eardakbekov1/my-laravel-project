<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // Разрешаем массовое присваивание для этих полей
    protected $fillable = [
        'name',
        'description',
        'status_id',
        'user_id',
        'condition_id',
    ];

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_task');
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
