<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Dinkara\RepoBuilder\Traits\ApiModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Srk extends Model
{
    use ApiModel;

    /*
     * Items per page (default=100)
     */
    protected $limit = 10;
    
    
    
    protected $table = "srks";
       
    /**
     * The attributes by you can search data.
     *
     * @var array
     */
    protected $searchableColumns = [];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    
    /**
     * The attributes that are will be shown in transformer
     *
     * @var array
     */
    protected $displayable = [];
    
    public $timestamps = true;
    

}
