<?php

/**
 * Create your routes in here. The name is the lowercase name of the controller
 * without the controller part, the stuff after the hash is the method.
 * e.g. page#index -> OCA\SkeletonApp\Controller\PageController->index()
 *
 * The controller class has to be registered in the application.php file since
 * it's instantiated in there
 */

return [
	'routes' => [
		['name' => 'page#index', 'url' => '/', 'verb' => 'GET'],
		['name' => 'page#createProduct', 'url' => '/add-product', 'verb' => 'GET'],
		['name' => 'test#index', 'url' => '/test/index', 'verb' => 'GET'],
		['name' => 'product_api#create', 'url' => '/create', 'verb' => 'POST'],
		['name' => 'product_api#show', 'url' => '/show', 'verb' => 'GET']
	]
];
