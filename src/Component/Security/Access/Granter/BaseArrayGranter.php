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

use function Sauls\Component\Helper\array_merge;

abstract class BaseArrayGranter implements GranterInterface
{
    /**
     * @var array
     */
    protected $values;

    /**
     * AllowGranter constructor.
     *
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->values = $values;
    }

    /**
     * @param array $values
     *
     * @return array
     */
    protected function mergeValues(array $values = []): array
    {
        return array_merge($this->values, $values);
    }
}
