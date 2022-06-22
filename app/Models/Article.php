<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    use HasFactory;
    protected $guarded = [];
    /**
     * @return  BelongsTo relation with Category model
    */
    public function categories(){
        return $this->belongsTo(Category::class);
    }

    /**
     * @return  BelongsTo relation with User model
     */
    public function user(){
        return $this->belongsTo(User::class);
    }
}
