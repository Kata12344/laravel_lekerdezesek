<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Copy;
use App\Models\User;
//use App\Models\Traits\HasCompositeKeys;

class Lending extends Model
{
    use HasFactory;

    protected function setKeysForSaveQuery($query)
    {
        $query
            ->where('user_id', '=', $this->getAttribute('user_id'))
            ->where('copy_id', '=', $this->getAttribute('copy_id'))
            ->where('start', '=', $this->getAttribute('start')); 

        return $query;
    } 

    protected $fillable = [
        'user_id',
        'copy_id',
        'start'
    ];

    public function copy_c()
    {    return $this->hasOne(Copy::class, 'copy_id', 'copy_id');   }

    public function user_c()
    {    return $this->hasOne(User::class, 'id', 'user_id');   }

}
