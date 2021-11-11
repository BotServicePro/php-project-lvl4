<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabelTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'label_id'
    ];

    /**
     * @var mixed
     */
    private $task_id;
    /**
     * @var int|mixed
     */
    private $label_id;

    public function getLabelName(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Label::class, 'label_id');
        //return $this->belongsToMany(Label::class, 'label_tasks', 'task_id', 'label_id');
    }
}
