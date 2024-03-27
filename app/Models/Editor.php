<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Editor extends Model
{
    use HasFactory;

    protected $table = 'editor';
    protected $primaryKey = 'id_editor';
    protected $guarded = ['id_editor'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function wartawan(): HasMany
    {
        return $this->hasMany(Wartawan::class, 'id_editor');
    }
}
