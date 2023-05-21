<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'company_address',
        'company_location',
        'company_industry',
        'company_size',
        'logo',
        'logo_path',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
