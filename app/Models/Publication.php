<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Publication extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
    'titre',
    'contenu',
    'categorie_id',
    'user_id',
    'image',
    'fichier_media',
    'type_media',
    ];



    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class);
    }
    public function auteur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function commentaires() 
    { 
        return $this->hasMany(Commentaire::class); 
    }
    protected static function booted(): void
    {
    static::forceDeleting(function (Publication $publication) {
        if ($publication->image) {
            Storage::disk('public')->delete($publication->image);
        }
        if ($publication->fichier_media) {
            Storage::disk('public')->delete($publication->fichier_media);
        }
    });
    }
}