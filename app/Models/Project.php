<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'client',
        'location',
        'startDate',
        'endDate',
        'status',
        'projectType',
        'projectDescription',
        'projectCost',
        'developmentArea',
        'projectScope',
        'projectNature',
    ];


    // A project can have many assigned tasks
    public function assignedTasks()
    {
        return $this->hasMany(AssignedTask::class, 'project_id');
    }

    // A project can have multiple team leaders
    public function teamLeaders()
    {
        return $this->hasMany(TeamLeader::class, 'project_id');
    }
}
