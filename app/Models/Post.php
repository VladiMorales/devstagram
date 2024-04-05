<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'user_id'
    ];

    //Belongsto hace una relacion con la tabla de usuarios y posts
    //la relacion es de 1 a muchos siendo usuario un unico autor de un post pero puede tener varios escritos
    public function user()
    {
        return $this->belongsTo(User::class)->select(['name', 'username']);
    }

    //Esta funcion hace una relacion con la tabla de comentarios
    //En donde un post puede tener varios comentarios
    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function checkLike(User $user)
    {
        return $this->likes->contains('user_id', $user->id);
    }
}
