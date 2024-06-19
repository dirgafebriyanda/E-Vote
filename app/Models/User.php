<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

     public function candidate()
    {
        return $this->hasMany(Candidate::class);
    }
     public function election()
    {
        return $this->hasMany(Election::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->username = self::generateUsername($user->name);
        });
    }

    private static function generateUsername($name)
    {
        // Ubah nama menjadi slug dan tambahkan angka acak di akhir untuk memastikan keunikan
        $baseUsername = Str::slug($name, '_');
        $username = $baseUsername;
        $counter = 1;

        // Cek apakah username sudah ada di database
        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . '_' . $counter;
            $counter++;
        }

        return $username;
    }

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
}
