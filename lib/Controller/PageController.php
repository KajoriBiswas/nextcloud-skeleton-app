<?php

namespace OCA\SkeletonApp\Controller;

use OCP\IRequest;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Controller;

class PageController extends Controller
{

	public function __construct($appName, IRequest $request)
	{
		parent::__construct($appName, $request);
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function index()
	{
		return new TemplateResponse($this->appName, 'main');
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 *
	 * @return TemplateResponse
	 */
	public function createProduct(): TemplateResponse
	{
		return new TemplateResponse($this->appName, 'main');
	}
}
