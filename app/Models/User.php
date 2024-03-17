<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'user';
    protected $primaryKey = 'id_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id_user'];

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
        'password' => 'hashed',
    ];

    public function berita(): HasMany
    {
        return $this->hasMany(Berita::class, 'id_user');
    }

    public function komentar(): HasMany
    {
        return $this->hasMany(Komentar::class, 'id_user');
    }

    public function admin(): HasOne
    {
        return $this->hasOne(Admin::class, 'id_user');
    }

    public function wartawan(): HasOne
    {
        return $this->hasOne(Wartawan::class, 'id_user');
    }

    public function superEditor(): HasOne
    {
        return $this->hasOne(SuperEditor::class, 'id_user');
    }

    public function editor(): HasOne
    {
        return $this->hasOne(Editor::class, 'id_user');
    }
}
