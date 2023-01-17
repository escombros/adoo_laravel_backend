<?php

namespace App\Models;
//use App\Http\Traits\LocaleInfoModel;

//use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 

class Pdf extends Model
{
    use HasFactory;
    protected $table = 'Pdf';
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'folio',
        'pdf'
    ];


    protected $dates = [
        'created_at',
        'updated_at'
    ];

  
    
    protected $casts = [
        //'email_verified_at' => 'datetime',
        'date' => 'date:d-m-Y',
    ];
    
}
