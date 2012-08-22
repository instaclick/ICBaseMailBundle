<?php
/**
 * @copyright 2012 Instaclick Inc.
 */

namespace IC\Bundle\Base\MailBundle\Service;

use Symfony\Component\DependencyInjection\ContainerAware;

use Symfony\Component\HttpFoundation\Request;

use IC\Bundle\Base\MailBundle\Entity\Message;
use IC\Bundle\Base\MailBundle\Exception\SenderServiceException;

/**
 * Mail Sender Service
 *
 * @author Juti Noppornpitak <jutin@nationalfibre.net>
 * @author Guilherme Blanco <gblanco@nationalfibre.net>
 * @author Anthon Pang <anthonp@nationalfibre.net>
 */
class SenderService extends ContainerAware
{
    /**
     * @var \Swift_Mailer mail transport agent
     */
    private $mailer;

    /**
     * Define the Mailer service
     *
     * @param \Swift_Mailer $mailer Mailer
     */
    public function setMailer(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Send the message.
     *
     * According to the documentation, Swift_Mailer::send returns the number of sent messages. In this case, as we only
     * send one message at a time, we are expecting the returned value to be one. However, in unlikely case that the
     * message pool is used and multiple messages are sent, so this method will be checking whether or not there are any
     * messages sent at all.
     *
     * @param \IC\Bundle\Base\MessageBundle\Model\Message $message
     *
     * @return boolean TRUE only if there are at least one message sent.
     */
    public function send(Message $message)
    {
        if ( ! $message->isUsable()) {
            return false;
        }

        try {
            return $this->performSending($message);
        } catch (\Exception $exception) {
            $exception = new SenderServiceException('Could not send message.', 500, $exception);
            $exception->setMailMessage($message);

            throw $exception;
        }
    }

    /**
     * Really perform sending the given message.
     *
     * @param \IC\Bundle\Base\MessageBundle\Model\Message $message
     *
     * @return boolean TRUE only if there are at least one message sent.
     *
     * @throws \IC\Bundle\Base\ComponentBundle\Exception\ServiceException
     */
    protected function performSending(Message $message)
    {
        $swiftMessage        = $this->convertToSwiftMessage($message);
        $deliveredRecipients = $this->mailer->send($swiftMessage);

        return ($this->mailer->getTransport() instanceof \Swift_Transport_NullTransport)
            ? true
            : ($deliveredRecipients > 0);
    }

    /**
     * Convert the message to a swift message.
     *
     * @param \IC\Bundle\Base\MailBundle\Entity\Message $message
     *
     * @return \Swift_Message
     */
    private function convertToSwiftMessage(Message $message)
    {
        $templatingService = $this->getTemplatingService();
        $renderedMessage   = $templatingService->render($message->getTemplateName(), $message->getContexts());

        $envelope = new \Swift_Message();

        $envelope->setSubject($message->getSubject());
        $envelope->setTo($message->getRecipient());
        $envelope->setFrom($message->getSender());
        $envelope->setBody($renderedMessage, $message->getContentType());
        $envelope->setReplyTo($message->getReplyTo());
        $envelope->setReturnPath($message->getReturnPath());

        return $envelope;
    }

    /**
     * Retrieve the templating service
     *
     * {@internal Templating service requires to be inside of a Request scope.
     *            This introduces a hack required by Symfony in order to work smoothly.}
     *
     * @return \Symfony\Bundle\TwigBundle\TwigEngine
     */
    private function getTemplatingService()
    {
        $this->container->enterScope('request');
        $this->container->set('request', Request::createFromGlobals(), 'request');

        return $this->container->get('templating');
    }
}
