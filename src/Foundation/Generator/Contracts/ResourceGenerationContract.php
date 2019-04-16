<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 12.03.19
 * Time: 15:39
 */

namespace Foundation\Generator\Contracts;


use Foundation\Generator\Support\Stub;

interface ResourceGenerationContract
{
    /**
     * @return string
     */
    public function getFilePath(): string;

    /**
     * @return Stub
     */
    public function getStub(): Stub;

    /**
     * @return string|null
     */
    public function getNamespace(): ?string;

    /**
     * @return string|null
     */
    public function getClassName(): ?string;

    /**
     * @return string|null
     */
    public function getModuleName(): string;
}
