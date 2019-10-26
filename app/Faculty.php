<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Faculty extends Model
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

    public function studyModels(): BelongsToMany
    {
        return $this->belongsToMany(StudyModel::class);
    }
}
