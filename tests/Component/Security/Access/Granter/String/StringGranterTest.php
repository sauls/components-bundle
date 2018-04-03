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

namespace Sauls\Bundle\Components\Component\Security\Access\Granter\String;

use function Sauls\Component\Helper\array_merge;

class StringGranterTest extends StringGranterTestCase
{
    /**
     * @test
     * @dataProvider getStringGranterData
     */
    public function should_grant_with_given_values(bool $expected, string $value, array $values): void
    {
        $stringGranter = $this->createStringGranter($values);

        $this->assertSame($expected, $stringGranter->isGranted($value));
    }

    public function getStringGranterData(): array
    {
        return [
            [true, 'secret_', $this->getDefaultValues()],
            [true, 'top_secret', $this->getDefaultValues(['top_secret_string'])],
            [false, 'allow_me', $this->getDefaultValues()],
        ];
    }

    private function getDefaultValues(array $values = []): array
    {
        return array_merge(
            [
                'test_',
                'secret_'
            ],
            $values
        );
    }
}
