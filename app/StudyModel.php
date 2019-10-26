<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class StudyModel extends Model
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
    ];

    public $timestamps = false;

    //
    // RELATIONSHIPS
    //

    public function faculties(): BelongsToMany
    {
        return $this->belongsToMany(Faculty::class);
    }

    public function years(): BelongsToMany
    {
        return $this->belongsToMany(Year::class);
    }
}
