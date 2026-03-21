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
    ];

    // Item belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Item has matches as a Lost item ✅ added
    public function lostMatches()
    {
        return $this->hasMany(ItemMatch::class, 'lost_item_id');
    }

    // Item has matches as a Found item ✅ added
    public function foundMatches()
    {
        return $this->hasMany(ItemMatch::class, 'found_item_id');
    }
}