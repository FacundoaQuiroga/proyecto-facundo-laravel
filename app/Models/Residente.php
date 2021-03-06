<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Residente extends Model
{
    use HasFactory ;

    use SoftDeletes;


    protected $guarded = [];



    protected  $primaryKey = 'user_rut';
    public $incrementing = false;
    public $timestamps = false;
    const UPDATED_AT = false;


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function subsidio(){
        return $this->hasOne(Subsidio::class);
    }

}
