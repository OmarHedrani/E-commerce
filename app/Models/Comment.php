<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table ="comments";
    protected $fillable =[
        'id','user_id','product_id','value',

    ];
    protected $primaryKey ="id";
    public $timestamps = true;
    public function product(){
        return $this->belongsTo(product::Class,'product_id');}
    public function user()
    {
        return $this->belongsTo(user::Class, 'user_id');
}}
