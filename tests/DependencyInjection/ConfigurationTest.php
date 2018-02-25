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

use PHPUnit\Framework\TestCase;

class ConfigurationTest extends TestCase
{
    /**
     * @test
     */
    public function should_return_configuration_root(): void
    {
        $configuration = new Configuration;
        $treeBuilder = $configuration->getConfigTreeBuilder();

        $this->assertSame('sauls_components', $treeBuilder->buildTree()->getName());
    }
}
