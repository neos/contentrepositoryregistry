<?php
namespace Neos\ContentRepositoryRegistry\NodeLabel;

/*
 * This file is part of the Neos.ContentRepository package.
 *
 * (c) Contributors of the Neos Project - www.neos.io
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */

use Neos\ContentRepository\Core\Projection\ContentGraph\Node;
use Neos\ContentRepository\Core\NodeType\NodeLabelGeneratorInterface;
use Neos\Eel\EelEvaluatorInterface;
use Neos\Eel\Utility;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\ObjectManagement\DependencyInjection\DependencyProxy;

/**
 * The expression based node label generator that is used as default if a label expression is configured.
 *
 */
class ExpressionBasedNodeLabelGenerator implements NodeLabelGeneratorInterface
{
    /**
     * @Flow\Inject
     * @var EelEvaluatorInterface
     */
    protected $eelEvaluator;

    /**
     * @Flow\InjectConfiguration(package="Neos.ContentRepository", path="labelGenerator.eel.defaultContext")
     * @var array
     */
    protected $defaultContextConfiguration;

    /**
     * @var string
     */
    protected $expression = '${(node.nodeType.label ? node.nodeType.label : node.nodeType.name) + \' (\' + node.name + \')\'}';

    /**
     * @return string
     */
    public function getExpression()
    {
        return $this->expression;
    }

    /**
     * @param string $expression
     */
    public function setExpression($expression)
    {
        $this->expression = $expression;
    }

    /**
     * @return void
     */
    public function initializeObject()
    {
        if ($this->eelEvaluator instanceof DependencyProxy) {
            $this->eelEvaluator->_activateDependency();
        }
    }

    /**
     * Render a node label based on an eel expression or return the expression if it is not valid eel.
     * @throws \Neos\Eel\Exception
     */
    public function getLabel(Node $node): string
    {
        if (Utility::parseEelExpression($this->getExpression()) === null) {
            return $this->getExpression();
        }
        return (string)Utility::evaluateEelExpression($this->getExpression(), $this->eelEvaluator, ['node' => $node], $this->defaultContextConfiguration);
    }
}
