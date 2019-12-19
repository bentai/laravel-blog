<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    //
    protected $fillable = ['name','size', 'team_id'];

    public function add($user)
    {
        $this->guardAgainstTooManyMembers($user);
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

    public function remove(User $user)
    {
//        $user->update(['team_id' => 0]);
//        $this->members()->where(['id'=>$user->id])->update(['team_id' => 0]);
        if ($user instanceof User)
        {
            return $user->leaveTeam();
        }
        return $this->removeMany($user);
    }

    public function removeMany($users)
    {
        return $this->members()->whereIn('id', $users->pluck('id'))
            ->update(['team_id' => null]);
    }

    public function restart()
    {
        $this->member()->update(['team_id' => null]);
    }

    public function guardAgainstTooManyMembers($user)
    {
        $numUsersToAdd = $user instanceof User ? 1 : count($user);

        $newTeamCount = $this->count() + $numUsersToAdd;

        if($newTeamCount > $this->size){
            throw new \Exception;
        }
    }

}
