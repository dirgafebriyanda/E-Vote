<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

     public function voter()
    {
        return $this->hasMany(Voter::class, 'election_id', 'id');
    }
     public function vote()
    {
        return $this->hasMany(Vote::class, 'election_id', 'id');
    }
     public function candidate()
{
    return $this->hasMany(Candidate::class, 'election_id', 'id');
}

}
