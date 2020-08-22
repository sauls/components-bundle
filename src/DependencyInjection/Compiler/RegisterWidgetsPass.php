<?php
/**
 * This file is part of the sauls/components-bundle package.
 *
 * @author    Saulius Vaičeliūnas <vaiceliunas@inbox.lt>
 * @link      http://saulius.vaiceliunas.lt
 * @copyright 2020
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Sauls\Bundle\Components\DependencyInjection\Compiler;

use Sauls\Component\Widget\Factory\WidgetFactory;
use Sauls\Component\Widget\Widgets\CacheableWidget;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class RegisterWidgetsPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $cacheDefinition = $container->findDefinition('cache.app');
        $widgetDefinition = $container->findDefinition(WidgetFactory::class);

        if (!$cacheDefinition && !$widgetDefinition) {
            return;
        }

        $container
            ->register(CacheableWidget::class, CacheableWidget::class)
            ->addArgument($cacheDefinition)
            ->addArgument($widgetDefinition)
            ->addTag('sauls_widget.widget')
            ->setPublic(true);
    }
}
