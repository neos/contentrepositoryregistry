<?php
declare(strict_types=1);
namespace Neos\ContentRepositoryRegistry\Factory\ProjectionCatchUpTrigger;

use Neos\ContentRepository\Core\Projection\ProjectionCatchUpTriggerInterface;
use Neos\ContentRepositoryRegistry\Command\SubprocessProjectionCatchUpCommandController;
use Neos\ContentRepository\Core\Factory\ContentRepositoryIdentifier;

/**
 * See {@see SubprocessProjectionCatchUpCommandController} for the inner part
 */
class SubprocessProjectionCatchUpTriggerFactory implements ProjectionCatchUpTriggerFactoryInterface
{
    public function build(ContentRepositoryIdentifier $contentRepositoryIdentifier, array $contentRepositorySettings, array $projectionCatchUpTriggerPreset): ProjectionCatchUpTriggerInterface
    {
        return new CatchUpTriggerWithSynchronousOption(
            $contentRepositoryIdentifier,
            new SubprocessProjectionCatchUpTrigger($contentRepositoryIdentifier)
        );
    }
}
