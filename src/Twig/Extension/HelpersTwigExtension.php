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

use Exception;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

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

class HelpersTwigExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('elapsed_time', [$this, 'elapsedTime']),
            new TwigFilter('countdown', [$this, 'countdown']),
            new TwigFilter('camelize', [$this, 'camelize']),
            new TwigFilter('snakeify', [$this, 'snakeify']),
            new TwigFilter('multi_split', [$this, 'multiSplit']),
            new TwigFilter('base64_url_encode', [$this, 'base64UrlEncode']),
            new TwigFilter('base64_url_decode', [$this, 'base64UrlDecode']),
            new TwigFilter('count_words', [$this, 'countWords']),
            new TwigFilter('count_sentences', [$this, 'countSentences']),
            new TwigFilter('truncate', [$this, 'truncate']),
            new TwigFilter('truncate_words', [$this, 'truncateWords']),
            new TwigFilter('truncate_sentences', [$this, 'truncateSentences']),
            new TwigFilter('truncate_html', [$this, 'truncateHtml']),
            new TwigFilter('truncate_html_words', [$this, 'truncateHtmlWords']),
            new TwigFilter('truncate_html_sentences', [$this, 'truncateHtmlSentences']),
        ];
    }

    /**
     * @throws Exception
     */
    public function elapsedTime($date, array $labels = [], $format = ELAPSED_TIME_FORMAT_FULL): string
    {
        return elapsed_time($date, $labels, $format);
    }

    /**
     * @throws Exception
     */
    public function countdown($dateFrom, $dateTo, string $format = '%s%02d:%02d:%02d'): string
    {
        return countdown($dateFrom ?? 'now', $dateTo, $format);
    }

    /**
     * @throws Exception
     */
    public function camelize(string $value): string
    {
        return string_camelize($value);
    }

    /**
     * @throws Exception
     */
    public function snakeify(string $value): string
    {
        return string_snakeify($value);
    }

    /**
     * @throws Exception
     */
    public function multiSplit(string $value, array $delimiters = ['.']): array
    {
        return explode_using_multi_delimiters($delimiters, $value);
    }

    /**
     * @throws Exception
     */
    public function base64UrlEncode(string $value): string
    {
        return base64_url_encode($value);
    }

    /**
     * @throws Exception
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
