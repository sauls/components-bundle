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

namespace Sauls\Bundle\Components\Component\Security\Access\Granter;

interface GranterInterface
{
    /**
     * @param string $value
     * @param array  $values
     *
     * @return bool
     */
    public function isGranted(string $value, array $values = []): bool;
}
