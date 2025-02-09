<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;
    protected $fillable = ['first_name', 'last_name', 'gender', 'cpf', 'birthday'];
    protected $appends = ['birthday_formatted', 'cpf_formatted'];

    public function getBirthdayFormattedAttribute()
    {
        return Carbon::parse($this->attributes['birthday'])->format('d/m/Y');
    }

    public function getCpfFormattedAttribute()
    {
        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $this->attributes['cpf']);
    }
}
