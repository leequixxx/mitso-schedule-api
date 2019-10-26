<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Year extends Model
{
    //
    // PROPERTIES
    //

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'name';

    protected $fillable = [
        'name',
        'number',
    ];

    public $timestamps = false;

    //
    // RELATIONSHIPS
    //

    public function studyModels(): BelongsToMany
    {
        return $this->belongsToMany(StudyModel::class);
    }

    public function groups(): HasMany
    {
        return $this->hasMany(Group::class);
    }
}
