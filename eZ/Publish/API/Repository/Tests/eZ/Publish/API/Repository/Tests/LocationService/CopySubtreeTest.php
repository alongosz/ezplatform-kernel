<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace eZ\Publish\API\Repository\Tests\LocationService;

use eZ\Publish\API\Repository\Tests\BaseTest;

final class CopySubtreeTest extends BaseTest
{
    /** @var \eZ\Publish\API\Repository\LocationService */
    private $locationService;

    protected function setUp(): void
    {
        $repository = $this->getRepository();
        $this->locationService = $repository->getLocationService();
    }

    /**
     * @covers \eZ\Publish\API\Repository\LocationService::copySubtree
     *
     * @throws \eZ\Publish\API\Repository\Exceptions\ForbiddenException
     * @throws \eZ\Publish\API\Repository\Exceptions\NotFoundException
     * @throws \eZ\Publish\API\Repository\Exceptions\UnauthorizedException
     */
    public function testCopySubtreeToOwnParent(): void
    {
        $folder = $this->createFolder(['eng-GB' => __FUNCTION__], 2);
        $targetParentLocation = $this->locationService->loadLocation(43);

        $secondaryLocation = $this->locationService->createLocation(
            $folder->contentInfo,
            $this->locationService->newLocationCreateStruct($targetParentLocation->id)
        );

        $this->locationService->copySubtree($secondaryLocation, $targetParentLocation);
    }
}
