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

use Sauls\Component\Widget\Integration\Twig\TwigExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

trait ContainerTestCaseTrait
{
    /**
     * @throws \InvalidArgumentException
     * @throws \Exception
     * @throws \Sauls\Component\Helper\Exception\PropertyNotAccessibleException
     */
    public function createContainerBuilder(array $configs = []): ContainerBuilder
    {
        $containerBuilder = new ContainerBuilder;

        $componentsExtension = new SaulsComponentsExtension;

        $componentsExtension->load($configs, $containerBuilder);

        return $containerBuilder;
    }
}
