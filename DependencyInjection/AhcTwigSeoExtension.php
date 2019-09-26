<?php

namespace Ahc\TwigSeoBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\Yaml\Yaml;


class AhcTwigSeoExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yaml');

        $container->setParameter('ahc_twig_seo_config', $config);
    }

    public function prepend(ContainerBuilder $container)
    {
        $config = Yaml::parseFile(__DIR__.'/../Resources/config/ahc_twig_seo.yaml');

        $container->prependExtensionConfig('ahc_twig_seo', $config['ahc_twig_seo']);
    }
}