<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\Api\ResponseTrait;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
/**
 * @OA\Info(
 *      title="Swagger API - Taiyou ",
 *      version="1.0.0",
 *      description="Swagger API for Taiyou project",
 *      termsOfService = "https://uat-taiyou.ekbana.net/terms&condition",
 *      @OA\Contact(
 *          name = "API Support (Ekbana)",
 *          email="support@ekbana.com",
 *          url = "https://support.ekbana.info"
 *      ),
 * @OA\License(
 *      name = "Apache 2.0",
 *      url = "http://www.apache.org/licenses/LICENSE-2.0.html"
 * ),
 * ),
 * @OA\Server(
 *     description="Taiyou API Server Local",
 *     url="http://127.0.0.1:8000/api/v1"
 * ),
 *  * @OA\Server(
 *     description="Taiyou API Server",
 *     url="https://dev-taiyou.ekbana.info/api/v1"
 * ),
 */
class ApiController extends Controller
{
  use ResponseTrait;

  protected $fractal;

  const CODE_NOT_FOUND = '404';
  const CODE_INTERNAL_ERROR = '500';
  const CODE_UNAUTHORIZED = '401';
  const CODE_FORBIDDEN = '403';

  public function __construct(Manager $fractal)
  {
    $this->fractal = $fractal;
  }
  protected function respondWithItem($item, $callback, $resourceKey = null)
  {
    $resource = new Item($item, $callback);
    $rootScope = $this->fractal->createData($resource);
    return $this->metaEncode($rootScope->toArray());
  }

  protected function respondWithCollection($collection, $callback, $resourceKey)
  {

      $paginatedCollection = $collection->getCollection();

    $resource = new Collection($paginatedCollection, $callback, $resourceKey);

    $resource->setPaginator(new IlluminatePaginatorAdapter($collection));

    $rootScope = $this->fractal->createData($resource);
    return $this->metaEncode($rootScope->toArray());
  }

  protected function respondWithOutPagination($collection, $callback, $resourceKey)
  {
    $resource = new Collection($collection, $callback, $resourceKey);
    $rootScope = $this->fractal->createData($resource);
    return $this->metaEncode($rootScope->toArray());
  }

  protected function respondWithMultipleCollection($collectionArray) {
    $resources['data'] = [];

    foreach($collectionArray as $collection) {
      $resource = new Collection($collection['collection'], $collection['callback'], $collection['key']);
      if(isset($collection['setPagination']) && $collection['setPagination']) {
        $resource->setPaginator(new IlluminatePaginatorAdapter($collection['collection']));
      }
      $data= $this->fractal->createData($resource)->toArray();
      $resources['data'][$collection['key']] = $data;
    }
    return $this->metaEncode($resources);
  }

  public function errorForbidden($message = 'Forbidden')
  {
    return $this->setStatusCode(403)
      ->respondWithError($message, self::CODE_FORBIDDEN);
  }

  public function errorInternalError($message = 'Internal Error', $code = null)
  {
    return $this->setStatusCode($code !== null ? $code : 500)
      ->respondWithError($message, self::CODE_INTERNAL_ERROR);
  }


  public function errorNotFound($message = 'Resource Not Found')
  {
    return $this->setStatusCode(404)
      ->respondWithError($message, self::CODE_NOT_FOUND);
  }

  public function responseOk($message = "OK")
  {
    return $this->setStatusCode(200)
      ->respondWithSuccess($message);
  }

    public function responseOkWithFlag($message = "OK")
    {
        return $this->setStatusCode(200)
            ->respondWithSuccessFlag($message);
    }

    public function responseOkWithFlagValue($message = "OK", $value)
    {
        return $this->setStatusCode(200)
            ->respondWithSuccessFlagValue($message, $value);
    }

}
