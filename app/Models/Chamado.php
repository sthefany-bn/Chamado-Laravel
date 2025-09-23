<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chamado extends Model
{
    use HasFactory;
    protected $fillable = ['titulo', 'data', 'status', 'descricao'];

    public function autor(){
        return $this->belongsTo(User::class, 'autor_id');
    }

    public function responsavel(){
        return $this->belongsTo(User::class,  'responsavel_id');
    }

    public function arquivos()
    {
        return $this->hasMany(Arquivo::class);
    }
}