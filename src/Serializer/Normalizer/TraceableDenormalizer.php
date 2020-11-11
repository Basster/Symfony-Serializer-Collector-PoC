<?php
declare(strict_types=1);

namespace App\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * Class TraceableDenormalizer
 * @package App\Serializer\Normalizer
 */
final class TraceableDenormalizer extends AbstractTraceableNormalizer implements DenormalizerInterface
{
}
