<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'restaurant_id',
    ];

    public static function toggleFavorite($restaurantId, $user_id)
    {
        $favorite = Favorite::where('restaurant_id', $restaurantId)->where('user_id', $user_id)->first();
        
        if ($favorite) {
            $favorite->delete();
        } else {
            Favorite::create(['restaurant_id' => $restaurantId, 'user_id' => $user_id]);
        }
    }

    public static function getFavoriteRestaurantIds($user_id)
    {
        return self::where('user_id', $user_id)->pluck('restaurant_id');
    }
}
