<?php
declare(strict_types=1);

namespace RunAsRoot\CliConstructorArgAutoProxy\Validator;

use RunAsRoot\CliConstructorArgAutoProxy\Enum\ProxyClassEntityInterfaceEnum;
use RunAsRoot\CliConstructorArgAutoProxy\Exception\ClassIsNotEligibleForProxyException;

class IsClassEligibleForProxyValidator
{
    /**
     * @param class-string|string|null $className
     *
     * @throws ClassIsNotEligibleForProxyException
     */
    public function validate(?string $className): void
    {
        if ($className === '' || $className === null) {
            throw new ClassIsNotEligibleForProxyException('Class name is empty');
        }

        /** @var class-string $className */
        if (strpos($className, ProxyClassEntityInterfaceEnum::PROXY_CLASS_SUFFIX) > 0) {
            throw new ClassIsNotEligibleForProxyException('Class is already a Proxy');
        }

        /** @var class-string $proxyClassName */
        $proxyClassName = $className . ProxyClassEntityInterfaceEnum::PROXY_CLASS_SUFFIX;

        // skipp - in case Proxy exists and is not a child of original class
        if (!is_a($proxyClassName, $className, true)) {
            throw new ClassIsNotEligibleForProxyException(
                'Proxy already exists and is not a child of original class: ' . $className
            );
        }
    }
}
