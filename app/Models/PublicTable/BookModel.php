<?php

namespace App\Models\PublicTable;

use App\Models\BorrowModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookModel extends Model
{
    use HasFactory;
    protected $table='books';
    protected $fillable=[
        'title',
        'author',
        'publisher',
        'book_year_id',
        'book_lang_id',
        'category_id',
        'book_stock',
        'book_image_url'
    ];
    public function categories(){
        return $this->belongsTo(CategoriesModel::class,'category_id');
    }
    public function book_years(){
        return $this->belongsTo(BookYearsModel::class,'book_year_id');
    }
    public function book_languages(){
        return $this->belongsTo(BookLanguagesModel::class,'book_lang_id');
    }
    public function borrow(){
        return $this->hasMany(BorrowModel::class,'book_id');
    }
}
