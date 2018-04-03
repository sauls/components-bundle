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

namespace Sauls\Bundle\Components\Component\Security\Access\Granter\Ip;

trait IpGranterTestCaseTrait
{
    public function createIpGranter(array $values = []): IpGranterInterface
    {
        return new IpGranter($values);
    }
}
