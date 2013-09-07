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
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author Anthon Pang <anthon.pang@gmail.com>
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
        $parameterList = array('name', 'address');

        foreach ($parameterList as $parameter) {
            $container->setParameter(
                $this->getAlias() . '.composer.default_sender.' . $parameter,
                $config['composer']['default_sender'][$parameter]
            );
        }
    }
}
