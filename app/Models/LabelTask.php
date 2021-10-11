<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabelTask extends Model
{
    use HasFactory;

    public function getLabelName()
    {
        return $this->belongsTo(Label::class, 'label_id');
    }
}
