<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';
    protected $primaryKey = 'id_berita';
    protected $guarded = ['id_berita'];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriBerita::class, 'id_kategori_berita');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}