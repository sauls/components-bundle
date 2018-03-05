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

use function Sauls\Component\Helper\array_get_value;
use Sauls\Component\Widget\View\ViewInterface;
use Sauls\Component\Widget\WidgetInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

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

        $loader = new YamlFileLoader($container, new FileLocator(\dirname(__DIR__).'/Resources/config'));

        $this->loadHelpersConfiguration($config, $container, $loader);
        $this->loadWidgetsConfiguration($config, $container, $loader);
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
            ->setPrivate(true);
    }

    /**
     * @throws \Exception
     * @throws \Sauls\Component\Helper\Exception\PropertyNotAccessibleException
     */
    private function componentIsNotEnabled(string $componentName, array $configs): bool
    {
        return false === array_get_value($configs, $componentName, false);
    }
}
