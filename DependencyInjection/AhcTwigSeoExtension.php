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
    /**
     * @var array
     */
    private $preLoadedConfigs;

    public function load(array $configs, ContainerBuilder $container)
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yaml');

        $config = $this->overwriteDefaultConfigs($config);
        dd($config);
        $container->setParameter('ahc_twig_seo_config', $config);
    }

    public function prepend(ContainerBuilder $container)
    {
        $configs = Yaml::parseFile(__DIR__.'/../Resources/config/ahc_twig_seo.yaml');
        $this->preLoadedConfigs = $configs['ahc_twig_seo'];
    }

    private function overwriteDefaultConfigs(array $configs): array
    {
        $defaultGroups = array_keys($this->preLoadedConfigs['groups']);
        $customGroups = array_keys($configs['groups']);

        foreach ($customGroups as $customGroup) {
            if(in_array($customGroup, $defaultGroups)) {
                unset($this->preLoadedConfigs['groups'][$customGroup]);
            }
        }

        return array_merge($this->preLoadedConfigs['groups'], $configs['groups']);

    }
}