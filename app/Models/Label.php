<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Label extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function getLabelDataInUsage(): BelongsToMany
    {
        return $this->belongsToMany(Label::class, 'label_tasks', 'label_id');
    }
}
