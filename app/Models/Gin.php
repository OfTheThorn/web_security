<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gin extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'description'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
