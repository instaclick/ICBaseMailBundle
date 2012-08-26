<?php
/**
 * @copyright 2012 Instaclick Inc.
 */

namespace IC\Bundle\Base\MailBundle\Tests\Exception;

use IC\Bundle\Base\MailBundle\Exception\SenderServiceException;
use IC\Bundle\Base\MailBundle\Entity\Message;

/**
 * Test for SenderServiceException
 *
 * @group Exception
 *
 * @author Guilherme Blanco <gblanco@nationalfibre.net>
 */
class SenderServiceExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateException()
    {
        $message   = new Message();
        $exception = new SenderServiceException();

        $exception->setMailMessage($message);

        $this->assertEquals($message, $exception->getMailMessage());
    }
}