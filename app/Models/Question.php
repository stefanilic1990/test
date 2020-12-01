<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\VotableTrait;

class Question extends Model
{
    use HasFactory;
    use VotableTrait;
    protected $fillable=['title','body'];

    protected $appends=['created_date','is_favorited','favorites_count','body_html'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = str_slug($value);
    }
    
    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }
    public function getUrlAttribute()
    {
        return route('questions.show',$this->slug);
       
    }
    public function getStatusAttribute()
    {
        if ($this->answers_count >0) {
            if ($this->best_answere_id) {
                return "answered-accepted";
            } else {
                return "answered";
            }
        }
        return "unanswered";
    }
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
    public function acceptBestAnswer(Answer $answers)
    {
        $this->best_answere_id = $answers->id;
        $this->save();
    }
    public function favorites()
    {
        return $this->belongsToMany(User::class,'favorites')->withTimestamps();
    }
    public function isFavorited()
    {
        return $this->favorites()->where('user_id', auth()->id() )->count() >0;
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    public function getBodyHtmlAttribute()
    {
        return parsedown($this->body, true);
    }
}
