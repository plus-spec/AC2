<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot; 
use App\Models\User; 

class ProjectMember extends Pivot
{
    use HasFactory;

    protected $table = 'project_members'; 
    protected $fillable = [
        'project_id',
        'user_id',
    ];
}