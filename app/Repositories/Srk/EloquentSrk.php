<?php

namespace App\Repositories\Srk;

use Dinkara\RepoBuilder\Repositories\EloquentRepo;
use App\Models\Srk;



class EloquentSrk extends EloquentRepo implements ISrkRepo {


    public function __construct() {

    }

    /**
     * Configure the Model
     * */
    public function model() {
        return new Srk;
    }


}
