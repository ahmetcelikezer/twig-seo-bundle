<?php

namespace Ahc\TwigSeoBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\Markup;
use Twig\TwigFunction;

final class AhcTwigSeoExtension extends AbstractExtension
{
    private $baseElements = [
        '<meta property="og:type" content="website" />',
    ];

    private $titleElements = [
        '<title>%title%</title>',
        '<meta property="og:site_name" content="%title%">',
        '<meta property="og:title" content="%title%" />',
        '<meta name="twitter:title" content="%title%" />',
    ];

    private $descriptionElements = [
        '<meta name="description" content="%description%">',
        '<meta property="og:description" content="%description%" />',
        '<meta name="twitter:description" content="%description%" />',
    ];

    private $ogImageElements = [
        '<meta property="og:image" content="%image_path%" />',
        '<meta name="twitter:image" content="%image_path%" />',
        '<link rel="image_src" href="%image_path%" />',
    ];

    public function getFunctions()
    {
        return [
            new TwigFunction('seoTitle', [$this, 'printSeoTitle', ['is_safe' => ['html']]]),
            new TwigFunction('seoDescription', [$this, 'printDescription', ['is_safe' => ['html']]]),
            new TwigFunction('seoBase', [$this, 'printBase', ['is_safe' => ['html']]]),
            new TwigFunction('seoPage', [$this, 'printPageMeta', ['is_safe' => ['html']]]),
            new TwigFunction('seoImage', [$this, 'printSeoImage', ['is_safe' => ['html']]]),
        ];
    }

    public function printSeoTitle(string $title, array $options = null): Markup
    {
        $html = '';

        foreach ($this->titleElements as $titleElement) {
            $html .= str_replace('%title%', $title, $titleElement);
        }

        return self::createMarkup($html);
    }

    public function printDescription(string $description): Markup
    {
        $html = '';

        foreach ($this->descriptionElements as $descriptionElement) {
            $html .= str_replace('%description%', $description, $descriptionElement);
        }

        return self::createMarkup($html);
    }

    public function printBase(): Markup
    {
        $html = '';

        foreach ($this->baseElements as $baseElement) {
            $html .= $baseElement;
        }

        return self::createMarkup($html);
    }

    public function printPageMeta(array $meta): Markup
    {
        $html =
            str_replace('%title%', $meta['title'], '<title>%title%</title>').
            str_replace('%description%', $meta['description'], '<meta name="description" content="%description%">')
        ;

        return self::createMarkup($html);
    }

    public function printSeoImage(string $imagePath): Markup
    {
        $html = '';

        foreach ($this->ogImageElements as $ogImageElement) {
            $html .= str_replace('%image_path%', $imagePath, $ogImageElement);
        }

        return self::createMarkup($html);
    }

    private static function createMarkup(string $html): Markup
    {
        return new Markup($html, 'UTF-8');
    }
}
