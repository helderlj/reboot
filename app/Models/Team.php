<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name'];

    protected $searchableFields = ['*'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function learningPaths()
    {
        return $this->belongsToMany(LearningPath::class);
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class);
    }

    public function learningArtifacts()
    {
        return $this->belongsToMany(LearningArtifact::class);
    }

    public function learningPathGroups()
    {
        return $this->belongsToMany(LearningPathGroup::class);
    }
}
