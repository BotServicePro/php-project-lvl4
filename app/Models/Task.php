<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status_id',
        'created_by_id',
        'assigned_to_id',
        'labels',
    ];


    public function getAuthorData(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
    public function getStatusData(): BelongsTo
    {
        return $this->belongsTo(TaskStatus::class, 'status_id');
    }
    public function getExecutorData(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }
}
