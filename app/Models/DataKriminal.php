<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datakriminal extends Model
{
    use HasFactory;
    protected $table = 'data_kriminals';
    protected $fillable = [
        'kecamatan_id',
        'tahun',
        'tipu_online',
        'pencurian',
        'penipuan',
        'curanmor',
        'kdrt',
        'jumlah_penduduk'
    ];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function cluster()
    {
        return $this->hasOne(Cluster::class);
    }

}
