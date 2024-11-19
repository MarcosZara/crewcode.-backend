<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
         'title',
        'description',
        'creator_id',
        'status',
        'theme',
        'image_url',
        'technologies',
        'goal',
        'duration',
        'team_size',
        'repository_url',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'project_members');
    }

    public function messages()
    {
        return $this->hasMany(ProjectMessage::class);
    }
    public function requests()
{
    return $this->hasMany(ProjectRequest::class);
}

public function notifications()
{
    return $this->hasMany(Notification::class);
}
}
