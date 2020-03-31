<?php

namespace OCA\SkeletonApp\Service;

use OCA\SkeletonApp\Db\Product;
use OCA\SkeletonApp\Db\ProductMapper;

class ProductService
{
	/** @var ProductMapper */
	private $mapper;

	public function __construct(ProductMapper $mapper)
	{
		$this->mapper = $mapper;
	}

	public function create($name, $quantity, $price, $sku, $category, $description)
	{
		$product = new Product();
		$product->setName($name);
		$product->setQuantity($quantity);
		$product->setPrice($price);
		$product->setSku($sku);
		$product->setCategory($category);
		$product->setDescription($description);
		return $this->mapper->insert($product);
	}

}
