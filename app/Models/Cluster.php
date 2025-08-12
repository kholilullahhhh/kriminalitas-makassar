<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cluster extends Model
{
    use HasFactory;
    protected $fillable = ['data_kriminal_id', 'cluster', 'nilai', 'kategori'];

    public function dataKriminal()
    {
        return $this->belongsTo(Datakriminal::class, 'data_kriminal_id');
    }

}
