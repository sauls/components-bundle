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

namespace Sauls\Bundle\Components\Component\Security\Access\Protector;

use Exception;
use Sauls\Component\Helper\Exception\PropertyNotAccessibleException;
use Symfony\Component\OptionsResolver\Exception\AccessException;
use Symfony\Component\OptionsResolver\Exception\UndefinedOptionsException;
use function Sauls\Component\Helper\array_get_value;
use Sauls\Bundle\Components\Component\Security\Access\Granter\Ip\IpGranterInterface;
use Sauls\Bundle\Components\Component\Security\Access\Granter\String\StringGranterInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccessProtector implements AccessProtectorInterface
{
    /**
     * @var array
     */
    private $options;
    /**
     * @var StringGranterInterface
     */
    private $stringGranter;
    /**
     * @var IpGranterInterface
     */
    private $ipGranter;

    /**
     * RouteProtector constructor.
     *
     * @param array $options
     * @param StringGranterInterface $stringGranter
     * @param IpGranterInterface $ipGranter
     */
    public function __construct(
        array $options = [],
        StringGranterInterface $stringGranter,
        IpGranterInterface $ipGranter
    ) {
        $resolver = new OptionsResolver;
        $this->configureDefaults($resolver);

        $this->options = $resolver->resolve($options);
        $this->stringGranter = $stringGranter;
        $this->ipGranter = $ipGranter;
    }

    /**
     * @param OptionsResolver $resolver
     *
     * @throws UndefinedOptionsException
     * @throws AccessException
     */
    protected function configureDefaults(OptionsResolver $resolver): void
    {
        $resolver->setRequired(
            [
                'protected_routes',
                'allowed_ips',
            ]
        );

        $resolver->setAllowedTypes('protected_routes', ['null', 'array']);
        $resolver->setAllowedTypes('allowed_ips', ['null', 'array']);
    }

    /**
     * @param string $route
     *
     * @return bool
     * @throws Exception
     * @throws PropertyNotAccessibleException
     * @internal param string $value
     */
    public function isRouteAccessProtected(string $route): bool
    {
        $routes = array_get_value($this->options, 'protected_routes');

        if (!$routes) {
            return true;
        }

        return $this->stringGranter->isGranted($route, $routes);
    }

    /**
     * @param string $ip
     *
     * @return bool
     * @throws Exception
     * @throws PropertyNotAccessibleException
     */
    public function isIpAccessAllowed(string $ip): bool
    {
        $ips = array_get_value($this->options, 'allowed_ips');

        if (!$ips) {
            return true;
        }

        return $this->ipGranter->isGranted($ip, $ips);
    }
}
