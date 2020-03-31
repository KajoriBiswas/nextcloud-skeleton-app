<?php

namespace OCA\SkeletonApp\Controller;

use Doctrine\DBAL\Types\IntegerType;
use OCP\IRequest;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\ApiController;
use OCA\SkeletonApp\Service\ProductService;
use Sabre\VObject\Property\Text;

class ProductApiController extends ApiController
{
	use Errors;

	/** @var NoteService */
	private $service;

	/** @var string */
	private $userId;

	public function __construct(
		$appName,
		IRequest $request,
		NoteService $service,
		$userId
	) {
		parent::__construct($appName, $request);
		$this->service = $service;
		$this->userId = $userId;
	}

	/**
	 * @CORS
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 */
	public function index(): DataResponse
	{
		return new DataResponse($this->service->findAll($this->userId));
	}

	/**
	 * @CORS
	 * @NoCSRFRequired
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
