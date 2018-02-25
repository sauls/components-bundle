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

namespace Sauls\Bundle\Components\Twig\Extension;

use function Sauls\Component\Helper\countdown;
use function Sauls\Component\Helper\elapsed_time;
use Twig\Extension\AbstractExtension;

class HelpersTwigExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('elapsed_time', [$this, 'elapsedTime']),
            new \Twig_SimpleFilter('countdown', [$this, 'countdown'])
        ];
    }

    /**
     * @throws \Exception
     */
    public function elapsedTime($date, array $labels = [], $format = ELAPSED_TIME_FORMAT_FULL): string
    {
        return elapsed_time($date, $labels, $format);
    }

    /**
     * @throws \Exception
     */
    public function countdown($dateFrom = 'now', $dateTo, string $format = '%s%02d:%02d:%02d'): string
    {
        return countdown($dateFrom, $dateTo, $format);
    }
}
