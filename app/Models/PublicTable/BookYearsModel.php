<?php

namespace App\Models\PublicTable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookYearsModel extends Model
{
    use HasFactory;
    protected $table='book_years';
    protected $fillable=[
        'year'
    ];
}
