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

namespace Sauls\Bundle\Components\Component\Security\Access\Protector\EventSubscriber;

use PHPUnit\Framework\TestCase;
use Sauls\Bundle\Components\Component\Security\Access\Protector\AccessProtectorTestCaseTrait;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class AccessProtectorSubscriberTest extends TestCase
{
    use AccessProtectorTestCaseTrait;

    protected $eventDispatcher;
    protected $request;
    protected $kernel;

    /**
     * @test
     */
    public function should_handle_master_request(): void
    {
        $this->request->request->set('_route', 'test_');
        $this->request->method('getClientIp')->willReturn('127.0.0.1');

        $event = $this->createAndDispatchEvent(
            [
                'allowed_ips' => [
                    '127.0.0.1',
                ],
                'protected_routes' => [
                    'test_',
                ],
            ]
        );

        $this->assertFalse($event->hasResponse());
    }

    private function createAndDispatchEvent(
        array $options = [],
        int $requestType = HttpKernelInterface::MASTER_REQUEST
    ): RequestEvent {
        $this->eventDispatcher = new EventDispatcher();
        $this->eventDispatcher->addSubscriber(new AccessProtectorSubscriber($this->createAccessProtector($options)));

        return $this->eventDispatcher->dispatch(
            new RequestEvent($this->kernel, $this->request, $requestType)
        );
    }

    /**
     * @test
     */
    public function should_skip_sub_request(): void
    {
        $this->request->request->set('_route', 'test_');
        $this->request->method('getClientIp')->willReturn('127.0.0.1');

        $event = $this->createAndDispatchEvent(
            [
                'allowed_ips' => [
                    '127.0.0.1',
                ],
                'protected_routes' => [
                    'test_',
                ],
            ],
            HttpKernelInterface::SUB_REQUEST
        );

        $this->assertFalse($event->hasResponse());
    }

    /**
     * @test
     */
    public function should_throw_404_exception(): void
    {
        $this->expectException(HttpException::class);
        $this->expectExceptionMessage('Not found');

        $this->request->request->set('_route', 'test_');
        $this->request->method('getClientIp')->willReturn('129.0.0.1');

        $this->createAndDispatchEvent(
            [
                'allowed_ips' => [
                    '127.0.0.1',
                ],
                'protected_routes' => [
                    'test_',
                ],
            ]
        );
    }

    protected function setUp(): void
    {
        $this->kernel = $this->getMockBuilder(KernelInterface::class)->getMock();
        $this->request = $this->getMockBuilder(Request::class)->setConstructorArgs(
            [
                [],
                [],
                [],
            ]
        )->setMethods(['getClientIp'])->getMock();
    }
}
