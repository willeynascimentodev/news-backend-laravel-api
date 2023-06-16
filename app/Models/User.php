<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Filter;
use Auth;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function filters(): HasMany
    {
        return $this->hasMany(Filter::class);
    }

    public function getFilters() {
        
        $data = [
            'data' => [
                'categories' => Filter::where('type', 'category')
                ->where('user_id', Auth::user()->id)
                ->get()
                ->toArray(),
                'sources' => Filter::where('type', 'source')
                ->where('user_id', Auth::user()->id)
                ->get()
                ->toArray(),
                'authors' => Filter::where('type', 'author')
                ->where('user_id', Auth::user()->id)
                ->get()
                ->toArray()
            ]
        ];

        return $data;
    }
}
