<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'restaurant_id',
    ];

    public static function toggleFavorite($restaurantId, $email)
    {
        $favorite = Favorite::where('restaurant_id', $restaurantId)->where('email', $email)->first();
        
        if ($favorite) {
            $favorite->delete();
        } else {
            Favorite::create(['restaurant_id' => $restaurantId, 'email' => $email]);
        }
    }
}
