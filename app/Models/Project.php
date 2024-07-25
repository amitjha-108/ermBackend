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
    ];
}
