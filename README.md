# InstaClick Base Mail Bundle

[![Build Status](https://secure.travis-ci.org/instaclick/ICBaseMailBundle.png)](http://travis-ci.org/instaclick/ICBaseMailBundle)

## Introduction

This bundle provides a lower level support for mail manipulation on Symfony2.
It is supported to deal with composing, sending and dealing with bounced
messages in an abstract API.

## Installation

Installing this bundle can be done through these simple steps:

1. Add this bundle to your project as a composer dependency:

```javascript
// composer.json
{
    // ...
    require: {
        // ...
        "instaclick/base-mail-bundle": "dev-master"
    }
}
```

2. Add this bundle in your application kernel:

```php
// application/ApplicationKernel.php
public function registerBundles()
{
    // ...
    $bundles[] = new IC\Bundle\Base\MailBundle\ICBaseTestBundle();

    return $bundles;
}
```

## Configuring the bundle

By default, any composed message contains a sender name and address. This
simplifies the implementation time and cleaner code. You are allowed to
change these values anytime, but if negative, you can globally configure this
support.

To define the default sender name and address, do the following:

```
ic_base_mail:
    composer:
        default_sender:
            name:    "InstaClick Mail Delivery"
            address: "noreply@instaclick.com"
```

This bundle also comes with a bounced email handler. For any reasons, when
dealing with delivery of messages to users' mailbox, you also need to handle
possible failures that users may have done. The best example is mispelled email
addresses.
To configure the bounced email handler, configure the `mail_bounce` section in
bundle's configuration:

```
ic_base_mail:
    mail_bounce:
        mailhost: "imap.gmail.com"
        port:     993
        username: "%mailer_gmail_username%"
        password: "%mailer_gmail_password%"
        service:  "imap"
        option:   "ssl"
        mailbox:  "INBOX"
```

## Using available Services

The purpose of this bundle is to simplify mail creation, sending and handling
possible failures. These three sections derived into three services that can be
used by any application that consumes this bundle.

### Composer Service

Responsible to compose messages. Configured default sender automatically
injects sender name and address to any message that gets created out of this
service. The methods `setDefaultSenderName` and `setDefaultSenderAddress`
provide an ability to modify the values at runtime if necessary.
Apart from the before mentioned methods, this service only contains one method:
`createMessage`; it initializes a new message to be prepared for sending.

```php
$composerService = $this->getContainer()->get('ic_base_mail.service.composer');
$message         = $composerService->createMessage();
```

A message instance contains a lot of options that can be defined by consuming
its API. By default, any message is configured to be a `text/html` message and
the method `setContentType` provides an ability to modify this behavior.

The interface for Message API is the following one:

```php
interface MessageInterface
{
    /**
     * Get the subject.
     *
     * @return string
     */
    public function getSubject();

    /**
     * Set the subject.
     *
     * @param string $subject
     */
    public function setSubject($subject);

    /**
     * Get the recipient.
     *
     * @return string
     */
    public function getRecipient();

    /**
     * Set the recipient.
     *
     * @param string $recipient
     */
    public function setRecipient($recipient);

    /**
     * Get the senderName.
     *
     * @return string
     */
    public function getSenderName();

    /**
     * Set the senderName.
     *
     * @param string $senderName
     */
    public function setSenderName($senderName);

    /**
     * Get the senderAddress.
     *
     * @return string
     */
    public function getSenderAddress();

    /**
     * Set the senderAddress.
     *
     * @param string $senderAddress
     */
    public function setSenderAddress($senderAddress);

    /**
     * Get the sender (as a composite value of name and address)
     *
     * @return array
     */
    public function getSender();

    /**
     * Get the replyTo address.
     *
     * @return array
     */
    public function getReplyTo();

    /**
     * Set the repylTo address.
     *
     * @param string $replyTo
     */
    public function setReplyTo($replyTo);

    /**
     * Get the returnPath.
     *
     * @return array
     */
    public function getReturnPath();

    /**
     * Set the returnPath.
     *
     * @param string $returnPath
     */
    public function setReturnPath($returnPath);

    /**
     * Get the templateName.
     *
     * @return string
     */
    public function getTemplateName();

    /**
     * Set the templateName.
     *
     * @param string $templateName
     */
    public function setTemplateName($templateName);

    /**
     * Get the parameterList.
     *
     * @return array
     */
    public function getParameterList();

    /**
     * Set the parameterList.
     *
     * @param array $parameterList
     */
    public function setParameterList(array $parameterList = array());

    /**
     * Get the contentType.
     *
     * @return string
     */
    public function getContentType();

    /**
     * Set the contentType.
     *
     * @param string $contentType
     */
    public function setContentType($contentType);

    /**
     * Check if this message is usable.
     *
     * @return boolean
     */
    public function isUsable();
}
```

### Sender Service

After your message is composed, it is time to send it. Sender service provides
this support by exposing a public method called `send`. This method returns a
boolean value in case of successful delivery or failure. It does not take into
consideration bounced mail, since this is an asynchronous action that must be
implemented by a consumer of BounceMail Service.

```php
// ...
$composerService = $this->getContainer()->get('ic_base_mail.service.composer');
$senderService   = $this->getContainer()->get('ic_base_mail.service.sender');

$message = $composerService->createMessage();

$message->setSubject('Email Delivery Service');
$message->setRecipient('user@domain.com');
$message->setTemplateName('ICCoreSiteBundle:EmailTemplates:welcome.html.twig');
$message->setParameterList(array('username' => 'Guilherme Blanco'));

$sentSuccessfully = $senderService->send($message);
```

### BounceMail Service

TBD