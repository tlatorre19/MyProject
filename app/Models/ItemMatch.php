<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemMatch extends Model
{
    use HasFactory;

    protected $table = 'matches';

    protected $fillable = [
        'lost_item_id',
        'found_item_id',
    ];

    // belongs to a Lost Item
    public function lostItem()
    {
        return $this->belongsTo(Item::class, 'lost_item_id');
    }

    // belongs to a Found Item
    public function foundItem()
    {
        return $this->belongsTo(Item::class, 'found_item_id');
    }
}