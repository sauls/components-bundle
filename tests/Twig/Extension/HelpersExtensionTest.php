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

use DateTime;
use PHPUnit\Framework\TestCase;
use Twig\Environment;
use Twig\Loader\LoaderInterface;

use function html_entity_decode;

class HelpersExtensionTest extends TestCase
{
    protected $twigEnvironment;

    /**
     * @test
     */
    public function should_return_elapsed_time(): void
    {
        $testDate = (new DateTime())->modify('-1 month -2 days -48 seconds');

        $template = $this->twigEnvironment->createTemplate('{{testDate|elapsed_time}}');

        $this->assertStringContainsString('1mo', $template->render(['testDate' => $testDate]));
    }

    /**
     * @test
     */
    public function should_return_countdown_to_till_date(): void
    {
        $testDateFrom = (new DateTime());
        $testDateTo = (new DateTime())->modify('+ 3 days -1 day -38 minutes -78 seconds');

        $template = $this->twigEnvironment->createTemplate('{{dateFrom|countdown(dateTo)}}');
        $this->assertStringContainsString(
            '47:20:4',
            $template->render(
                [
                    'dateFrom' => $testDateFrom,
                    'dateTo' => $testDateTo,
                ]
            )
        );
    }

    /**
     * @test
     */
    public function should_camelize_string(): void
    {
        $template = $this->twigEnvironment->createTemplate("{{ 'super_duper_string'|camelize }}");

        $this->assertSame('SuperDuperString', $template->render([]));
    }

    /**
     * @test
     */
    public function should_snakeify_string(): void
    {
        $template = $this->twigEnvironment->createTemplate("{{ 'SuperDuperString'|snakeify }}");

        $this->assertSame('super_duper_string', $template->render([]));
    }

    /**
     * @test
     */
    public function should_explode_string_using_multiple_delimiters(): void
    {
        $template = $this->twigEnvironment->createTemplate(
            "{% set ms = 'super,duper#string'|multi_split([',', '#']) %}{{ ms|join('-') }}"
        );

        $this->assertSame('super-duper-string', $template->render([]));
    }

    /**
     * @test
     */
    public function should_base64_encode_string(): void
    {
        $template = $this->twigEnvironment->createTemplate("{{'test&nottest=2'|base64_url_encode}}");

        $this->assertSame('dGVzdCZub3R0ZXN0PTI=', $template->render([]));
    }

    /**
     * @test
     */
    public function should_base64_decode_string(): void
    {
        $template = $this->twigEnvironment->createTemplate("{{'dGVzdCZub3R0ZXN0PTI='|base64_url_decode}}");

        $this->assertSame('test&amp;nottest=2', $template->render([]));
    }

    /**
     * @test
     */
    public function should_count_words(): void
    {
        $template = $this->twigEnvironment->createTemplate("{{ 'one two three'|count_words }}");

        $this->assertSame('3', $template->render([]));
    }

    /**
     * @test
     */
    public function should_count_sentences(): void
    {
        $template = $this->twigEnvironment->createTemplate("{{ 'Helllo. World. Is it? Or not?'|count_sentences }}");

        $this->assertSame('4', $template->render([]));
    }

    /**
     * @test
     */
    public function should_truncate(): void
    {
        $template = $this->twigEnvironment->createTemplate("{{ 'Hello world!'|truncate(5) }}");

        $this->assertSame('Hello...', $template->render([]));
    }

    /**
     * @test
     */
    public function should_truncate_words(): void
    {
        $template = $this->twigEnvironment->createTemplate("{{ 'Hello magical world!'|truncate_words(2) }}");

        $this->assertSame('Hello magical...', $template->render([]));
    }

    /**
     * @test
     */
    public function should_truncate_sentences(): void
    {
        $template = $this->twigEnvironment->createTemplate(
            "{{ 'Hello. World. Are you real?'|truncate_sentences(2, '..') }}"
        );

        $this->assertSame('Hello. World...', $template->render([]));
    }

    /**
     * @test
     */
    public function should_truncate_html(): void
    {
        $template = $this->twigEnvironment->createTemplate("{{ '<p>Hello world!</p>'|truncate_html(5, '') }}");

        $this->assertSame('<p>Hello</p>', html_entity_decode($template->render([])));
    }

    /**
     * @test
     */
    public function should_truncate_html_words(): void
    {
        $template = $this->twigEnvironment->createTemplate(
            "{{ '<p>Hello world of life.</p>'|truncate_html_words(2, '') }}"
        );

        $this->assertSame('<p>Hello world</p>', html_entity_decode($template->render([])));
    }

    /**
     * @test
     */
    public function should_truncate_html_sentences(): void
    {
        $template = $this->twigEnvironment->createTemplate(
            "{{ '<p><span>Hello world.</span> How is your life? is it good?</p>'|truncate_html_sentences(2, '') }}"
        );

        $this->assertSame(
            '<p><span>Hello world.</span>How is your life?</p>',
            html_entity_decode($template->render([]))
        );
    }

    protected function setUp(): void
    {
        $this->twigEnvironment = new Environment(
            $this->getMockBuilder(LoaderInterface::class)->getMock()
        );
        $this->twigEnvironment->addExtension(new HelpersTwigExtension);
    }
}
