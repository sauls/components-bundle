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

namespace Sauls\Bundle\Components\Stubs\Widget;

use Sauls\Component\OptionsResolver\OptionsResolver;
use Sauls\Component\Widget\ViewWidget;

class TestWidget extends ViewWidget
{
    /**
     * @throws \Exception
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'viewFile' => 'Hello {name}',
            'viewData' => [
                'name' => 'world',
            ],
        ]);
    }
}
