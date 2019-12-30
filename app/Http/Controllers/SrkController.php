<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreSrkRequest;
use App\Http\Requests\BulkSrkRequest;
use App\Http\Requests\BulkDeleteSrkRequest;
use App\Http\Requests\UpdateSrkRequest;
use Tymon\JWTAuth\Facades\JWTAuth;
use Dinkara\DinkoApi\Http\Controllers\ResourceController;
use Storage;
use ApiResponse;
use Carbon\Carbon;
use App\Transformers\SrkTransformer;
use App\Repositories\Srk\ISrkRepo;


/**
 * @resource Srk
 */
class SrkController extends ResourceController
{

    public function __construct(ISrkRepo $repo, SrkTransformer $transformer) {
        parent::__construct($repo, $transformer);


        $this->middleware('owns.srk', ['only' => []]);


    }
    
    /**
     * Create item
     * 
     * Store a newly created item in storage.
     *
     * @param  App\Http\Requests\StoreSrkRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSrkRequest $request)
    {       
        $data = $request->only(array_intersect($request->keys(), $this->repo->getModel()->getFillable()));

	
        return $this->storeItem($data);
    }

    /**
     * Update item 
     * 
     * Update the specified item in storage.
     *
     * @param  App\Http\Requests\UpdateSrkRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSrkRequest $request, $id)
    {
        $data = $request->only(array_intersect($request->keys(), $this->repo->getModel()->getFillable()));

	
        return $this->updateItem($data, $id);
    }

        /**
     * Remove item
     * 
     * Remove the specified item from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            if($item = $this->repo->find($id)){

                $item->delete($id);
                return ApiResponse::ItemDeleted($this->repo->getModel());
            }
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        } 
        
        return ApiResponse::ItemNotFound($this->repo->getModel());       
    }

    /**
     * Bulk Insert
     *
     * Bulk insert multiple resources
     *
     * @param  App\Http\Requests\BulkSrkRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function bulkInsert(BulkSrkRequest $request)
    {
        try{
            $input = $request->data;
            $data = [];
            $fillable = array_flip(array_map('value', $this->repo->getModel()->getFillable()));

            foreach($input as $item) {
                //removing keys which are not fillable!
                $row = array_intersect_key($item, $fillable);
                $row['created_at'] = $row['updated_at'] = Carbon::now();



                $data[] = $row;
            }

            $this->repo->bulk($data);

            return ApiResponse::SuccessMessage(trans('dinkoapi.response_message.succesfully_created'));
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        }
    }

    /**
     * Bulk Delete
     *
     * Bulk delete multiple resources
     *
     * @param  App\Http\Requests\BulkSrkRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function bulkDelete(BulkDeleteSrkRequest $request)
    {
        try{
            $input = $request->data;
            foreach($input as $item){
                $id = $item['id'];
                if($this->repo->find($id)){

                    $this->repo->delete($id);
                }
            }

            return ApiResponse::SuccessMessage(trans('dinkoapi.response_message.succesfully_deleted'));
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        }


    }




}