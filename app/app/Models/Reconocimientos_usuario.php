<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//TODO - Reconocimientos del usuario
class Reconocimientos_usuario extends Model
{
    // Tabla
    protected $table = 'reconocimientos_usuarios';

    // Usar datos de prueba
    use HasFactory;

    // Mostrar
    protected $fillable = [
        'user_id',
        'sni',
        'sni_nivel',
        'edd',
        'edd_nivel',
        'pd',
        'pd_nivel',
    ];

    // Ocultos
    protected $hidden = [
        'updated_at',
        'created_at',
    ];

    // Pertenece a
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
