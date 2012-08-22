<?php
/**
 * @copyright 2012 Instaclick Inc.
 */

namespace IC\Bundle\Base\MailBundle\Exception;

use IC\Bundle\Base\MailBundle\Entity\Message;

/**
 * Sender Service Exception
 *
 * @author Juti Noppornpitak <jutin@nationalfibre.net>
 */
class SenderServiceException extends \Exception
{
    /**
     * @var \IC\Bundle\Base\MailBundle\Entity\Message
     */
    protected $mailMessage;

    /**
     * Define the mail message
     *
     * @param \IC\Bundle\Base\MailBundle\Entity\Message $mailMessage
     */
    public function setMailMessage(Message $mailMessage)
    {
        $this->mailMessage = $mailMessage;
    }

    /**
     * Retrieve the mail message.
     *
     * @return \IC\Bundle\Base\MailBundle\Entity\Message
     */
    public function getMailMessage()
    {
        return $this->mailMessage;
    }
}
