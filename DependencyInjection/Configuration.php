<?php
/**
 * @copyright 2012 Instaclick Inc.
 */

namespace IC\Bundle\Base\MailBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author Anthon Pang <anthon.pang@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ic_base_mail');

        $rootNode
            ->children()
                ->arrayNode('composer')
                    ->children()
                        ->arrayNode('default_sender')
                            ->children()
                                ->scalarNode('name')
                                    ->isRequired()
                                    ->cannotBeEmpty()
                                    ->cannotBeOverwritten()
                                ->end()
                                ->scalarNode('address')
                                    ->isRequired()
                                    ->cannotBeEmpty()
                                    ->cannotBeOverwritten()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('mail_bounce')
                    ->children()
                        ->scalarNode('mailhost')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('port')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('username')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('password')
                            ->defaultValue('')
                        ->end()
                        ->scalarNode('service')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('option')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('mailbox')
                            ->defaultValue('INBOX')
                            ->cannotBeEmpty()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
