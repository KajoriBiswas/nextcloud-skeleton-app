<?php

namespace OCA\SkeletonApp\Controller;

use OCP\IRequest;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\ApiController;
use OCA\SkeletonApp\Service\ProductService;

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
	 * @NoAdminRequired
	 */
	public function create(
		string $name,
		int $quantity,
		float $price,
		string $sku,
		string $category,
		string $description
	): DataResponse {
		return new DataResponse($this->service->create(
			$name,
			$quantity,
			$price,
			$sku,
			$category,
			$description
		));
	}

  /**
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 */
	public function show(): DataResponse
	{
		return new DataResponse($this->service->findAll());
	}

	/**
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 */
	public function update(
		int $id,
		string $name,
		int $quantity,
		float $price,
		string $sku,
		string $category,
		string $description
	): DataResponse {
		return new DataResponse($this->service->update(
			$id,
			$name,
			$quantity,
			$price,
			$sku,
			$category,
			$description
		));
	}
}
