<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApiRequest extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    /**
     * Indicates which attributes are fillable.
     * @var array
     */
    public $fillable = [
        'data'
    ];
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'api_requests';
    /**
     * Indicates which attributes should be casted.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'json'
    ];


}
