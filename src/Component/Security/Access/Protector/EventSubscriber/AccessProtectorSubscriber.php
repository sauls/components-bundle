<?php
/**
 * This file is part of the sauls/security package.
 *
 * @author    Saulius Vaičeliūnas <vaiceliunas@inbox.lt>
 * @link      http://saulius.vaiceliunas.lt
 * @copyright 2017
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sauls\Bundle\Components\Component\Security\Access\Protector\EventSubscriber;

use Sauls\Bundle\Components\Component\Security\Access\Protector\AccessProtectorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AccessProtectorSubscriber implements EventSubscriberInterface
{
    private AccessProtectorInterface $accessProtector;

    public function __construct(AccessProtectorInterface $accessProtector)
    {
        $this->accessProtector = $accessProtector;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            RequestEvent::class => [
                'onKernelRequest',
                0,
            ],
        ];
    }

    /**
     * @throws HttpException
     */
    public function onKernelRequest(RequestEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();

        $route = $request->get('_route', '');
        $ip = $request->getClientIp() ?? '';

        if ($this->isAccessProtected($route, $ip)) {
            throw new HttpException(Response::HTTP_NOT_FOUND, 'Not found');
        }
    }

    protected function isAccessProtected(string $route, string $ip): bool
    {
        return $this->accessProtector->isRouteAccessProtected($route)
            && !$this->accessProtector->isIpAccessAllowed($ip);
    }
}
