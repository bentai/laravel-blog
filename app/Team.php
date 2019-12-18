<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    //
    protected $fillable = ['name','size', 'team_id'];

    public function add($user)
    {
        $this->guardAgainstTooManyMembers();
//        if ($user instanceof User)
//        {
//            return $this->members()->save($user);
//        }
        $method = $user instanceof User ? 'save' : 'saveMany';
        $this->members()->$method($user);
    }

    public function members()
    {
        return $this->hasMany(User::class);
    }

    public function count()
    {
        return $this->members()->count();
    }

    /*public function remove(User $user)
    {
        $user->update(['team_id' => null]);
    }*/
    public function remove(User $user)
    {
        $user->update(['team_id' => null]);
    }


    public function guardAgainstTooManyMembers()
    {
        if($this->members()->count() >= $this->size){
            throw new \Exception;
        }
    }

}
