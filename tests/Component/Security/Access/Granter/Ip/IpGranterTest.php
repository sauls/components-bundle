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

class IpGranterTest extends IpGranterTestCase
{
    /**
     * @test
     * @dataProvider getIpGranterData
     */
    public function should_grant_with_given_values(bool $expected, string $value, array $values): void
    {
        $ipGranter = $this->createIpGranter($values);
        $this->assertSame($expected, $ipGranter->isGranted($value));
    }

    public function getIpGranterData(): array
    {
        return [
            [true, '127.0.0.1', $this->getDefaultValues()],
            [true, '127.0.1.5', $this->getDefaultValues()],
            [true, '::1', $this->getDefaultValues()],
            [false, '192.168.0.1', $this->getDefaultValues()],
        ];
    }

    private function getDefaultValues(): array
    {
        return [
            '127.0.0.1',
            '::1',
            '127.0.1.1/8'
        ];
    }
}
