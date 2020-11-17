<?php
declare(strict_types=1);

namespace App\DependencyInjection;

use App\Serializer\Normalizer\TraceableDenormalizer;
use App\Serializer\Normalizer\TraceableHybridNormalizer;
use App\Serializer\Normalizer\TraceableNormalizer;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Class SerializerDebugPass
 * @package App\DependencyInjection
 */
final class SerializerDebugPass implements CompilerPassInterface
{
    /**
     * @throws ReflectionException
     */
    public function process(ContainerBuilder $container): void
    {
        foreach ($container->findTaggedServiceIds('serializer.normalizer') as $id => $tags) {
            $this->decorateNormalizer($id, $container);
        }
    }

    /**
     * @throws ReflectionException
     */
    private function decorateNormalizer(string $id, ContainerBuilder $container): void
    {
        $aliasName = 'debug.' . $id;

        $normalizerDef = $container->getDefinition($id);
        $normalizerRef = new ReflectionClass($normalizerDef->getClass());
        $isNormalizer = $normalizerRef->implementsInterface(NormalizerInterface::class);
        $isDenormalizer = $normalizerRef->implementsInterface(DenormalizerInterface::class);

        /*
         * We must decorate each type of normalizer with a specific decorator, since the serializer behaves
         * differently depending of instanceof checks against the used normalizer.
         * Therefore we cannot decorate all normalizers equally.
         */
        if ($isNormalizer && $isDenormalizer) {
            $decoratorClass = TraceableHybridNormalizer::class;
        } elseif ($isNormalizer) {
            $decoratorClass = TraceableNormalizer::class;
        } elseif ($isDenormalizer) {
            $decoratorClass = TraceableDenormalizer::class;
        } else {
            throw new RuntimeException(
                sprintf("Normalizer with id %s neither implements NormalizerInterface nor DenormalizerInterface!", $id)
            );
        }

        $decoratorDef = (new Definition($decoratorClass))
            ->setArguments([$normalizerDef])
            ->addTag('debug.normalizer')
            ->setDecoratedService($id)
            ->setAutowired(true)
            ->setAutoconfigured(true);

        $container->setDefinition($aliasName, $decoratorDef);
    }
}
