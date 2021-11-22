<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LabelTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'label_id'
    ];

    public function getLabelName(): BelongsTo
    {
        return $this->belongsTo(Label::class, 'label_id');
    }
}
