<?php
declare(strict_types=1);

namespace App\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Class TraceableNormalizer
 * @package App\Serializer\Normalizer
 */
final class TraceableNormalizer extends AbstractTraceableNormalizer implements NormalizerInterface
{
}
