<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{

    const ROLE_ADMIN = 'admin';
    const ROLE_EDITOR = 'editor';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title','slug'];

    /**
     * Return the role's users
     */
    public function users(): belongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
