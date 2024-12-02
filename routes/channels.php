<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('tasks', function ($user) {
    return true; // Настройте доступ для ваших пользователей
});

Broadcast::channel('chat', \App\Broadcasting\ChatChannel::class);
