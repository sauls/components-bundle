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

namespace Sauls\Bundle\Components\Component\Security\Access\Granter\String;

use Sauls\Bundle\Components\Component\Security\Access\Granter\BaseArrayGranter;

class StringGranter extends BaseArrayGranter implements StringGranterInterface
{
    /**
     * @param string $value
     * @param array  $values
     *
     * @return bool
     */
    public function isGranted(string $value, array $values = []): bool
    {
        $this->values = $this->mergeValues($values);

        foreach ($this->values as $part) {
            if (false !== stripos($part, $value)) {
                return true;
            }
        }

        return false;
    }
}
