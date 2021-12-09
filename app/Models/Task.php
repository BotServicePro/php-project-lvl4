<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status_id',
        'assigned_to_id',
        'labels',
    ];


    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
    public function status(): BelongsTo
    {
        return $this->belongsTo(TaskStatus::class, 'status_id');
    }
    public function executor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }
    public function label(): BelongsToMany
    {
        return $this->belongsToMany(Label::class, 'label_tasks', 'task_id', 'label_id');
    }
}
