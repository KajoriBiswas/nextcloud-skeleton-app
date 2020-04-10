<?php

namespace OCA\SkeletonApp\Service;

use Exception;
use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Db\MultipleObjectsReturnedException;
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

	private function handleException(Exception $e): void
	{
		if (
			$e instanceof DoesNotExistException ||
			$e instanceof MultipleObjectsReturnedException
		) {
			throw new ProductNotFound($e->getMessage());
		} else {
			throw $e;
		}
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

	public function update(
		$id,
		$name,
		$quantity,
		$price,
		$sku,
		$category,
		$description
	) {
		try {
			$product = $this->mapper->find($id);
			$product->setName($name);
			$product->setQuantity($quantity);
			$product->setPrice($price);
			$product->setSku($sku);
			$product->setCategory($category);
			$product->setDescription($description);
			return $this->mapper->update($product);
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}

	public function findAll(): array
	{
		return $this->mapper->findAll();
	}

	public function delete($id)
	{
		try {
			$product = $this->mapper->find($id);
			$this->mapper->delete($product);
			return $product;
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}
}
