<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Quiz extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'time_limit',
        'cover_path',
        'experience_amount',
        'randomize_questions'
    ];

    protected $searchableFields = ['*'];

    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        static::creating(function ($quiz) {
            $quiz->slug = (string) Str::slug($quiz->name);
        });
    }

    public function quizResults()
    {
        return $this->hasMany(QuizResult::class);
    }

    public function objectiveQuestions(): HasMany
    {
        return $this->hasMany(ObjectiveQuestion::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function learningPaths()
    {
        return $this->belongsToMany(LearningPath::class);
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class);
    }
}