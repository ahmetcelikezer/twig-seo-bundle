<?php

namespace Ahc\TwigSeoBundle\Utils;

use Ahc\TwigSeoBundle\Entity\Element;
use Twig\Markup;

class ElementManager
{

    /**
     * @var Element
     */
    private $element;

    /**
     * @var array
     */
    private $configurationManager;

    public function __construct(ConfigurationManager $configurationManager)
    {
        $this->configurationManager = $configurationManager;
    }

    public function setElement(Element $element, bool $autoGetTags = true): self
    {
        $this->element = $element;
        $group = $element->getGroup();

        if($autoGetTags) {
            $arguments = $this->configurationManager->getGroupArguments($group);
            $tags = $this->configurationManager->getGroupTags($group);
            $methods = $this->configurationManager->getGroupMethods($group);

            $element
                ->setArguments($arguments)
                ->setTags($tags)
                ->setMethods($methods)
            ;
        }

        return $this;
    }

    public function registerElementArguments(): self
    {
        $convertedTags = [];

        $arguments = array_flip($this->element->getArguments());
        $argumentValues = $this->element->getArgumentValues();

        $methods = $this->element->getMethods();

        if (count($methods) > 0) {

            array_push($convertedTags, $this->getSubContents(true));
        }

        if(count($arguments) !== 0){
            foreach ($this->element->getTags() as $tag) {

                foreach ($arguments as $key=>$argument) {
                    $convertedTag = str_replace($key, $argumentValues[$argument], $tag, $count);

                    if ($count > 0) {
                        array_push($convertedTags, $convertedTag);
                    }

                }
            }
        } else{
            $convertedTags = $this->element->getTags();
        }

        $this->element->setContentArray($convertedTags);

        return $this;
    }

    public function printElement()
    {
        return new Markup($this->getElementContent(), 'UTF-8');
    }

    public function getElementContent()
    {
        $html = '';

        foreach ($this->element->getContentArray() as $key=>$content) {
            $html .= $content;
        }

        return $html;
    }

    private function getSubContents(bool $asText = false)
    {
        $contentsArray = [];
        $contentsText = '';

        foreach ($this->element->getMethods() as $method) {
            $customElement = new Element($method);
            $customElement->setArgumentValues($this->element->getArgumentValues());

            $em = new self($this->configurationManager);

            $content = $em
                ->setElement($customElement)
                ->registerElementArguments()
                ->getElementContent()
            ;

            if($asText) {
                $contentsText .= $content;
            } else {
                array_push($contentsArray, $content);
            }
        }

        if($asText) {
            return $contentsText;
        }
        return $contentsArray;

    }

}