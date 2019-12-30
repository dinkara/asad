<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Profile\IProfileRepo;
use Tymon\JWTAuth\Facades\JWTAuth;
use Dinkara\DinkoApi\Http\Controllers\ResourceController;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Database\QueryException;
use Storage;
use ApiResponse;
use App\Transformers\UserTransformer;
use App\Transformers\RoleTransformer;
use App\Transformers\SocialNetworkTransformer;
use App\Transformers\UserSessionTransformer;
use App\Http\Requests\UserAttachRoleRequest;
use App\Http\Requests\UserAttachSocialNetworkRequest;
use App\Repositories\User\IUserRepo;
use App\Repositories\Role\IRoleRepo;
use App\Repositories\SocialNetwork\ISocialNetworkRepo;


/**
 * @resource User
 */
class UserController extends ResourceController
{
    
    public function __construct(IProfileRepo $profileRepo, IUserRepo $repo, UserTransformer $transformer, IRoleRepo $roleRepo, ISocialNetworkRepo $socialNetworkRepo) {
        parent::__construct($repo, $transformer);
	    $this->profileRepo = $profileRepo;
	    $this->roleRepo = $roleRepo;
	    $this->socialNetworkRepo = $socialNetworkRepo;


        $this->middleware('exists.role:role_id,true', ['only' => ['attachRole', 'detachRole']]);
        $this->middleware('exists.socialnetwork:social_network_id,true', ['only' => ['attachSocialNetwork', 'detachSocialNetwork']]);

    }    
    
    /**
     * Me
     * 
     * Display currently logged in user.
     *     
     * @return \Illuminate\Http\Response
     */
    public function me()
    {
        try {
            $user = JWTAuth::parseToken()->toUser();
            
            if($item = $this->repo->find($user->id)){

                return ApiResponse::Item($item->getModel(), new $this->transformer);
            }
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        }    
        
        return ApiResponse::ItemNotFound($this->repo->getModel());
        
    }
    
    /**
     * Update profile
     * 
     * Update profile info.
     *
     * @param  App\Http\Requests\UpdateProfileRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfileRequest $request)
    {       
            try {
                $user = JWTAuth::parseToken()->toUser();
                $data = $request->only(array_keys($request->rules()));
                
                if( $item = $this->profileRepo->find($user->profile->id)){
                    if($request->file("avatar")){
                        if($item->getModel()->avatar != "user.png") {
                            Storage::delete($item->getModel()->avatar);
                        }
                        $data["avatar"] = $request->file("avatar")->store(config("storage.profiles.avatar"));
                    }
                    $item->update($data);
                    //refresh user after update
                    return ApiResponse::ItemUpdated($this->repo->find($user->id)->getModel(), new $this->transformer, class_basename($this->repo->getModel()));
                }
            } catch (QueryException $e) {
                return ApiResponse::InternalError($e->getMessage());
            }
    }

    /**
     * Search for Roles
     *
     * Roles from existing resource.
     *
     * @param Request $request
     * @return Dinkara\DinkoApi\Support\ApiResponse
     */
    public function searchRoles(Request $request)
    {	   
        try{
            $user = JWTAuth::parseToken()->toUser();
            return ApiResponse::Pagination($user->roles($request->q, $request->orderBy)->paginate($request->pagination), new RoleTransformer);
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        }
    }

    /**
     * Search for SocialNetworks
     *
     * SocialNetworks from existing resource.
     *
     * @param Request $request
     * @return Dinkara\DinkoApi\Support\ApiResponse
     */
    public function searchSocialNetworks(Request $request)
    {	   
        try{
            $user = JWTAuth::parseToken()->toUser();
            return ApiResponse::Pagination($user->socialNetworks($request->q, $request->orderBy)->paginate($request->pagination), new SocialNetworkTransformer);
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        }
    }

    /**
     * Search for UserSessions
     *
     * UserSessions from existing resource.
     *
     * @param Request $request
     * @return Dinkara\DinkoApi\Support\ApiResponse
     */
    public function searchUserSessions(Request $request)
    {	   
        try{
            $user = JWTAuth::parseToken()->toUser();
            return ApiResponse::Pagination($user->userSessions($request->q, $request->orderBy)->paginate($request->pagination), new UserSessionTransformer);
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        }
    }


    /**
     * Attach Role
     *
     * Attach the Role to existing User.
     *
     * @param  App\Http\Requests\UserAttachRoleRequest  $request
     * @param  int  $role_id
     * @return \Illuminate\Http\Response
     */
    public function attachRole(UserAttachRoleRequest $request, $role_id)
    {
        try{
            if($item = $this->roleRepo->find($role_id)){
                $data = $request->only(array_keys($request->rules()));

                $user = JWTAuth::parseToken()->toUser();

                $model = $item->getModel();

                return ApiResponse::ItemAttached($this->repo->find($user->id)->attachRole($model, $data)->getModel(), $this->transformer);
            }else{
                return ApiResponse::ItemNotFound($this->roleRepo->getModel());
            }
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        }

        return ApiResponse::ItemNotFound($this->repo->getModel());
    }

        /**
     * Attach SocialNetwork
     *
     * Attach the SocialNetwork to existing User.
     *
     * @param  App\Http\Requests\UserAttachSocialNetworkRequest  $request
     * @param  int  $social_network_id
     * @return \Illuminate\Http\Response
     */
    public function attachSocialNetwork(UserAttachSocialNetworkRequest $request, $social_network_id)
    {
        try{
            if($item = $this->socialNetworkRepo->find($social_network_id)){
                $data = $request->only(array_keys($request->rules()));

                $user = JWTAuth::parseToken()->toUser();

                $model = $item->getModel();

                return ApiResponse::ItemAttached($this->repo->find($user->id)->attachSocialNetwork($model, $data)->getModel(), $this->transformer);
            }else{
                return ApiResponse::ItemNotFound($this->socialNetworkRepo->getModel());
            }
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        }

        return ApiResponse::ItemNotFound($this->repo->getModel());
    }

    
    /**
     * Detach Role
     *
     * Detach the specified resource from existing resource.
     *
     * @param  int  $role_id
     * @return \Illuminate\Http\Response
     */
    public function detachRole($role_id)
    {
        try{
            if($item = $this->roleRepo->find($role_id)){
                $model = $item->getModel();

                $user = JWTAuth::parseToken()->toUser();

                return ApiResponse::ItemDetached($this->repo->find($user->id)->detachRole($model)->getModel());
            }else{
                return ApiResponse::ItemNotFound($this->roleRepo->getModel());
            }
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        }

        return ApiResponse::ItemNotFound($this->repo->getModel());
    }
    /**
     * Detach SocialNetwork
     *
     * Detach the specified resource from existing resource.
     *
     * @param  int  $social_network_id
     * @return \Illuminate\Http\Response
     */
    public function detachSocialNetwork($social_network_id)
    {
        try{
            if($item = $this->socialNetworkRepo->find($social_network_id)){
                $model = $item->getModel();

                $user = JWTAuth::parseToken()->toUser();

                return ApiResponse::ItemDetached($this->repo->find($user->id)->detachSocialNetwork($model)->getModel());
            }else{
                return ApiResponse::ItemNotFound($this->socialNetworkRepo->getModel());
            }
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        }

        return ApiResponse::ItemNotFound($this->repo->getModel());
    }

}