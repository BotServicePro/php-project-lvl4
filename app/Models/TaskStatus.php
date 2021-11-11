<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskStatus extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    /**
     * @var mixed|string
     */
    private $name;
    /**
     * @var mixed|string
     */
    private $id;
    /**
     * @var mixed
     */
    private $tasks;

    /**
     * Получить задачи статуса.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'status_id');
    }
}
