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

interface AccessProtectorInterface
{
    /**
     * @param string $route
     *
     * @return bool
     * @internal param string $value
     *
     */
    public function isRouteAccessProtected(string $route): bool;

    /**
     * @param string $ip
     *
     * @return bool
     */
    public function isIpAccessAllowed(string $ip): bool;
}
