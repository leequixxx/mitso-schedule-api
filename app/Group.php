<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Group extends Model
{
    //
    // PROPERTIES
    //

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'name';

    protected $fillable = [
        'name',
        'title',
        'year_name',
    ];

    public $timestamps = false;

    //
    // RELATIONSHIPS
    //

    public function year(): BelongsTo
    {
        return $this->belongsTo(Year::class);
    }
}
