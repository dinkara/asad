<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dinkara\RepoBuilder\Traits\ApiModel;
use App\Traits\HasPermissionsTrait;
class User extends Authenticatable
{
    use ApiModel;
    use SoftDeletes;
    use HasPermissionsTrait;
    
    /**
     * The attributes by you can search data.
     *
     * @var array
     */
    protected $searchableColumns = ['email', 'password_updated', 'last_login'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email', 'password', 'confirmation_code', 'status', 'password_updated'];

    /**
     * The attributes that are will be shown in transformer
     *
     * @var array
     */
    protected $displayable = ['email', 'password_updated', 'last_login'];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
    
    
    public function passwordReset($q = null, $orderBy = null)
    {
        $relation = $this->hasOne('App\Models\PasswordReset', 'user_id');
        if($q == null && $orderBy == null){
            return $relation;
        }
        return $this->searchRelation($relation, $q, $orderBy);
    }
    public function userSessions($q = null, $orderBy = null)
    {
        $relation = $this->hasMany('App\Models\UserSession', 'user_id');
        if($q == null && $orderBy == null){
            return $relation;
        }
        return $this->searchRelation($relation, $q, $orderBy);
    }
    public function profile($q = null, $orderBy = null)
    {
        $relation = $this->hasOne('App\Models\Profile', 'user_id');
        if($q == null && $orderBy == null){
            return $relation;
        }
        return $this->searchRelation($relation, $q, $orderBy);
    }
    public function roles($q = null, $orderBy = null)
    {
        $relation = $this->belongsToMany('App\Models\Role', 'users_roles', 'user_id', 'role_id')
                         ->withTimestamps();
        if($q == null && $orderBy == null){
            return $relation;
        }
        return $this->searchRelation($relation, $q, $orderBy);
    }
    public function socialNetworks($q = null, $orderBy = null)
    {
        $relation = $this->belongsToMany('App\Models\SocialNetwork', 'users_social_networks', 'user_id', 'social_network_id')
                         ->withTimestamps()->withPivot('access_token', 'provider_id');
        if($q == null && $orderBy == null){
            return $relation;
        }
        return $this->searchRelation($relation, $q, $orderBy);
    }

}
