<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

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
}
