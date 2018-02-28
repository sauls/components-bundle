<?php
/**
 * This file is part of the sauls/components-bundle package.
 *
 * @author    Saulius Vaičeliūnas <vaiceliunas@inbox.lt>
 * @link      http://saulius.vaiceliunas.lt
 * @copyright 2018
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sauls\Bundle\Components\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     * @throws \RuntimeException
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('sauls_components');

        $rootNode
            ->fixXmlConfig('helper')
            ->fixXmlConfig('widget')
            ->addDefaultsIfNotSet()
            ->children()
                ->booleanNode('helpers')->defaultTrue()->end()
                ->booleanNode('widgets')->defaultTrue()->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
