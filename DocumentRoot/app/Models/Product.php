<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'provider_id',
        'title',
        'price',
        'display',
        'comment',
        'vote',
        'buyer_comment_vote',
    ];

    /**
     * The storage format of the model's date column
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the comments for the product
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the votes for the product
     */
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * Get the product owner provider
     */
    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
}
