<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Arquivo extends Model
{
    protected $fillable = ['arquivo', 'chamado_id']; // campos que você vai preencher

    public function chamado()
    {
        return $this->belongsTo(Chamado::class);
    }
}
