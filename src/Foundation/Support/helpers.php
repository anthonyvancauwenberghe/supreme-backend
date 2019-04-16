<?php

if (!function_exists('get_module_path')) {
    function get_module_path(string $module)
    {
        $module = ucfirst($module);
        $path = base_path('src/Modules') . '/' . $module;
        if (file_exists($path)) {
            return $path;
        }
        throw new \Foundation\Exceptions\Exception('Module not found', 500);
    }
}

if (!function_exists('get_foundation_path')) {
    function get_foundation_path()
    {
        return base_path('src/Foundation');
    }
}

if (!function_exists('get_authenticated_user_id')) {
    function get_authenticated_user_id()
    {
        return get_authenticated_user()->id;
    }
}

if (!function_exists('get_authenticated_user')) {

    /**
     * @return \Modules\User\Entities\User
     */
    function get_authenticated_user(): \Illuminate\Contracts\Auth\Authenticatable
    {
        if (Auth::user() !== null) {
            return Auth::user();
        } else {
            throw new \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException('no authorized user');
        }
    }
}

if (!function_exists('get_short_class_name')) {
    function get_short_class_name($class)
    {
        if (!is_string($class)) {
            $class = get_class($class);
        }

        return substr(strrchr($class, '\\'), 1);
    }
}

if (!function_exists('get_random_array_element')) {
    function get_random_array_element(array $array)
    {
        if (empty($array)) {
            return;
        }
        $randomIndex = random_int(0, count($array) - 1);

        return $array[$randomIndex];
    }
}
if (!function_exists('create_multiple_from_factory')) {
    function create_multiple_from_factory(string $modelClass, $amount = 1, ?string $state = null)
    {
        if ($amount < 1) {
            return false;
        }

        $factory = factory($modelClass, $amount);

        if ($state !== null) {
            $factory->state($state);
        }

        return $factory->raw();
    }
}

if (!function_exists('create_from_factory')) {
    function create_from_factory(string $modelClass, ?string $state = null)
    {
        $factory = factory($modelClass);

        if ($state !== null) {
            $factory->state($state);
        }

        return $factory->raw();
    }
}

if (!function_exists('class_implements_interface')) {
    function class_implements_interface($class, $interface)
    {
        return in_array($interface, class_implements($class));
    }
}

if (!function_exists('class_uses_trait')) {
    function class_uses_trait($class, string $trait)
    {
        if (!is_string($class)) {
            $class = get_class($class);
        }

        $traits = array_flip(class_uses_recursive($class));

        return isset($traits[$trait]);
    }
}
if (!function_exists('array_keys_exists')) {
    function array_keys_exists(array $keys, array $arr)
    {
        return !array_diff_key(array_flip($keys), $arr);
    }
}

if (!function_exists('array_is_subset_of')) {
    function array_is_subset_of(array $subset, array $array, bool $strict = false)
    {
        $arrayAssociative = is_associative_array($array);
        $subsetAssociative = is_associative_array($subset);

        if ($subsetAssociative && $arrayAssociative) {
            $patched = \array_replace_recursive($array, $subset);

            if ($strict) {
                $result = $array === $patched;
            } else {
                $result = $array == $patched;
            }

            return $result;
        } elseif (($subsetAssociative && !$arrayAssociative) ||
            (!$subsetAssociative && $arrayAssociative)) {
            return false;
        }

        $result = array_intersect($subset, $array);

        if ($strict) {
            return $result === $subset;
        }

        return $result == $subset;
    }
}

if (!function_exists('is_associative_array')) {
    function is_associative_array(array $arr)
    {
        if ([] === $arr) {
            return false;
        }

        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}

if (!function_exists('get_class_property')) {
    function get_class_property($class, string $property)
    {
        if (!is_string($class)) {
            $class = get_class($class);
        }

        try {
            $reflectionClass = new \ReflectionClass($class);
            $property = $reflectionClass->getProperty($property);
            $property->setAccessible(true);
        } catch (ReflectionException $e) {
            return;
        }

        return $property->getValue($reflectionClass->newInstanceWithoutConstructor());
    }
}

if (!function_exists('instance_without_constructor')) {
    function instance_without_constructor($class)
    {
        if (!is_string($class)) {
            $class = get_class($class);
        }

        try {
            $reflectionClass = new \ReflectionClass($class);
        } catch (ReflectionException $e) {
            return;
        }
        if ($reflectionClass->isAbstract()) {
            return;
        }

        return $reflectionClass->newInstanceWithoutConstructor();
    }
}

if (!function_exists('call_class_function')) {
    function call_class_function($class, string $methodName)
    {
        return instance_without_constructor($class)->$methodName();
    }
}

if (!function_exists('get_class_constants')) {
    function get_class_constants($class)
    {
        if (!is_string($class)) {
            $class = get_class($class);
        }

        try {
            $reflectionClass = new \ReflectionClass($class);
        } catch (ReflectionException $e) {
            return;
        }

        return $reflectionClass->getConstants();
    }
}

if (!function_exists('split_caps_to_underscore')) {
    function split_caps_to_underscore(string $string)
    {
        $splittedString = "";
        $splittedInCapsName = preg_split('/(?=[A-Z])/', $string);
        $i = 0;
        foreach ($splittedInCapsName as $word) {
            if ($i !== 0)
                $splittedString = $splittedString . $word . '_';
            $i++;
        }

        return strtolower(rtrim($splittedString, '_'));
    }
}

