<?php

declare(strict_types=1);

namespace OCA\SkeletonApp\Migration;

use Closure;
use OCP\DB\ISchemaWrapper;
use OCP\Migration\IOutput;
use OCP\Migration\SimpleMigrationStep;

/**
 * Auto-generated migration step: Please modify to your needs!
 */
class Version000001Date20200331120739 extends SimpleMigrationStep {

	/**
	 * @param IOutput $output
	 * @param Closure $schemaClosure The `\Closure` returns a `ISchemaWrapper`
	 * @param array $options
	 * @return null|ISchemaWrapper
	 */
	public function changeSchema(IOutput $output, Closure $schemaClosure, array $options) {
		/** @var ISchemaWrapper $schema */
		$schema = $schemaClosure();

		if (!$schema->hasTable('products')) {
			$table = $schema->createTable('products');
			$table->addColumn('id', 'integer', [
				'autoincrement' => true,
				'notnull' => true,
			]);
			$table->addColumn('name', 'string', [
				'notnull' => true,
				'length' => 50
			]);
			$table->addColumn('quantity', 'integer', [
				'notnull' => true,
				'length' => 12,
			]);
			$table->addColumn('price', 'decimal', [
				'notnull' => true,
				'precision' => 12,
				'scale' => 10,
			]);
			$table->addColumn('sku', 'string', [
				'notnull' => true,
				'default' => '',
				'length' => 12,
			]);
			$table->addColumn('category', 'string', [
				'notnull' => true,
				'default' => '',
				'length' => 50,
			]);
			$table->addColumn('description', 'text', [
				'notnull' => true,
				'default' => ''
			]);

			$table->setPrimaryKey(['id']);
		}
		return $schema;
	}
}
