<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Faculty
 *
 * @property string $name
 * @property string $title
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\StudyModel[] $studyModels
 * @property-read int|null $study_models_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Faculty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Faculty newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Faculty query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Faculty whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Faculty whereTitle($value)
 */
	class Faculty extends \Eloquent {}
}

namespace App{
/**
 * App\StudyModel
 *
 * @property string $name
 * @property string $title
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Faculty[] $faculties
 * @property-read int|null $faculties_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Year[] $years
 * @property-read int|null $years_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudyModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudyModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudyModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudyModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudyModel whereTitle($value)
 */
	class StudyModel extends \Eloquent {}
}

namespace App{
/**
 * App\Year
 *
 * @property string $name
 * @property int $number
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\StudyModel[] $studyModels
 * @property-read int|null $study_models_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Year newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Year newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Year query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Year whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Year whereNumber($value)
 */
	class Year extends \Eloquent {}
}

namespace App{
/**
 * App\Day
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon $date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Day newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Day newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Day query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Day whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Day whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Day whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Day whereUpdatedAt($value)
 */
	class Day extends \Eloquent {}
}

