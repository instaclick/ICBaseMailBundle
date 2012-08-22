<?php
/**
 * @copyright 2012 Instaclick Inc.
 */

namespace IC\Bundle\Base\MailBundle\Tests\Service;

use IC\Bundle\Base\MailBundle\Service\ComposerService;

/**
 * Test for ComposerService
 *
 * @group Service
 *
 * @author Guilherme Blanco <gblanco@nationalfibre.net>
 * @author Juti Noppornpitak <jutin@nationalfibre.net>
 */
class ComposerServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test for ComposerService
     */
    public function testCreateMessage()
    {
        $defaultSenderName    = 'John Smith';
        $defaultSenderAddress = 'jsmith@nationalfibre.net';

        // Required mocking
        $composerService = new ComposerService();

        $composerService->setDefaultSenderName($defaultSenderName);
        $composerService->setDefaultSenderAddress($defaultSenderAddress);

        // Testing
        $message = $composerService->createMessage();

        $this->assertInstanceOf('IC\Bundle\Base\MailBundle\Entity\Message', $message);

        $this->assertEquals($defaultSenderName, $message->getSenderName());
        $this->assertEquals($defaultSenderAddress, $message->getSenderAddress());

        $this->assertFalse($message->isUsable());
    }
}
