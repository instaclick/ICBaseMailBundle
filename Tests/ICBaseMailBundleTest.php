<?php
/**
 * @copyright 2012 Instaclick Inc.
 */

namespace IC\Bundle\Base\MailBundle\Tests;

use Symfony\Component\DependencyInjection\ContainerBuilder;

use IC\Bundle\Base\MailBundle\ICBaseMailBundle;

/**
 * Test for ICBaseMailBundle
 *
 * @group Bundle
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
class ICBaseMailBundleTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildCompilerPasses()
    {
        $container = new ContainerBuilder();
        $bundle    = new ICBaseMailBundle();

        $bundle->build($container);
    }
}