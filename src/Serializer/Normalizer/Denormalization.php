<?php
declare(strict_types=1);

namespace App\Serializer\Normalizer;

use App\Serializer\Deserialization;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * Class Denormalization
 * @package App\Serializer\Normalizer
 */
final class Denormalization extends Deserialization
{
    public DenormalizerInterface $denormalizer;

    public function __construct(DenormalizerInterface $denormalizer, $data, string $type, string $format, array $context = [])
    {
        parent::__construct($data, $type, $format, $context);
        $this->denormalizer = $denormalizer;
    }
}
