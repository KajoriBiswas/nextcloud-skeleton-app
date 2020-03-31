<?php

namespace OCA\SkeletonApp\Db;

use OCP\AppFramework\Db\QBMapper;
use OCP\IDBConnection;

class ProductMapper extends QBMapper
{

	public function __construct(IDBConnection $db)
	{
		parent::__construct($db, 'products', Product::class);
	}

}
