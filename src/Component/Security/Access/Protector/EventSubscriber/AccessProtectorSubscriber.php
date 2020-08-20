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
    /**
     * @var AccessProtectorInterface
     */
    private $accessProtector;

    /**
     * AccessProtectorSubscriber constructor.
     *
     * @param AccessProtectorInterface $accessProtector
     */
    public function __construct(AccessProtectorInterface $accessProtector)
    {
        $this->accessProtector = $accessProtector;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2')))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
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

        $route = $request->get('_route');
        $ip = $request->getClientIp();

        if ($this->isAccessProtected($route, $ip)) {
            throw new HttpException(Response::HTTP_NOT_FOUND, 'Not found');
        }
    }

    /**
     * @param string $route
     * @param string $ip
     *
     * @return bool
     */
    protected function isAccessProtected(string $route, string $ip): bool
    {
        return $this->accessProtector->isRouteAccessProtected($route)
            && !$this->accessProtector->isIpAccessAllowed($ip);
    }
}
