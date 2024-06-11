<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product';
    protected $fillable=[
        'image',
        'title',
        'description',
        'price',
        'stock',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Kategori::class);
    }
}
