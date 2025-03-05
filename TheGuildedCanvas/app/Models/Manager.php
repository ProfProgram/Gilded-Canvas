<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    use HasFactory;

    protected $table = 'manager_table';
    protected $primaryKey = 'manager_id';

    protected $fillable = [
        'user_id'
    ];

    /**
     * Below are all connects of this Model
     * Each manager ID is connected to 1 user and 1 user can only have 1 user ID if their role enum = Manager
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
