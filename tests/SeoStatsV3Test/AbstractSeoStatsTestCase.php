<?php

namespace SeoStatsV3Test;

use ReflectionClass;

abstract class AbstractSeoStatsTestCase extends \PHPUnit_Framework_TestCase
{
    public function setup()
    {
        parent::setup();
    }


    public function helperMakeAccessable ($object, $propertyOrMethod, $value = null)
    {
        $reflection = $this->helperGetReflectionObject($object);
        $isMethod = $reflection->hasMethod($propertyOrMethod);

        if ($isMethod) {
            $reflectionSub = $reflection->getMethod($propertyOrMethod);
        } else {
            $reflectionSub = $reflection->getProperty($propertyOrMethod);
        }

        $reflectionSub->setAccessible(true);

        if (!is_null($value)) {
            if ($isMethod) {
                return $reflectionSub->invokeArgs($object, $value);
            } else {
                $reflectionSub->setValue($object, $value);
            }
        }

        return $reflectionSub;
    }


    public function helperSetAttributes ($object, $attributes)
    {
        foreach ($attributes as $attributeName => $attributeValue) {
            $setterMethodName = $this->helperGetAttributesSetter($object, $attributeName);

            $this->helperMakeAccessable($object,
                                        $setterMethodName ?: $attributeName,
                                        $setterMethodName ? array($attributeValue) : $attributeValue
                                        );
        }
    }

    public function helperGetAttributesSetter ($objectClass, $attribute)
    {
        $reflection = $this->helperGetReflectionObject($objectClass);

        $methodeArray= array(
            'set' . ucwords($attribute),
            'set_' . $attribute,
            $attribute
        );

        foreach ($methodeArray as $methodName) {
            if (!$reflection->hasMethod($methodName)) {
                continue;
            }

            return $methodName;
        }
        return false;
    }

    public function helperGetReflectionObject ($object)
    {
        if ( is_string($object) ) {
            $objectClass = $object;
            $object = null;
        } else {
            $objectClass = get_class($object);
        }

        if (!isset($this->reflection[$objectClass])) {
            $this->reflection[$objectClass] = new ReflectionClass($objectClass);
        }
        return $this->reflection[$objectClass];
    }



    public function isHhvm($version = null, $conpareMethod = '<')
    {
        return defined('HHVM_VERSION') &&
               (
                is_null($version) ||
                version_compare(HHVM_VERSION, $version, $conpareMethod)
               );
    }
}
