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

use Sauls\Bundle\Components\DependencyInjection\Compiler\RegisterCollectionConvertersPass;
use Sauls\Bundle\Components\Stubs\Widget\TestWidget;
use function Sauls\Component\Helper\convert_to;
use Sauls\Component\Widget\Collection\ViewCollection;
use Sauls\Component\Widget\Collection\WidgetCollection;
use Sauls\Component\Widget\Factory\WidgetFactory;
use Sauls\Component\Widget\Integration\Twig\TwigExtension;
use Sauls\Component\Widget\Stubs\DummyWidget;
use Sauls\Component\Widget\View\StringView;
use Sauls\Component\Widget\View\TwigView;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class SaulsComponentsExtensionTest extends ContainerTestCase
{
    /**
     * @test
     */
    public function should_load_all_components()
    {
        $container = $this->createContainerBuilder(['helpers' => true, 'widgets' => true, 'collections' => true]);

        $twigTaggedServices = $container->findTaggedServiceIds('twig.extension');
        $this->assertArrayHasKey(SaulsComponentsExtension::class, $twigTaggedServices);
        $this->assertTrue($container->has(WidgetFactory::class));
    }

    /**
     * @test
     */
    public function should_not_load_helpers(): void
    {
        $container = $this->createContainerBuilder([]);

        $twigTaggedServices = $container->findTaggedServiceIds('twig.extension');

        $this->assertArrayNotHasKey(SaulsComponentsExtension::class, $twigTaggedServices);
        $this->assertFalse($container->has(WidgetFactory::class));
    }

    /**
     * @expectedException \Sauls\Component\Helper\Exception\InvalidTypeConverterException
     * @expectedExceptionMessage Invalid converter type `string`.
     * @test
     */
    public function should_not_register_any_custom_collection_converters(): void
    {
        $container = $this->createContainerBuilder(['helpers' => true, 'widgets' => true, 'collections' => true]);

        $container->compile();

        $this->assertSame('1', convert_to(1, 'string'));
    }

    /**
     * @test
     */
    public function should_register_custom_collection_converters(): void
    {
        $container = $this->createContainerBuilder(['helpers' => true, 'widgets' => true, 'collections' => true]);
        $loader = new YamlFileLoader($container, new FileLocator(\dirname(__DIR__).'/Stubs/Resources/config'));
        $loader->load('test_services.yaml');

        $container->addCompilerPass(new RegisterCollectionConvertersPass());

        $container->compile();


        $this->assertSame('1', convert_to(1, 'string'));
    }
}
