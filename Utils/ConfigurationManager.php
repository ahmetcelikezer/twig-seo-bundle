<?php

namespace Ahc\TwigSeoBundle\Utils;

use InvalidArgumentException;

class ConfigurationManager
{
    /**
     * @var array
     */
    private $configurations;

    public function __construct($configurations)
    {
        $this->configurations = $configurations;
    }

    public function getConfiguration(string $key): array
    {
        return $this->configurations[$key];
    }

    public function getGroups():array
    {
        return $this->getConfiguration('groups');
    }

    public function getGroup(string $group): array
    {
        if(true === array_key_exists($group, $this->getGroups())){
            return $this->getGroups()[$group];
        }

        throw new InvalidArgumentException('Group ['.$group.'] not exists!');
    }

    public function getGroupArguments(string $group): array
    {
        return $this->getGroup($group)['arguments'];
    }

    public function getGroupTags(string $group): array
    {
        return $this->getGroup($group)['tags'];
    }

    public function getGroupMethods(string $group): array
    {
        return $this->getGroup($group)['methods'];
    }
}