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

use function Sauls\Component\Helper\base64_url_decode;
use function Sauls\Component\Helper\base64_url_encode;
use function Sauls\Component\Helper\count_sentences;
use function Sauls\Component\Helper\count_words;
use function Sauls\Component\Helper\countdown;
use function Sauls\Component\Helper\elapsed_time;
use function Sauls\Component\Helper\explode_using_multi_delimiters;
use function Sauls\Component\Helper\string_camelize;
use function Sauls\Component\Helper\string_snakeify;
use function Sauls\Component\Helper\truncate;
use function Sauls\Component\Helper\truncate_html;
use function Sauls\Component\Helper\truncate_html_sentences;
use function Sauls\Component\Helper\truncate_html_worlds;
use function Sauls\Component\Helper\truncate_sentences;
use function Sauls\Component\Helper\truncate_words;
use Twig\Extension\AbstractExtension;

class HelpersTwigExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('elapsed_time', [$this, 'elapsedTime']),
            new \Twig_SimpleFilter('countdown', [$this, 'countdown']),
            new \Twig_SimpleFilter('camelize', [$this, 'camelize']),
            new \Twig_SimpleFilter('snakeify', [$this, 'snakeify']),
            new \Twig_SimpleFilter('multi_split', [$this, 'multiSplit']),
            new \Twig_SimpleFilter('base64_url_encode', [$this, 'base64UrlEncode']),
            new \Twig_SimpleFilter('base64_url_decode', [$this, 'base64UrlDecode']),
            new \Twig_SimpleFilter('count_words', [$this, 'countWords']),
            new \Twig_SimpleFilter('count_sentences', [$this, 'countSentences']),
            new \Twig_SimpleFilter('truncate', [$this, 'truncate']),
            new \Twig_SimpleFilter('truncate_words', [$this, 'truncateWords']),
            new \Twig_SimpleFilter('truncate_sentences', [$this, 'truncateSentences']),
            new \Twig_SimpleFilter('truncate_html', [$this, 'truncateHtml']),
            new \Twig_SimpleFilter('truncate_html_words', [$this, 'truncateHtmlWords']),
            new \Twig_SimpleFilter('truncate_html_sentences', [$this, 'truncateHtmlSentences']),
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

    /**
     * @throws \Exception
     */
    public function camelize(string $value): string
    {
        return string_camelize($value);
    }

    /**
     * @throws \Exception
     */
    public function snakeify(string $value): string
    {
        return string_snakeify($value);
    }

    /**
     * @throws \Exception
     */
    public function multiSplit(string $value, array $delimiters = ['.']): array
    {
        return explode_using_multi_delimiters($delimiters, $value);
    }

    /**
     * @throws \Exception
     */
    public function base64UrlEncode(string $value): string
    {
        return base64_url_encode($value);
    }

    /**
     * @throws \Exception
     */
    public function base64UrlDecode(string $value): string
    {
        return base64_url_decode($value);
    }

    public function countWords(string $value): string
    {
        return count_words($value);
    }

    public function countSentences(string $value): string
    {
        return count_sentences($value);
    }

    public function truncate(string $value, int $length, string $suffix = '...'): string
    {
        return truncate($value, $length, $suffix);
    }

    public function truncateWords(string $value, int $count, string $suffix = '...'): string
    {
        return truncate_words($value, $count, $suffix);
    }

    public function truncateSentences(string $value, int $length, string $suffix = '...'): string
    {
        return truncate_sentences($value, $length, $suffix);
    }

    public function truncateHtml(string $value, int $length, string $suffix = '...'): string
    {
        return truncate_html($value, $length, $suffix);
    }

    public function truncateHtmlWords(string $value, int $count, string $suffix = '...'): string
    {
        return truncate_html_worlds($value, $count, $suffix);
    }

    public function truncateHtmlSentences(string $value, int $count, string $suffix = '...'): string
    {
        return truncate_html_sentences($value, $count, $suffix);
    }
}
