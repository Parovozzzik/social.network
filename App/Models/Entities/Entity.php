<?php

namespace App\Models\Entities;

class Entity
{
    public static $table;
    public static $idColumn;

    /**
     * Entity constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            $attrNameParts = explode('_', $key);
            $attrNameParts = array_map(function ($part) {
                return ucfirst($part);
            }, $attrNameParts);
            $attrName = implode('', $attrNameParts);
            $this->{lcfirst($attrName)} = $value;

            $methodSetName = 'set' . $attrName;
            $methodGetName = 'get' . $attrName;
            $this->$methodGetName = function () use ($value) {
                return $value;
            };
            $this->$methodSetName = function () use ($key, $value) {
                $this->$key = $value;
            };
        }

    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    public function toArray(): array
    {
        $result = [];
        $properties = (new \ReflectionObject($this))->getProperties();

        foreach ($properties as $property) {
            $propertyName = $property->getName();
            if (is_callable($this->$propertyName)) {
                continue;
            }
            $getter = 'get' . ucfirst($propertyName);

            if (method_exists($this, $getter)) {

                if (is_object($this->$getter())) {
                    /** @var Entity $obj */
                    $obj = $this->$getter();
                    if ($obj instanceof \DateTime) {
                        $value = $obj->format('c');
                    } else {
                        $value = $obj->toArray();
                    }
                    $result[$propertyName] = $value;
                } else {
                    $result[$propertyName] = $this->$getter();
                }
            } else {
                $result[$propertyName] = $this->$propertyName;
            }
        }

        return $result;
    }
}