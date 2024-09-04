<?php

namespace App\Models\PublicTable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriesModel extends Model
{
    use HasFactory;
    protected $table='categories';
    protected $fillable=[
        'category'
    ];
}
