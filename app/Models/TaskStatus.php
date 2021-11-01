<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];
    /**
     * @var mixed|string
     */
    private $name;


    /**
     * Получить задачи статуса.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class, 'status_id');
    }
}
