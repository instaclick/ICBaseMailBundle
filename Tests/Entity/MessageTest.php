<?php
/**
 * @copyright 2012 Instaclick Inc.
 */

namespace IC\Bundle\Base\MailBundle\Tests\Entity;

use IC\Bundle\Base\MailBundle\Entity\Message;

/**
 * Tests for Message entity.
 *
 * @group Model
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
class MessageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param array   $data     Message data
     * @param boolean $expected Expected usable or not
     *
     * @dataProvider provideDataForIsUsable
     */
    public function testIsUsable($data, $expected)
    {
        $message = new Message();

        $message->setContentType('text/html');
        $message->setReplyTo('no_reply@test.com');
        $message->setReturnPath('/');
        $message->setSenderName($data['sender_name']);
        $message->setSenderAddress($data['sender_address']);
        $message->setRecipient($data['recipient']);
        $message->setSubject($data['subject']);
        $message->setTemplateName($data['template_name']);
        $message->setParameterList(array());

        $this->assertEquals($expected, $message->isUsable());
    }

    /**
     * @dataProvider provideDataForIsUsable
     *
     * @return array
     */
    public function provideDataForIsUsable()
    {
        return array(
            array(
                array(
                    'sender_name'    => null,
                    'sender_address' => null,
                    'recipient'      => null,
                    'subject'        => null,
                    'template_name'  => null
                ),
                false
            ),
            array(
                array(
                    'sender_name'    => 'test1@nationalfibre.net',
                    'sender_address' => null,
                    'recipient'      => null,
                    'subject'        => null,
                    'template_name'  => null
                ),
                false
            ),
            array(
                array(
                    'sender_name'    => 'test1@nationalfibre.net',
                    'sender_address' => 'Test1',
                    'recipient'      => null,
                    'subject'        => null,
                    'template_name'  => null
                ),
                false
            ),
            array(
                array(
                    'sender_name'    => 'test1@nationalfibre.net',
                    'sender_address' => 'Test1',
                    'recipient'      => 'test2@nationalfibre.net',
                    'subject'        => null,
                    'template_name'  => null
                ),
                false
            ),
            array(
                array(
                    'sender_name'    => 'test1@nationalfibre.net',
                    'sender_address' => 'Test1',
                    'recipient'      => 'test2@nationalfibre.net',
                    'subject'        => 'Foobar',
                    'template_name'  => null
                ),
                false
            ),
            array(
                array(
                    'sender_name'    => 'test1@nationalfibre.net',
                    'sender_address' => 'Test1',
                    'recipient'      => 'test2@nationalfibre.net',
                    'subject'        => 'Foobar',
                    'template_name'  => 'Testing'
                ),
                true
            ),
        );
    }
}
