<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuperEditor extends Model
{
    use HasFactory;

    protected $table = 'super_editor';
    protected $primaryKey = 'id_super_editor';
    protected $guarded = ['id_super_editor'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}