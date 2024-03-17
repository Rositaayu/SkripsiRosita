<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriBerita extends Model
{
    use HasFactory;

    protected $table = 'kategori_berita';
    protected $primaryKey = 'id_kategori_berita';
    protected $guarded = ['id_kategori_berita'];

    public function berita(): HasMany
    {
        return $this->hasMany(Berita::class, 'id_kategori_berita');
    }
}