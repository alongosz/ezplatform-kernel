<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace eZ\Publish\API\Repository\Values\Content\Trash;

use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\SPI\Repository\Values\Trash\Criterion as TrashCriterion;

/**
 * Query for {@see \eZ\Publish\API\Repository\TrashService::findTrashItems}.
 */
final class TrashQuery extends Query
{
    public function __construct(TrashCriterion $trashFilter, array $trashSortClauses = [])
    {
        parent::__construct(
            ['trashFilter' => $trashFilter, 'trashSortClauses' => $trashSortClauses]
        );
    }

    /** @var \eZ\Publish\SPI\Repository\Values\Trash\Criterion */
    public $trashFilter;

    /** @var \eZ\Publish\SPI\Repository\Values\Trash\SortClause[] */
    public $trashSortClauses = [];

    /**
     * @return \eZ\Publish\SPI\Repository\Values\Trash\Criterion
     */
    public function getTrashFilter(): TrashCriterion
    {
        return $this->trashFilter;
    }

    /**
     * @return \eZ\Publish\SPI\Repository\Values\Trash\SortClause[]
     */
    public function getTrashSortClauses(): iterable
    {
        return $this->trashSortClauses;
    }
}
