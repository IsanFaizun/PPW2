<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use illuminate\Database\Eloquent\Relations\HasMany;

class Buku extends Model
{
    use HasFactory;
    protected $table = 'buku';
    protected $primaryKey = 'id';
    protected $fillable = ['judul', 'penulis', 'harga', 'tgl_terbit', 'filename', 'filepath'];
    protected $dates = ['tgl_terbit'];
    public function galleries(): HasMany
    {
        return $this->hasMany(Galeri::class);
    }
}
