<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'thumbnail',
        'about',
        'category_id',
        'client_id',
        'budget',
        'skill_level',
        'has_finished',
        '',
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function owner(){
        return $this->belongsTo(User::class, 'client_id', 'id');
    }
    public function tools(){
        return $this->belongsTo(Tool::class, 'project_tool', 'project_id', 'tool_id')
        ->wherePivotNull('deleted_at')
        ->wherePivot('id');
    }
    public function applicants(){
        return $this->hasMany(ProjectApplicant::class);
    }
}