<?php

namespace App\Http\Middleware;

use Closure;
use Dinkara\DinkoApi\Http\Middleware\DinkoApiOwnerMiddleware;
use App\Repositories\UserSession\IUserSessionRepo;


class UserSessionOwner extends DinkoApiOwnerMiddleware
{            
    
    /**
     * Create a new UserSession Middleware instance.
     *
     * @return void
     */
    public function __construct(IUserSessionRepo $repo) {
        $this->repo = $repo;        
    }
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {                     
        /*
         * Extend logic if needed
         */
	return parent::handle($request, $next);			
    }
}
