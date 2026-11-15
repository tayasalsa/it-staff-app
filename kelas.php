<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\eloquent\Factories\HasFactory;

class kelas extends Model
{
    //
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = 
    [
        'kelas',
        'jurusan',
        'tingkat',
    ];

    public function siswa()
    {
        return $this->hasMany(siswa::class);
    }
}
