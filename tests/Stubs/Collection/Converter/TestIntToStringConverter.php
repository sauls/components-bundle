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

namespace Sauls\Bundle\Components\Stubs\Collection\Converter;

use Sauls\Component\Helper\Operation\TypeOperation\Converter\ConverterInterface;

class TestIntToStringConverter implements ConverterInterface
{
    public function convert($value)
    {
        return (string) $value;
    }

    public function supports($value): bool
    {
        return \is_int($value);
    }

    public function getType(): string
    {
        return 'string';
    }

    public function getPriority(): int
    {
        return 256;
    }
}
