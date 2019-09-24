<?php

namespace Ahc\TwigSeoBundle\Twig;

use Ahc\TwigSeoBundle\Utils\ElementManager;
use Ahc\TwigSeoBundle\Entity\Element;
use Twig\Extension\AbstractExtension;
use Twig\Markup;
use Twig\TwigFunction;

final class AhcTwigSeoExtension extends AbstractExtension
{
    /**
     * @var ElementManager
     */
    private $elementManager;

    public function __construct(ElementManager $elementManager)
    {
        $this->elementManager = $elementManager;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('seo_title', [$this, 'printSeoTitle', ['is_safe' => ['html']]]),
            new TwigFunction('seo_description', [$this, 'printDescription', ['is_safe' => ['html']]]),
            new TwigFunction('seo_base', [$this, 'printBase', ['is_safe' => ['html']]]),
            new TwigFunction('seo_image', [$this, 'printSeoImage', ['is_safe' => ['html']]]),
            new TwigFunction('seo_group', [$this, 'printSeoGroup', ['is_safe' => ['html']]]),
        ];
    }

    public function printSeoTitle(string $title): Markup
    {
        $titleElement = new Element('default_title');
        $titleElement->setArgumentValues([
            'title' => $title,
        ]);

        return $this->elementManager
            ->setElement($titleElement)
            ->registerElementArguments()
            ->printElement()
        ;
    }

    public function printDescription(string $description): Markup
    {
        $descriptionElement = new Element('default_description');
        $descriptionElement->setArgumentValues([
            'description' => $description,
        ]);

        return $this->elementManager
            ->setElement($descriptionElement)
            ->registerElementArguments()
            ->printElement()
        ;
    }

    public function printBase(): Markup
    {
        $baseElement = new Element('default_base');

        return $this->elementManager
            ->setElement($baseElement)
            ->registerElementArguments()
            ->printElement()
        ;
    }


    public function printSeoImage(string $imagePath): Markup
    {
        $titleElement = new Element('default_og_images');
        $titleElement->setArgumentValues([
            'image_path' => $imagePath,
        ]);

        return $this->elementManager
            ->setElement($titleElement)
            ->registerElementArguments()
            ->printElement()
        ;
    }

    public function printSeoGroup(string $group, array $parameters, array $options = null): Markup
    {
        $customElement = new Element($group);
        $customElement->setArgumentValues($parameters);

        return $this->elementManager
            ->setElement($customElement)
            ->registerElementArguments()
            ->printElement()
        ;
    }

}
