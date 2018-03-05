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

use PHPUnit\Framework\TestCase;

class HelpersExtensionTest extends TestCase
{
    protected $twigEnvironment;

    /**
     * @test
     */
    public function should_return_elapsed_time(): void
    {
        $testDate = (new \DateTime())->modify('-1 month -2 days -48 seconds');

        $template = $this->twigEnvironment->createTemplate('{{testDate|elapsed_time}}');

        $this->assertContains('1mo', $template->render(['testDate' => $testDate]));
    }

    /**
     * @test
     */
    public function should_return_countdown_to_till_date(): void
    {
        $testDateFrom = (new \DateTime());
        $testDateTo = (new \DateTime())->modify('+ 3 days -1 day -38 minutes -78 seconds');

        $template = $this->twigEnvironment->createTemplate('{{dateFrom|countdown(dateTo)}}');
        $this->assertContains(
            '47:20:4',
            $template->render(
                [
                    'dateFrom' => $testDateFrom,
                    'dateTo' => $testDateTo,
                ]));
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
        $template = $this->twigEnvironment->createTemplate("{% set ms = 'super,duper#string'|multi_split([',', '#']) %}{{ ms|join('-') }}");

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

    protected function setUp()
    {
        $this->twigEnvironment = new \Twig_Environment(
            $this->getMockBuilder(\Twig_LoaderInterface::class)->getMock()
        );
        $this->twigEnvironment->addExtension(new HelpersTwigExtension);
    }
}
