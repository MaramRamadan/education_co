<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    const STATUS_AUTHORIZED = 1;
    const STATUS_DECLINE = 2;
    const STATUS_REFUNDED = 3;


     /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'name',
        'id',
        'created_at',
        'updated_at',
    ];

    /**
     * Disable automatic timestamp management.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the user associated with the transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'parent_email', 'email');
    }


}
