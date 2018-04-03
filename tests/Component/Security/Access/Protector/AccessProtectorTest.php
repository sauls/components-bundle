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

use function Sauls\Component\Helper\array_merge;
use PHPUnit\Framework\TestCase;
use Sauls\Bundle\Components\Component\Security\Access\Granter\Ip\IpGranter;
use Sauls\Bundle\Components\Component\Security\Access\Granter\String\StringGranter;

class AccessProtectorTest extends AccessProtectorTestCase
{
    /**
     * @test
     * @dataProvider getAccessProtectorRouteData
     */
    public function should_check_access_with_given_route(bool $expected, string $route, array $options = []): void
    {
        $accessProtector = $this->createAccessProtector($options);
        $this->assertSame($expected, $accessProtector->isRouteAccessProtected($route));
    }

    /**
     * @test
     * @dataProvider getAccessProtectorIpData
     */
    public function should_check_access_with_given_ip(bool $expected, string $ip, array $options = []): void
    {
        $accessProtector = $this->createAccessProtector($options);
        $this->assertSame($expected, $accessProtector->isIpAccessAllowed($ip));
    }

    public function getAccessProtectorRouteData(): array
    {
        return [
            [true, 'secret_', $this->getDefaultAccessProtectorOptions()],
            [false, 'no_path_', $this->getDefaultAccessProtectorOptions()],
        ];
    }

    public function getAccessProtectorIpData(): array
    {
        return [
            [true, '127.0.0.1', $this->getDefaultAccessProtectorOptions()],
            [false, '192.168.0.1', $this->getDefaultAccessProtectorOptions()],
        ];
    }

    /**
     * @test
     */
    public function should_pass_anything_without_options(): void
    {
        $accessProtector = new AccessProtector([
            'protected_routes' => [],
            'allowed_ips' => [],
        ], new StringGranter, new IpGranter);

        $this->assertTrue($accessProtector->isIpAccessAllowed('192.168.0.1'));
        $this->assertTrue($accessProtector->isRouteAccessProtected('i_shal_pass_'));
    }
}
