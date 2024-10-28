<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project;
use App\Models\User;

class AssignedTask extends Model
{
    use HasFactory;
    protected $fillable = [
        'project_id',
        'empId',
        'taskDescription',
        'priority',
        'deadline',
        'assignedBy',
        'status',
        'startTime',
        'endTime',
        'comment',
    ];

    // Define the relationship with the Project model
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Define the relationship with the User model (if exists)
    public function employee()
    {
        return $this->belongsTo(User::class, 'empId');
    }

    // Define the relationship with the User model (assuming assignedBy is a user)
    public function assignedByUser()
    {
        return $this->belongsTo(User::class, 'assignedBy');
    }
}
