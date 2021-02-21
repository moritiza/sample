<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'approve',
        'vote',
        'created_at'
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
     * Get the vote owner user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the vote owner product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
