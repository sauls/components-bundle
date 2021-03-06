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

use Closure;
use Sauls\Bundle\Components\SaulsComponentsBundle;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Twig\Environment;
use Twig\Loader\LoaderInterface;

trait ContainerTestCaseTrait
{
    /**
     * @throws \Symfony\Component\DependencyInjection\Exception\BadMethodCallException
     * @throws \InvalidArgumentException
     * @throws \Exception
     * @throws \Sauls\Component\Helper\Exception\PropertyNotAccessibleException
     */
    public function createContainerBuilder(array $configs = [], Closure $callable = null): ContainerBuilder
    {
        $containerBuilder = new ContainerBuilder;

        $containerBuilder->set('twig', $this->createTwigEnvironmentMock());
        $containerBuilder->register('cache.app', ArrayAdapter::class)->setPublic(true);

        if ($callable) {
            $callable($containerBuilder);
        }
        
        $componentsExtension = new SaulsComponentsExtension();

        $componentsExtension->load($configs, $containerBuilder);

        $bundle = new SaulsComponentsBundle();
        $bundle->build($containerBuilder);
;
        return $containerBuilder;
    }

    public function createTwigEnvironmentMock(): Environment
    {
        return new Environment(
            $this->getMockBuilder(LoaderInterface::class)->getMock()
        );
    }
}
