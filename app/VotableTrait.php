<?php
namespace App;
use App\Models\User;

trait VotableTrait{
    public function votes()
    {
        return $this->morphToMany(User::class,'votable');
    }

    public function upVotes()
    {
        return $this->votes()->where('vote',1);
    }
    public function downVotes()
    {
        return $this->votes()->where('vote',-1);
    }
}