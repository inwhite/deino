<?php

namespace Common\ArticleBundle\Repository;

use Backend\UserBundle\Security\Clusterpoint\User;
use Common\AppBundle\Repository\ClusterpointRepository;

class ClusterRepository extends ClusterpointRepository {

	/**
	 * Get category clusters.
	 * @param $limit
	 * @return mixed
	 */
	public function getCategoryClusters($limit)
	{
		$searchRequest = new \CPS_SearchRequest(['type' => self::TYPE_CLUSTER]);
		$searchRequest->setGroup('category_id', $limit);
		$searchResponse = $this->connection->sendRequest($searchRequest);
		$documents = $searchResponse->getRawDocuments(DOC_TYPE_ARRAY);
		$clusters = [];

		foreach ($documents as $document)
		{
			$categoryId = isset($document['category_id']) ? $document['category_id'] : null;
			if (!isset($clusters[$categoryId]))
			{
				$clusters[$categoryId] = [];
			}

			$clusters[$categoryId][] = $document;
		}

		return $clusters;
	}
}