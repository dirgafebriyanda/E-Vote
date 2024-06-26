<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voter extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function election()
    {
        return $this->belongsTo(election::class, 'election_id', 'id');
    }
    public function vote()
    {
        return $this->hasMany(Vote::class, 'voter_id', 'id');
    }
}
