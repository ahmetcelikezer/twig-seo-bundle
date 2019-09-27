<?php

namespace Ahc\TwigSeoBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('ahc_twig_seo');

        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('groups')
                    ->arrayPrototype()
                        ->children()
                            ->arrayNode('arguments')
                                ->scalarPrototype()
                                ->end()
                            ->end()
                            ->arrayNode('tags')
                                ->variablePrototype()
                                ->end()
                            ->end()
                            ->arrayNode('methods')
                                ->variablePrototype()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->booleanNode('overwritable_defaults')->defaultTrue()->end()
            ->end()
        ;

        return $treeBuilder;

    }
}