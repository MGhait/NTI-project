<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public $fillable = ['name', 'description', 'price','category_id','photo','added_by','needReview'];
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}
