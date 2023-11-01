<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoCartaConducao extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tipos_carta_conducao'; // Nome da tabela no banco de dados

    protected $fillable = ['name', 'description','custo']; 

    public function alunos()
    {
        return $this->hasMany(Aluno::class, 'carta');
    }

}
