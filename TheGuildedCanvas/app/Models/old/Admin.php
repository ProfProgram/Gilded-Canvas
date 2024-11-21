<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admin_table';
    protected $primaryKey = 'Admin_id';

    protected $fillable = [
        'Name',
        'Email',
        'Password',
        'Phone_number',
        'Role',
    ];
}