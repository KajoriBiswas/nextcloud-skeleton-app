<?php

namespace OCA\SkeletonApp\Controller;

use OCP\IRequest;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\ApiController;
use OCA\SkeletonApp\Service\ProductService;
use Sabre\VObject\Property\Text;

class ProductApiController extends ApiController
{
	use Errors;

	/** @var ProductService */
	private $service;

	/** @var string */
	private $userId;

	public function __construct(
		$appName,
		IRequest $request,
		ProductService $service,
		$userId
	) {
		parent::__construct($appName, $request);
		$this->service = $service;
		$this->userId = $userId;
	}

	/**
	 * @CORS
	 * @NoAdminRequired
	 */
	public function create(
		string $name,
		integer $quantity,
		decimal $price,
		string $sku,
		string $category,
		text $description): DataResponse
	{
		return new DataResponse($this->service->create(
			$name,
			$quantity,
			$price,
			$sku,
			$category,
			$description
		));
	}
}
