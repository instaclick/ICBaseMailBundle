<?php
/**
 * @copyright 2012 Instaclick Inc.
 */

namespace IC\Bundle\Base\MailBundle\Service;

use IC\Bundle\Base\MailBundle\Entity\Message;

/**
 * Mail Composer Service
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author Juti Noppornpitak <jnopporn@shiroyuki.com>
 */
class ComposerService
{
    /**
     * @var string the default name of the sender
     */
    private $defaultSenderName;

    /**
     * @var string the default (email) address of the sender
     */
    private $defaultSenderAddress;

    /**
     * Define the default sender name.
     *
     * @param string $defaultSenderName
     */
    public function setDefaultSenderName($defaultSenderName)
    {
        $this->defaultSenderName = $defaultSenderName;
    }

    /**
     * Define the default sender address.
     *
     * @param string $defaultSenderAddress
     */
    public function setDefaultSenderAddress($defaultSenderAddress)
    {
        $this->defaultSenderAddress = $defaultSenderAddress;
    }

    /**
     * Create a message.
     *
     * @return \IC\Bundle\Base\MailBundle\Entity\Message
     */
    public function createMessage()
    {
        $message = new Message();

        $message->setSenderName($this->defaultSenderName);
        $message->setSenderAddress($this->defaultSenderAddress);

        return $message;
    }
}
