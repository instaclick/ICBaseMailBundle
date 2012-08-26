<?php
/**
 * @copyright 2012 Instaclick Inc.
 */

namespace IC\Bundle\Base\MailBundle\Service;

use BounceMailHandler\BounceMailHandler;

/**
 * Bounce mail Service
 *
 * @author Guilherme Blanco <gblanco@nationalfibre.net>
 * @author Anthon Pang <anthonp@nationalfibre.net>
 */
class BounceMailService
{
    /**
     * @var \BounceMailHandler\BounceMailHandler
     */
    protected $bounceMailHandler;

    /**
     * @var boolean
     */
    protected $debug = false;

    /**
     * @var string $localPath Local mailbox file path
     */
    protected $localMailboxPath;

    /**
     * {@inheritdoc}
     */
    public function setBounceMailHandler(BounceMailHandler $bounceMailHandler)
    {
        $this->bounceMailHandler = $bounceMailHandler;
    }

    /**
     * Enable/disable debug
     *
     * @param boolean $debug True to enable debug; false to disable debug
     */
    public function setDebug($debug)
    {
        $this->debug = $debug;
    }

    /**
     * Set local mailbox path
     *
     * @param string $localMailboxPath Absolute path to local mailbox file
     *
     * @throws \Exception
     */
    public function setLocalMailboxPath($localMailboxPath = null)
    {
        if ( ! $localMailboxPath) {
            return;
        }

        if ( ! file_exists($localMailboxPath)) {
            throw new \InvalidArgumentException('Local mailbox does not exist: ' . $localMailboxPath);
        }

        $localMailboxPath = realpath($localMailboxPath);
        $homeDirectory    = getenv('HOME');

        if (strncmp($localMailboxPath, $homeDirectory . DIRECTORY_SEPARATOR, strlen($homeDirectory) + 1)) {
            throw new \InvalidArgumentException('Mailbox must be under home directory: ' . $homeDirectory);
        }

        $this->localMailboxPath = substr($localMailboxPath, strlen($homeDirectory) + 1);
    }

    /**
     * Process bounced mail messages
     *
     * @param function $callback Callback function
     */
    public function execute($callback)
    {
        $handler = $this->bounceMailHandler;

        $handler->actionFunction = $callback;
        $handler->testMode       = $this->debug;

        $this->localMailboxPath
            ? $handler->openLocal($this->localMailboxPath)
            : $handler->openMailbox();

        $handler->processMailbox();
    }
}
