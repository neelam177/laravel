<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    //
    protected $table = 'employees';
    protected $fillable = ['name', 'email', 'address', 'image'];

    // protected function name(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn($value) => ucwords(strtolower($value)),
    //     );
    // }
}
