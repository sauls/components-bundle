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

        $this->assertContains('1mo 3d', $template->render(['testDate' => $testDate]));
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

    protected function setUp()
    {
        $this->twigEnvironment = new \Twig_Environment(
            $this->getMockBuilder(\Twig_LoaderInterface::class)->getMock()
        );
        $this->twigEnvironment->addExtension(new HelpersTwigExtension);
    }
}
