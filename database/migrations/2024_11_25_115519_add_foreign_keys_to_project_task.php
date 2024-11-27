<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToProjectTask extends Migration
{
    public function up()
    {
        Schema::table('project_task', function (Blueprint $table) {
            // Добавляем внешние ключи
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('project_task', function (Blueprint $table) {
            // Удаляем внешние ключи
            $table->dropForeign(['project_id']);
            $table->dropForeign(['task_id']);
        });
    }
}
