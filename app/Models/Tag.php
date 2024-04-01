<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tag extends Model
{
    use HasFactory;

    protected $table = 'tag';
    protected $primaryKey = 'id_tag';
    protected $guarded = ['id_tag'];

    public function tag_berita(): HasMany
    {
        return $this->hasMany(TagBerita::class, 'id_tag');
    }
}
