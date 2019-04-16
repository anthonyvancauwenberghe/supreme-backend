<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 09.03.19
 * Time: 21:51.
 */

namespace Foundation\Core;

use Illuminate\Support\Str;

class Larapi
{
    /**
     * @return Module[]
     */
    public static function getModules(): array
    {
        $modules = [];

        foreach (self::getModuleNames() as $moduleName) {
            $modules[] = self::getModule($moduleName);
        }

        return $modules;
    }

    /**
     * @param string $name
     * @return Module
     * @throws \Foundation\Exceptions\Exception
     */
    public static function getModule(string $name): Module
    {
        $name = Str::studly($name);

        return new Module($name, self::getModulePath($name));
    }

    /**
     * @return string
     */
    public static function getModulesBasePath(): string
    {
        return base_path('src/Modules');
    }

    /**
     * @return string[]
     */
    public static function getModuleNames(): array
    {
        return array_diff(scandir(self::getModulesBasePath()), ['..', '.']);
    }

    /**
     * @param string $module
     * @return string
     */
    private static function getModulePath(string $module): string
    {
        return self::getModulesBasePath().'/'.$module;
    }

    public static function getApiDomainName()
    {
        $apiDomain = str_replace('http://', '', strtolower(env('API_URL')));
        $apiDomain = str_replace('https://', '', $apiDomain);

        return $apiDomain;
    }
}
