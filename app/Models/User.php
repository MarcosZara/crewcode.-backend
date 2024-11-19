<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $fillable = ['username', 'email', 'password','level', 'profile_image', 'bio', 'interests'];
    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function createdProjects()
    {
        return $this->hasMany(Project::class, 'creator_id');
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_members');
    }

    public function projectMessages()
    {
        return $this->hasMany(ProjectMessage::class);
    }

    public function privateChats()
    {
        return $this->belongsToMany(User::class, 'private_chats', 'user1_id', 'user2_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function projectRequests()
    {
        return $this->hasMany(ProjectRequest::class);
    }


}
