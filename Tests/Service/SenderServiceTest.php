<?php
/**
 * @copyright 2012 Instaclick Inc.
 */

namespace IC\Bundle\Base\MailBundle\Tests\Service;

use IC\Bundle\Base\MailBundle\Service\SenderService;
use IC\Bundle\Base\MailBundle\Service\ComposerService;

/**
 * Test for SenderService
 *
 * @group Service
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author Juti Noppornpitak <jnopporn@shiroyuki.com>
 */
class SenderServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test success send
     */
    public function testSend()
    {
        // Mailer mocking
        $mailer = $this->mockMailerService($this->returnValue(1));

        // Template mocking
        $templating = $this->mockTemplatingService();

        // Container mocking (required to allow entering on request scope)
        $container = $this->getMockBuilder('Symfony\Component\DependencyInjection\Container')
            ->disableOriginalConstructor()
            ->getMock();

        $container->expects($this->any())
                  ->method('get')
                  ->with('templating')
                  ->will($this->returnValue($templating));

        // Sender Service instance
        $senderService = new SenderService();

        $senderService->setMailer($mailer);
        $senderService->setContainer($container);

        // Composer Service instance
        $composerService = $this->getComposerService();

        // Message instance
        $message = $composerService->createMessage();

        $message->setSubject('Email Delivery Service');
        $message->setRecipient('asd@abc.com');
        $message->setTemplateName('Animal');

        // Testing
        $this->assertTrue($message->isUsable());
        $this->assertTrue($senderService->send($message));
    }

    /**
     * Test failure due to mail transfer agent not sending
     */
    public function testSendFailWithMTANotSending()
    {
        // Mailer mocking
        $mailer = $this->mockMailerService($this->returnValue(0));

        // Template mocking
        $templating = $this->mockTemplatingService();

        // Container mocking (required to allow entering on request scope)
        $container = $this->getMockBuilder('Symfony\Component\DependencyInjection\Container')
            ->disableOriginalConstructor()
            ->getMock();

        $container->expects($this->any())
                  ->method('get')
                  ->with('templating')
                  ->will($this->returnValue($templating));

        // Sender Service instance
        $senderService = new SenderService();

        $senderService->setMailer($mailer);
        $senderService->setContainer($container);

        // Composer Service instance
        $composerService = $this->getComposerService();

        // Message instance
        $message = $composerService->createMessage();

        $message->setSubject('Email Delivery Service');
        $message->setRecipient('asd@abc.com');
        $message->setTemplateName('Animal');

        // Testing
        $this->assertTrue($message->isUsable());
        $this->assertFalse($senderService->send($message));
    }

    /**
     * @expectedException IC\Bundle\Base\MailBundle\Exception\SenderServiceException
     */
    public function testSendFailWithMTAOffline()
    {
        // Mailer mocking
        $mailer = $this->mockMailerService($this->throwException(new \Swift_TransportException('Blah!')));

        // Template mocking
        $templating = $this->mockTemplatingService();

        // Container mocking (required to allow entering on request scope)
        $container = $this->getMockBuilder('Symfony\Component\DependencyInjection\Container')
            ->disableOriginalConstructor()
            ->getMock();

        $container->expects($this->any())
                  ->method('get')
                  ->with('templating')
                  ->will($this->returnValue($templating));

        // Sender Service instance
        $senderService = new SenderService();

        $senderService->setMailer($mailer);
        $senderService->setContainer($container);

        // Composer Service instance
        $composerService = $this->getComposerService();

        // Message instance
        $message = $composerService->createMessage();

        $message->setSubject('Email Delivery Service');
        $message->setRecipient('asd@abc.com');
        $message->setTemplateName('Animal');

        // Testing
        $this->assertTrue($message->isUsable());

        $senderService->send($message);
    }

    public function testSendFailWithUnusableMessage()
    {
        // Mailer mocking
        $mailer = $this->mockMailerService($this->returnValue(1));

        // Template mocking
        $templating = $this->mockTemplatingService();

        // Container mocking (required to allow entering on request scope)
        $container = $this->getMockBuilder('Symfony\Component\DependencyInjection\Container')
            ->disableOriginalConstructor()
            ->getMock();

        $container->expects($this->any())
                  ->method('get')
                  ->with('templating')
                  ->will($this->returnValue($templating));

        // Sender Service instance
        $senderService = new SenderService();

        $senderService->setMailer($mailer);
        $senderService->setContainer($container);

        // Composer Service instance
        $composerService = $this->getComposerService();

        // Message instance
        $message = $composerService->createMessage();

        $message->setSubject('Email Delivery Service');
        $message->setTemplateName('Animal');

        // Testing
        $this->assertFalse($message->isUsable());
        $this->assertFalse($senderService->send($message));
    }

    private function getComposerService()
    {
        $composerService = new ComposerService();

        $composerService->setDefaultSenderName('John Smith');
        $composerService->setDefaultSenderAddress('jsmith@nationalfibre.net');

        return $composerService;
    }

    private function mockMailerService($will = null)
    {
        $mailerService = $this->getMockBuilder('Swift_Mailer')
            ->disableOriginalConstructor()
            ->getMock();

        $mailerService->expects($this->any())
                      ->method('send')
                      ->will($will);

        return $mailerService;
    }

    private function mockTemplatingService()
    {
        $templatingService = $this->getMockBuilder('Symfony\Bundle\TwigBundle\TwigEngine')
            ->disableOriginalConstructor()
            ->getMock();

        $templatingService->expects($this->any())
                          ->method('render')
                          ->will($this->returnValue('from the integration test'));

        return $templatingService;
    }
}
