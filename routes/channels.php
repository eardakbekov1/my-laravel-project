<?php

use App\Broadcasting\ChatChannel;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('tasks', function ($user) {
    return true; // Настройте доступ для ваших пользователей
});

Broadcast::channel('chat', ChatChannel::class);
