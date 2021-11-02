<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    /**
     * @var mixed
     */
    private $getStatusData;
    /**
     * @var mixed
     */
    private $created_by_id;
    /**
     * @var mixed|string
     */
    private $name;
    /**
     * @var mixed|string
     */
    private $description;
    /**
     * @var int|mixed
     */
    private $assigned_to_id;
    /**
     * @var int|mixed
     */
    private $status_id;
    /**
     * @var mixed
     */
    private $id;

    public function getAuthorData()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
    public function getStatusData()
    {
        return $this->belongsTo(TaskStatus::class, 'status_id');
    }
    public function getExecutorData()
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }
}
