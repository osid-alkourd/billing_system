<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoice_detail extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id' , 'invoice_number' , 'product' ,
         'section_id' , 'Status' , 'Value_Status' ,
        'Payment_Date' , 'note' , 'created_by' ,
    ];

    public function section(){
       return $this->belongsTo(Section::class , 'section_id' , 'id');
    }
}
