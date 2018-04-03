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

use Sauls\Bundle\Components\Component\Security\Access\Protector\AccessProtector;
use Sauls\Bundle\Components\Twig\Extension\HelpersTwigExtension;
use function Sauls\Component\Helper\convert_to;
use Sauls\Bundle\Components\DependencyInjection\Compiler\RegisterCollectionConvertersPass;
use Sauls\Component\Widget\Collection\WidgetCollection;
use Sauls\Component\Widget\Factory\WidgetFactory;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class SaulsComponentsExtensionTest extends ContainerTestCase
{
    /**
     * @test
     */
    public function should_load_all_components()
    {
        $container = $this->createContainerBuilder();

        $twigTaggedServices = $container->findTaggedServiceIds('twig.extension');
        $this->assertArrayHasKey(HelpersTwigExtension::class, $twigTaggedServices);

        $container->compile();

        $this->assertTrue($container->has(WidgetCollection::class));
        $this->assertTrue($container->has(WidgetFactory::class));
    }

    /**
     * @test
     */
    public function should_not_load_components(): void
    {
        $container = $this->createContainerBuilder([['helpers' => false, 'widgets' => false]]);

        $twigTaggedServices = $container->findTaggedServiceIds('twig.extension');

        $this->assertArrayNotHasKey(HelpersTwigExtension::class, $twigTaggedServices);
        $this->assertFalse($container->has(WidgetFactory::class));
    }

    /**
     * @test
     */
    public function should_not_find_collection_converters()
    {
        $container = new ContainerBuilder();
        $container->addCompilerPass(new RegisterCollectionConvertersPass());
        $container->compile();

        $this->assertEmpty($container->findTaggedServiceIds('sauls_collection.converter'));
    }

    /**
     * @expectedException \Sauls\Component\Helper\Exception\InvalidTypeConverterException
     * @expectedExceptionMessage Invalid converter type `string`.
     * @test
     */
    public function should_not_register_any_custom_collection_converters(): void
    {
        $container = $this->createContainerBuilder([['helpers' => true, 'widgets' => true,]]);

        $container->compile();

        $this->assertSame('1', convert_to(1, 'string'));
    }

    /**
     * @test
     */
    public function should_register_custom_collection_converters(): void
    {
        $container = $this->createContainerBuilder([['helpers' => true, 'widgets' => true,]]);
        $loader = new YamlFileLoader($container, new FileLocator(\dirname(__DIR__).'/Stubs/Resources/config'));
        $loader->load('test_services.yaml');

        $container->addCompilerPass(new RegisterCollectionConvertersPass());

        $container->compile();


        $this->assertSame('1', convert_to(1, 'string'));
    }

    /**
     * @test
     */
    public function should_register_access_protector(): void
    {
        $container = $this->createContainerBuilder([['components' => ['access' => ['allowed_ips' => ['127.0.0.1'], 'protected_routes' => ['test_']]]]]);
        $container->compile();

        $this->assertTrue($container->has(AccessProtector::class));
        $this->assertInternalType('array', $container->getParameter('sauls_components.component.access.options'));
    }
}
