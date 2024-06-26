<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    
    public function voter()
    {
        return $this->belongsTo(Voter::class, 'voter_id', 'id');
    }
    public function election()
    {
        return $this->belongsTo(election::class, 'election_id', 'id');
    }
}
