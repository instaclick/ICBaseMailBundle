<?php
/**
 * @copyright 2012 Instaclick Inc.
 */

namespace IC\Bundle\Base\MailBundle\Entity;

/**
 * The model of e-mail package used to send out with SwiftMailer.
 *
 * @author Juti Noppornpitak <jnopporn@shiroyuki.com>
 * @author Anthon Pang <anthon.pang@gmail.com>
 */
class Message
{
    /**
     * @var string
     */
    protected $subject;

    /**
     * @var string
     */
    protected $recipient;

    /**
     * @var string
     */
    protected $senderName;

    /**
     * @var string
     */
    protected $senderAddress;

    /**
     * @var string
     */
    protected $replyTo;

    /**
     * @var string
     */
    protected $returnPath;

    /**
     * @var string
     */
    protected $templateName;

    /**
     * @var array
     */
    protected $parameterList = array();

    /**
     * @var string
     */
    protected $contentType = 'text/html';

    /**
     * Get the subject.
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set the subject.
     *
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * Get the recipient.
     *
     * @return string
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * Set the recipient.
     *
     * @param string $recipient
     */
    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;
    }

    /**
     * Get the senderName.
     *
     * @return string
     */
    public function getSenderName()
    {
        return $this->senderName;
    }

    /**
     * Set the senderName.
     *
     * @param string $senderName
     */
    public function setSenderName($senderName)
    {
        $this->senderName = $senderName;
    }

    /**
     * Get the senderAddress.
     *
     * @return string
     */
    public function getSenderAddress()
    {
        return $this->senderAddress;
    }

    /**
     * Set the senderAddress.
     *
     * @param string $senderAddress
     */
    public function setSenderAddress($senderAddress)
    {
        $this->senderAddress = $senderAddress;
    }

    /**
     * Get the sender (as a composite value of name and address)
     *
     * @return array
     */
    public function getSender()
    {
        return array($this->senderAddress => $this->senderName);
    }

    /**
     * Get the replyTo address.
     *
     * @return array
     */
    public function getReplyTo()
    {
        return $this->replyTo;
    }

    /**
     * Set the repylTo address.
     *
     * @param string $replyTo
     */
    public function setReplyTo($replyTo)
    {
        $this->replyTo = $replyTo;
    }

    /**
     * Get the returnPath.
     *
     * @return array
     */
    public function getReturnPath()
    {
        return $this->returnPath;
    }

    /**
     * Set the returnPath.
     *
     * @param string $returnPath
     */
    public function setReturnPath($returnPath)
    {
        $this->returnPath = $returnPath;
    }

    /**
     * Get the templateName.
     *
     * @return string
     */
    public function getTemplateName()
    {
        return $this->templateName;
    }

    /**
     * Set the templateName.
     *
     * @param string $templateName
     */
    public function setTemplateName($templateName)
    {
        $this->templateName = $templateName;
    }

    /**
     * Get the parameterList.
     *
     * @return array
     */
    public function getParameterList()
    {
        return $this->parameterList;
    }

    /**
     * Set the parameterList.
     *
     * @param array $parameterList
     */
    public function setParameterList(array $parameterList = array())
    {
        $this->parameterList = $parameterList;
    }

    /**
     * Get the contentType.
     *
     * @return string
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * Set the contentType.
     *
     * @param string $contentType
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
    }

    /**
     * Check if this message is usable.
     *
     * @return boolean
     */
    public function isUsable()
    {
        return ( ! (
            empty($this->senderName) || empty($this->senderAddress) || empty($this->recipient) || empty($this->subject) || empty($this->templateName)
        ));
    }
}
