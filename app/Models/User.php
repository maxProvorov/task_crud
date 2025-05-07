<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'api_token'
    ];

    public function generateApiToken(): string
    {
        $this->api_token = hash('sha256', $this->user_id . $this->email . $this->password);
        $this->save();
        return $this->api_token;
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
