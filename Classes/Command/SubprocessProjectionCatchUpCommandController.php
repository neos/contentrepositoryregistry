<?php
declare(strict_types=1);

namespace Neos\ContentRepositoryRegistry\Command;

use Neos\ContentRepository\Core\Projection\CatchUpOptions;
use Neos\ContentRepository\Core\Projection\ProjectionInterface;
use Neos\ContentRepository\Core\Projection\ProjectionStateInterface;
use Neos\ContentRepository\Core\SharedModel\ContentRepository\ContentRepositoryId;
use Neos\ContentRepositoryRegistry\ContentRepositoryRegistry;
use Neos\ContentRepositoryRegistry\Factory\ProjectionCatchUpTrigger\SubprocessProjectionCatchUpTrigger;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Cli\CommandController;

/**
 * See {@see SubprocessProjectionCatchUpTrigger} for the side calling this class
 * @internal
 */
class SubprocessProjectionCatchUpCommandController extends CommandController
{
    /**
     * @Flow\Inject
     * @var ContentRepositoryRegistry
     */
    protected $contentRepositoryRegistry;

    /**
     * @param string $contentRepository Identifier of the content repository
     * @param class-string<ProjectionInterface<ProjectionStateInterface>> $projectionClassName fully qualified class name of the projection to catch up
     * @internal
     */
    public function catchupCommand(string $contentRepository, string $projectionClassName): void
    {
        $contentRepositoryInstance = $this->contentRepositoryRegistry->get(ContentRepositoryId::fromString($contentRepository));
        $contentRepositoryInstance->catchUpProjection($projectionClassName, CatchUpOptions::create());
    }
}
