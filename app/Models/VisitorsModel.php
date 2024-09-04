<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VisitorsModel extends Model
{
    use HasFactory;
    protected $table='visitors';
    protected $fillable=[
        'email',
        'name'
    ];
    public function borrow(){
        return $this->hasMany(BorrowModel::class,'visitor_id');
    }
}
