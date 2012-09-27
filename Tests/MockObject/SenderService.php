<?php

namespace IC\Bundle\Base\MailBundle\Tests\MockObject;

use IC\Bundle\Base\MailBundle\Entity\Message;
use IC\Bundle\Base\MailBundle\Service\SenderService as BaseSenderService;

/**
 * Mock actual SenderService
 *
 * @author Juti Noppornpitak <jnopporn@shiroyuki.com>
 */
class SenderService extends BaseSenderService
{
    /**
     * @var mixed
     */
    protected $expectedResult;

    /**
     * Constructor
     */
    public function __construct()
    {
        // No operation
    }

    /**
     * Set the expected result.
     *
     * @param boolean|\Exception $expectedResult
     */
    public function setExpectedResult($expectedResult)
    {
        $this->expectedResult = $expectedResult;
    }

    /**
     * {@inheritdoc}
     */
    protected function performSending(Message $message)
    {
        if (is_bool($this->expectedResult)) {
            return $this->expectedResult;
        }

        throw $this->expectedResult;
    }
}