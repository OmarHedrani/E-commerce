<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    protected $table ="likes";
    protected $fillable =[
        'id','user_id','product_id',

    ];
    protected $primaryKey ="id";
    public $timestamps = true;

    public function product(){
        return $this->belongsTo(product::Class,'product_id');}
    public function user()
    {
        return $this->belongsTo(user::Class, 'user_id');}


}
