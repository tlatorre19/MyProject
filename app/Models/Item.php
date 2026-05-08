<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'date',
        'type',
        'status',
        'reporter_name',
        'contact_no',
        'photo',  
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function lostMatches()
    {
        return $this->hasMany(ItemMatch::class, 'lost_item_id');
    }

    
    public function foundMatches()
    {
        return $this->hasMany(ItemMatch::class, 'found_item_id');
    }
}