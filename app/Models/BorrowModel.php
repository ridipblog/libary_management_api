<?php

namespace App\Models;

use App\Models\PublicTable\BookModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowModel extends Model
{
    use HasFactory;
    protected $table='borrow';
    protected $fillable=[
        'visitor_id',
        'book_id',
        'reserve_date',
        'due_date',
        'book_return'
    ];
    public function visitors(){
        return $this->belongsTo(VisitorsModel::class,'visitor_id');
    }
    public function books(){
        return $this->belongsTo(BookModel::class,'book_id');
    }
}
