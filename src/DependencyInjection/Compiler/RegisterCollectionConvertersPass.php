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

namespace Sauls\Bundle\Components\DependencyInjection\Compiler;

use Exception;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use function array_keys;
use function array_map;
use function Sauls\Component\Helper\register_converters;

class RegisterCollectionConvertersPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     *
     * @throws Exception
     */
    public function process(ContainerBuilder $container)
    {
        $taggedServices = $container->findTaggedServiceIds('sauls_collection.converter');

        if (empty($taggedServices)) {
            return;
        }

        register_converters(
            array_map(
                function ($converterId) use ($container) {
                    return $container->get($converterId);
                },
                array_keys($taggedServices)
            )
        );
    }
}
