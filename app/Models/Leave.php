<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'type',
        'dates',
        'reason',
        'status',
        'comments',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
