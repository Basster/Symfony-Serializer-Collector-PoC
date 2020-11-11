<?php
declare(strict_types=1);

namespace App\Serializer\Normalizer;
use App\Serializer\Serialization;
use App\Serializer\SerializerAction;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Class Normalization
 * @package App\Serializer\Normalizer
 */
final class Normalization extends Serialization
{
    public NormalizerInterface $normalizer;

    public function __construct(NormalizerInterface $normalizer, $data, string $format, array $context = [])
    {
        parent::__construct($data, $format, $context);
        $this->normalizer = $normalizer;
    }

}
