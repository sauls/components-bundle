<?php

declare(strict_types=1);

namespace Sauls\Bundle\Components\DependencyInjection\Compiler;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class RegisterCollectionConvertersPassTest extends TestCase
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
            ->method('findTaggedServiceIds')
            ->with('sauls_collection.converter')
            ->willReturn(null);

        $this->assertNull($compilerPass->process($this->container));
    }

    private function createCompilerPass(): RegisterCollectionConvertersPass
    {
        return new RegisterCollectionConvertersPass();
    }

    protected function setUp(): void
    {
        $this->container = $this->createMock(ContainerBuilder::class);
    }
}
