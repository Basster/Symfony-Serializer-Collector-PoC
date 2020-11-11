<?php
declare(strict_types=1);

namespace App\DependencyInjection;

use App\Serializer\Normalizer\TraceableDenormalizer;
use App\Serializer\Normalizer\TraceableHybridNormalizer;
use App\Serializer\Normalizer\TraceableNormalizer;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;

/**
 * Class SerializerDebugPass
 * @package App\DependencyInjection
 */
final class SerializerDebugPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        foreach ($container->findTaggedServiceIds('serializer.normalizer') as $id => $tags) {
            $aliasName = 'debug.' . $id;

            $normalizerDef = $container->getDefinition($id);
            $normalizerRef = new \ReflectionClass($normalizerDef->getClass());
            $isNormalizer = $normalizerRef->implementsInterface(NormalizerInterface::class);
            $isDenormalizer = $normalizerRef->implementsInterface(DenormalizerInterface::class);

            if ($isNormalizer && $isDenormalizer) {
                $decoratorClass = TraceableHybridNormalizer::class;
            }
            elseif ($isNormalizer) {
                $decoratorClass = TraceableNormalizer::class;
            }
            elseif ($isDenormalizer) {
                $decoratorClass = TraceableDenormalizer::class;
            }
            else {
                throw new RuntimeException(
                    sprintf("Normalizer with id %s neither implements NormalizerInterface nor DenormalizerInterface!", $id)
                );
            }

            $decoratorDef = (new Definition($decoratorClass))
                ->setArguments([$normalizerDef])
                ->addTag('debug.normalizer')
                ->setDecoratedService($id)
                ->setAutowired(true)
                ->setAutoconfigured(true)
            ;

            $container->setDefinition($aliasName, $decoratorDef);
        }

    }
}
