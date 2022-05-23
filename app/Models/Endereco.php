<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'municipio_id',
        'logradouro',
        'numero',
        'bairro'
    ];

    public function municipio() {
        return $this->belongsTo('App\Models\Municipio');
    }
}
