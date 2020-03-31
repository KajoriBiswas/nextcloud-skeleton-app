<?php

namespace OCA\SkeletonApp\Db;

use JsonSerializable;
use OCP\AppFramework\Db\Entity;

class Product extends Entity implements JsonSerializable
{

	protected $name;
	protected $quantity;
	protected $price;
	protected $sku;
	protected $category;
	protected $description;

	public function jsonSerialize(): array
	{
		return [
			'id' => $this->id,
			'name' => $this->name,
			'quantity' => $this->quantity,
			'price' => $this->price,
			'sku' => $this->sku,
			'category' => $this->category,
			'description' => $this->description,
		];
	}
}
