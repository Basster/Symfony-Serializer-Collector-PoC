<?php
declare(strict_types=1);

namespace App\Serializer\Normalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Class TraceableHybridNormalizer
 * @package App\Serializer\Normalizer
 */
final class TraceableHybridNormalizer extends AbstractTraceableNormalizer implements NormalizerInterface, DenormalizerInterface
{
}
