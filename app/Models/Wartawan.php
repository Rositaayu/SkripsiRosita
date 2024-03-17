<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wartawan extends Model
{
    use HasFactory;

    protected $table = 'wartawan';
    protected $primaryKey = 'id_wartawan';
    protected $guarded = ['id_wartawan'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
