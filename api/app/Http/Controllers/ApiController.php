<?php
/**
 * ApiController
 *
 * This controller extends the base Laravel Controller
 * and adds methods specific to our API
 * 
 */
namespace App\Http\Controllers;

use Illuminate\Http\Response as IlluminateResponse;
use App\Http\Controllers\Controller;

class ApiController extends Controller {

	/**
	 * [$statusCode description]
	 * @var [type]
	 */
	protected $statusCode = IlluminateResponse::HTTP_OK;

	/**
	 * [getStatusCode description]
	 * @return [type] [description]
	 */
	public function getStatusCode()
	{
		return $this->statusCode;
	}

	/**
	 * [setStatusCode description]
	 * @param [type] $statusCode [description]
	 */
	public function setStatusCode($statusCode)
	{
		$this->statusCode = $statusCode;

		return $this;
	}

	/**
	 * [respondNotFound description]
	 * @param  [type] $message [description]
	 * @return [type]          [description]
	 */
	public function respondNotFound($message = "Not Found")
	{
		return $this->setStatusCode(IlluminateResponse::HTTP_NOT_FOUND)->respondWithError($message);
	}

	/**
	 * [respondInternalError description]
	 * @param  string $message [description]
	 * @return [type]          [description]
	 */
	public function respondInternalError($message = "Internal Error")
	{
		return $this->setStatusCode(IlluminateResponse::HTTP_INTERNAL_SERVER_ERROR)->respondWithError($message);
	}

	/**
	 * [respondInternalError description]
	 * @param  string $message [description]
	 * @return [type]          [description]
	 */
	public function respondBadRequest($message = "Bad Request")
	{
		return $this->setStatusCode(IlluminateResponse::HTTP_BAD_REQUEST)->respondWithError($message);
	}

	/**
	 * [respondInternalError description]
	 * @param  string $message [description]
	 * @return [type]          [description]
	 */
	public function respondCreated($message = "Created")
	{
		return $this->setStatusCode(IlluminateResponse::HTTP_CREATED)->respond([			
			'data' => [
				'message' => $message,
				'status_code' => $this->getStatusCode()
			]
		]);
	}


	/**
	 * [respond description]
	 * @param  [type] $data    [description]
	 * @param  array  $headers [description]
	 * @return [type]          [description]
	 */
	public function respond($data, $headers = [])
	{
		return response($data, $this->getStatusCode(), $headers);
	}

	/**
	 * [respondWithError description]
	 * @param  [type] $message [description]
	 * @return [type]          [description]
	 */
	public function respondWithError($message)
	{
		return $this->respond([
			'error' => [
				'message' => $message,
				'status_code' => $this->getStatusCode()
			]
		]);
	}
}