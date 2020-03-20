<?php

namespace OCA\SkeletonApp\Db;

use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Db\QBMapper;
use OCP\DB\QueryBuilder\IQueryBuilder;
use OCP\IDBConnection;

class NoteMapper extends QBMapper
{

	public function __construct(IDBConnection $db)
	{
		parent::__construct($db, 'notestutorial', Note::class);
	}
}
