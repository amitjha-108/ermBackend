<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Models\Leave;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'contact',
        'password',
        'role',
        'photo',
        'address',
        'officialID',
        'designation',
        'officeLocation',
        'department',
        'education',
        'pan',
        'aadhar',
        'passbook',
        'offerLetter',
        'PFNO',
        'ESINO',
        'joiningDate',
        'leavingDate',
        'jobStatus',
        'about',
        'salary',
        'dob',
    ];

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    public function assignedTasks()
    {
        return $this->hasMany(AssignedTask::class, 'empId');
    }

     // A user can be a team leader of multiple projects
     public function teamLeaderProjects()
     {
         return $this->hasMany(TeamLeader::class, 'user_id');
     }
}
