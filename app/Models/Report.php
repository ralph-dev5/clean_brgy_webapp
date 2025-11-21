<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Report extends Model
{
    use HasFactory, SoftDeletes; // Enables soft delete functionality

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'location',
        'image',
        'status', // Allowed values: 'pending', 'in-progress', 'resolved'
    ];

    /**
     * Define the relationship: a report belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
