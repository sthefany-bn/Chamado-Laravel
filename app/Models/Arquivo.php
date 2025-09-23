<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Arquivo extends Model
{
    protected $fillable = ['arquivo', 'chamado_id', 'nome_original'];

    public function chamado()
    {
        return $this->belongsTo(Chamado::class);
    }

    // Accessor para URL completa do arquivo
    public function getArquivoUrlAttribute()
    {
        // Ajuste o caminho abaixo conforme onde seus arquivos estão armazenados
        return asset('storage/' . $this->arquivo);
    }

    // Accessor para nome do arquivo (apenas o nome, sem o caminho)
    public function getArquivoNameAttribute()
    {
        return basename($this->arquivo);
    }
}
