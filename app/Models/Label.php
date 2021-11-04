<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];
    /**
     * @var mixed|string
     */
    private $name;
    /**
     * @var mixed|string
     */
    private $description;
}
