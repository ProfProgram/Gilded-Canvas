<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'Admin Table';

    protected $fillable = [
        'User_id'
    ];

    /**
     * Below are all connects of this Model
     * Each admin ID is connected to 1 user and 1 user can only have 1 user ID if their role enum = Admin
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
