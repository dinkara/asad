<?php

namespace App\Transformers;

use App\Models\Srk;
use Dinkara\DinkoApi\Transformers\ApiTransformer;
/**
 * Description of SrkTransformer
 *
 * @author Dinkic
 */
class SrkTransformer extends ApiTransformer{
    
    protected $defaultIncludes = [];
    protected $availableIncludes = [];
    protected $pivotAttributes = [];
    
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(Srk $item)
    {
        return $this->transformFromModel($item, $this->pivotAttributes);
    }
    


    
}
