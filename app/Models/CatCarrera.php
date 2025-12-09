<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatCarrera extends Model
{
    //? nombre de la tabla 
    protected $table = 'cat_carreras';
    
    // ? clave primaria
    protected $primaryKey = 'id_carrera';
    
    // ? Desactivar timestamps (la tabla no tiene created_at/updated_at)
    public $timestamps = false;
    
    // ? Campos asignables
    protected $fillable = ['nombre'];
}
