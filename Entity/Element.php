<?php

namespace Ahc\TwigSeoBundle\Entity;

class Element
{
    /**
     * @var array
     */
    private $arguments;

    /**
     * @var array
     */
    private $tags;

    /**
     * @var array
     */
    private $methods;

    /**
     * @var array
     */
    private $contentArray;

    /**
     * @var string
     */
    private $group;

    /**
     * @var array
     */
    private $argumentValues;

    public function __construct(string $group = null)
    {
        $this->setGroup($group);
    }

    /**
     * @return string
     */
    public function getGroup(): string
    {
        return $this->group;
    }

    public function setGroup(string $group): self
    {
        $this->group = $group;

        return $this;
    }

    public function getArguments(): ?array
    {
        return $this->arguments;
    }

    public function setArguments(array $arguments): self
    {
        $this->arguments = $arguments;

        return $this;
    }

    public function getArgumentValues(): ?array
    {
        return $this->argumentValues;
    }

    public function setArgumentValues(array $values): self
    {
        $this->argumentValues = $values;

        return $this;
    }

    public function getTags(): ?array
    {
        return $this->tags;
    }

    public function setTags(array $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    public function getMethods(): ?array
    {
        return $this->methods;
    }

    public function setMethods(array $methods): self
    {
        $this->methods = $methods;

        return $this;
    }

    public function getContentArray(): ?array
    {
       return $this->contentArray;
    }

    public function setContentArray(array $content): self
    {
        $this->contentArray = $content;

        return $this;
    }
}