<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $table = 'users_table';
    protected $primaryKey = 'User_id';

    protected $fillable = [
        'Name',
        'Email',
        'Phone_number',
        'Address',
    ];
}
