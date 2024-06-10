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
        if($value == 'A'){
            return 'ALAT';
        } elseif($value == 'M'){
            return 'MODAL';
        } elseif($value == 'BHP'){
            return 'BARANG HABIS PAKAI';
        } elseif($value == 'BTHP'){
            return 'BARANG TIDAK HABIS PAKAI';
        }
        return $value;
    }
}
