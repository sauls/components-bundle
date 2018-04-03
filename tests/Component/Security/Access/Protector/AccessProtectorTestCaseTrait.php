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

namespace Sauls\Bundle\Components\Component\Security\Access\Protector;

use Sauls\Bundle\Components\Component\Security\Access\Granter\Ip\IpGranterTestCaseTrait;
use Sauls\Bundle\Components\Component\Security\Access\Granter\String\StringGranterTestCaseTrait;

trait AccessProtectorTestCaseTrait
{
    use StringGranterTestCaseTrait, IpGranterTestCaseTrait;

    public function createAccessProtector(
        array $options = [],
        array $stringGranterOptions = [],
        array $ipGranterOptions = []
    ): AccessProtectorInterface {
        return new AccessProtector(
            $options,
            $this->createStringGranter($stringGranterOptions),
            $this->createIpGranter($ipGranterOptions)
        );
    }

    public function getDefaultAccessProtectorOptions(array $options = []): array
    {
        return array_merge(
            [
                'protected_routes' => [
                    'test_',
                    'secret_',
                ],
                'allowed_ips' => [
                    '127.0.0.1',
                    '::1',
                    '127.0.1.1/8',
                ],
            ],
            $options
        );
    }
}
