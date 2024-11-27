<?php
// app/Events/TaskCreated.php
namespace App\Events;

use App\Models\Task;  // Импортируем модель Task
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $task;  // Переменная для передачи данных задачи

    // Конструктор принимает задачу как параметр
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    // Определяем, на какой канал будет транслироваться событие
    public function broadcastOn()
    {
        return new Channel('tasks');  // Канал "tasks"
    }

    // Определяем, какие данные будут отправляться через событие
    public function broadcastWith()
    {
        return [
            'task' => $this->task->toArray(),  // Преобразуем задачу в массив для передачи данных
        ];
    }
}
