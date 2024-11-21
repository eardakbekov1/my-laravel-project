<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdCard extends Model
{
    use HasFactory;

    /**
     * Таблица, связанная с моделью.
     *
     * @var string
     */
    protected $table = 'id_cards';

    /**
     * Атрибуты, которые можно массово заполнять.
     *
     * @var array
     */
    protected $fillable = [
        'role_id',
        'user_id',
        'condition_id',
    ];

    /**
     * Связь "один к одному" с моделью User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }
}
