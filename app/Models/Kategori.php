<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;
    protected $table = 'category';
    protected $fillable = [
        'category',
        'description',
    ];

    public function getCategoryAttribute($value)
    {
        switch ($value) {
            case 'A':
                return 'ALAT';
            case 'M':
                return 'MODAL';
            case 'BHP':
                return 'BARANG HABIS PAKAI';
            case 'BTHP':
                return 'BARANG TIDAK HABIS PAKAI';
        }
    }
}
