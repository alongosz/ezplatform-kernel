<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace eZ\Publish\Core\Search\Legacy\Content\Common\Gateway\SortClauseHandler\Trash;

use Doctrine\DBAL\Query\QueryBuilder;
use eZ\Publish\Core\Persistence\Legacy\Content\Type\Gateway as ContentTypeGateway;
use eZ\Publish\Core\Search\Legacy\Content\Common\Gateway\SortClauseHandler;
use eZ\Publish\API\Repository\Values\Content\Query\SortClause;

class ContentTypeName extends SortClauseHandler
{
    public function accept(SortClause $sortClause): bool
    {
        return $sortClause instanceof SortClause\Trash\ContentTypeName;
    }

    public function applySelect(
        QueryBuilder $query,
        SortClause $sortClause,
        int $number
    ): array {
        $query
            ->addSelect(
                sprintf(
                    'cc.identifier AS %s',
                    $column = $this->getSortColumnName($number)
                )
            );

        return (array)$column;
    }

    public function applyJoin(
        QueryBuilder $query,
        SortClause $sortClause,
        int $number,
        array $languageSettings
    ): void {
        $query->innerJoin(
            'c', ContentTypeGateway::CONTENT_TYPE_TABLE, 'cc', 'c.contentclass_id = cc.id'
        );
    }
}
