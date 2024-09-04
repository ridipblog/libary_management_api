<?php

namespace App\Models\PublicTable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookLanguagesModel extends Model
{
    use HasFactory;
    protected $table='book_languages';
    protected $fillable=[
        'language'
    ];
}
