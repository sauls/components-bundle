<?php

declare(strict_types=1);

namespace Sauls\Bundle\Components\DependencyInjection\Compiler;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sauls\Component\Widget\Factory\WidgetFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class RegisterWidgetsPassTest extends TestCase
{
    /**
     * @var ContainerBuilder
     */
    private MockObject $container;

    /**
     * @test
     */
    public function should_return_nothing(): void
    {
        $compilerPass = $this->createCompilerPass();

        $this->container
            ->method('findDefinition')
            ->withConsecutive(['cache.app'], [WidgetFactory::class])
            ->willReturn(null);

        $this->assertNull($compilerPass->process($this->container));
    }

    private function createCompilerPass(): RegisterWidgetsPass
    {
        return new RegisterWidgetsPass();
    }

    protected function setUp(): void
    {
        $this->container = $this->createMock(ContainerBuilder::class);
    }
}
