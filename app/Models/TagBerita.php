<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TagBerita extends Model
{
    use HasFactory;

    protected $table = 'tag_berita';
    protected $primaryKey = 'id_tag_berita';
    protected $guarded = ['id_tag_berita'];

    public function berita(): BelongsTo
    {
        return $this->belongsTo(Berita::class, 'id_berita');
    }

    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class, 'id_tag');
    }
}
