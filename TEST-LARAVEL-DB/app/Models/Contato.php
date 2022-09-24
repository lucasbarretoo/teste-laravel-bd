<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
    use HasFactory;

    protected $table = 'contatos';
    protected $primaryKey = 'contato_id';
    protected $fillable = ['contato_id', 'nome', 'email', 'telefone', 'cpf', 'created_at', 'updated_at', 'principal'];
}
