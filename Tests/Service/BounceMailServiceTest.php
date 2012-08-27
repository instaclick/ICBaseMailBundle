<?php
/**
 * @copyright 2012 Instaclick Inc.
 */

namespace IC\Bundle\Base\MailBundle\Tests\Service;

use BounceMailHandler\BounceMailHandler;

use IC\Bundle\Base\MailBundle\Service\BounceMailService;

/**
 * Test for BounceMailService
 *
 * @group Service
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author Anthon Pang <anthon.pang@gmail.com>
 */
class BounceMailServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException InvalidArgumentException
     * @dataProvider provideDataForInvalidSetLocalMailboxPath
     */
    public function testInvalidSetLocalMailboxPath($path)
    {
        $bounceMailService = new BounceMailService();

        $bounceMailService->setLocalMailboxPath($path);
    }

    public function provideDataForInvalidSetLocalMailboxPath()
    {
        $filePath = tempnam(sys_get_temp_dir(), 'test_');

        return array(
            array('/tmp/' . uniqid()), // Unexistent file
            array($filePath), // Not under HOME directory
        );
    }

    public function testNullableSetLocalMailboxPath()
    {
        $bounceMailService = new BounceMailService();
        $return            = $bounceMailService->setLocalMailboxPath(null);

        $this->assertNull($return);
    }

    public function testExecute()
    {
        $bounceMailService = new BounceMailService();
        $bounceMailHandler = new BounceMailHandler();

        $bounceMailService->setDebug(true);
        $bounceMailService->setBounceMailHandler($bounceMailHandler);
        $bounceMailService->setLocalMailboxPath(__DIR__.'/../DataFixtures/inbox.eml');

        ob_start();

        $bounceMailService->execute(
            function ($msgnum, $bounceType, $email, $subject, $xheader, $remove, $ruleNo, $ruleCat, $totalFetched, $body)
            {
                return $remove === true || $remove === 1;
            }
        );

        $output = ob_get_clean();

        $this->assertContains('Read: 2 messages', $output);
        $this->assertContains('2 action taken', $output);
        $this->assertContains('0 no action taken', $output);
        $this->assertContains('2 messages deleted', $output);
        $this->assertContains('0 messages moved', $output);
    }
}
