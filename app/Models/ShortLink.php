<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShortLink extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'link'
    ];

    public static function generateUniqueID(): string
    {
        $code = substr(md5(uniqid(rand(), true)),0,6);
        if (self::where('code', $code)->first()) {
            $code = self::generateUniqueID();
        }

        return $code;
    }
}
