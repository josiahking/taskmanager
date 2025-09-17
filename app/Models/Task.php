<?php

namespace App\Models;

use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\PriorityEnum;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'priority',
        'project_id',
        'order',
    ];

    protected $casts = [
        'priority' => PriorityEnum::class,
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
