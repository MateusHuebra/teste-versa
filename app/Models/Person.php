<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $fillable = ['first_name', 'last_name', 'gender', 'cpf', 'birthday'];
    protected $appends = ['birthday_formatted'];

    public function getBirthdayFormattedAttribute()
    {
        return Carbon::parse($this->attributes['birthday'])->format('d/m/Y');
    }
}
