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

use Sauls\Component\Widget\View\ViewInterface;
use Sauls\Component\Widget\WidgetInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

use function Sauls\Component\Helper\array_get_value;

class SaulsComponentsExtension extends Extension
{
    /**
     * @throws \Exception
     * @throws \Sauls\Component\Helper\Exception\PropertyNotAccessibleException
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader($container, new FileLocator(\dirname(__DIR__) . '/Resources/config'));

        $this->loadHelpersConfiguration($config, $container, $loader);
        $this->loadWidgetsConfiguration($config, $container, $loader);
        $this->loadComponentsConfiguration($config, $container, $loader);
        $this->loadBuiltInWidgets($config, $container, $loader);
    }

    /**
     * @throws \Exception
     * @throws \Sauls\Component\Helper\Exception\PropertyNotAccessibleException
     */
    private function loadHelpersConfiguration(array $configs, ContainerBuilder $container, LoaderInterface $loader)
    {
        if ($this->componentIsNotEnabled('helpers', $configs)) {
            return;
        }

        $loader->load('helpers.yaml');
    }

    /**
     * @throws \Exception
     * @throws \Sauls\Component\Helper\Exception\PropertyNotAccessibleException
     */
    private function componentIsNotEnabled(string $componentName, array $configs): bool
    {
        return false === array_get_value($configs, $componentName, false);
    }

    /**
     * @throws \Exception
     * @throws \Sauls\Component\Helper\Exception\PropertyNotAccessibleException
     */
    private function loadWidgetsConfiguration(array $configs, ContainerBuilder $container, LoaderInterface $loader)
    {
        if ($this->componentIsNotEnabled('widgets', $configs)) {
            return;
        }

        $loader->load('widgets.yaml');

        $container
            ->registerForAutoconfiguration(WidgetInterface::class)
            ->addTag('sauls_widget.widget')
            ->setPublic(true);

        $container
            ->registerForAutoconfiguration(ViewInterface::class)
            ->addTag('sauls_widget.view')
            ->setPublic(true);
    }

    private function loadComponentsConfiguration(array $configs, ContainerBuilder $container, LoaderInterface $loader)
    {
        $this->loadSecurityAccessComponent($configs, $container, $loader);
    }

    private function loadSecurityAccessComponent(array $configs, ContainerBuilder $container, LoaderInterface $loader)
    {
        if ($this->componentIsNotEnabled('components.access', $configs)) {
            return;
        }

        $loader->load('component/security/access.yaml');

        $container->setParameter(
            'sauls_components.component.access.options',
            array_get_value($configs, 'components.access')
        );
    }

    private function loadBuiltInWidgets(array $config, ContainerBuilder $container, YamlFileLoader $loader)
    {
        if ($container->has('cache.app')) {
            $loader->load('builtin_widgets.yaml');
        }
    }
}
