<?php
/**
 * @copyright 2012 Instaclick Inc.
 */

namespace IC\Bundle\Base\MailBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 *
 * @author Anthon Pang <anthonp@nationalfibre.net>
 */
class ICBaseMailExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        // Composer default sender configuration values
        $container->setParameter(
            'base.mail.parameter.composer.default_sender.name',
            $config['composer']['default_sender']['name']
        );

        $container->setParameter(
            'base.mail.parameter.composer.default_sender.address',
            $config['composer']['default_sender']['address']
        );

        // Mail bounce configuration values
        $container->setParameter(
            'base.mail.parameter.mail_bounce.mailhost',
            $config['mail_bounce']['mailhost']
        );

        $container->setParameter(
            'base.mail.parameter.mail_bounce.port',
            $config['mail_bounce']['port']
        );

        $container->setParameter(
            'base.mail.parameter.mail_bounce.username',
            $config['mail_bounce']['username']
        );

        $container->setParameter(
            'base.mail.parameter.mail_bounce.password',
            $config['mail_bounce']['password']
        );

        $container->setParameter(
            'base.mail.parameter.mail_bounce.service',
            $config['mail_bounce']['service']
        );

        $container->setParameter(
            'base.mail.parameter.mail_bounce.option',
            $config['mail_bounce']['option']
        );

        $container->setParameter(
            'base.mail.parameter.mail_bounce.mailbox',
            $config['mail_bounce']['mailbox']
        );
    }
}
