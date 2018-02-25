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

namespace Sauls\Bundle\Components;

use PHPUnit\Framework\TestCase;
use Sauls\Bundle\Components\DependencyInjection\Compiler\RegisterCollectionConvertersPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SaulsComponentsBundleTest extends TestCase
{
    /**
     * @test
     */
    public function should_register_compiler_pass(): void
    {
        $containerBuilder = $this
            ->getMockBuilder(ContainerBuilder::class)
            ->disableOriginalConstructor()
            ->setMethods(['addCompilerPass'])
            ->getMock();

        $containerBuilder
            ->expects($this->once())
            ->method('addCompilerPass')
            ->with($this->equalTo(new RegisterCollectionConvertersPass()))
            ->willReturn($containerBuilder);

        $saulsWidgetBundle = new SaulsComponentsBundle();
        $saulsWidgetBundle->build($containerBuilder);
    }
}
