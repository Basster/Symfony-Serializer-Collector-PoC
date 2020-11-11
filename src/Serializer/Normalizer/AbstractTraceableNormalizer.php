<?php
declare(strict_types=1);

namespace App\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class AbstractTraceableNormalizer
 * @package App\Serializer\Normalizer
 */
abstract class AbstractTraceableNormalizer implements SerializerAwareInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    private array $normalizations = [];
    private array $denormalizations = [];

    /**
     * @var DenormalizerInterface|NormalizerInterface
     */
    protected $delegate;

    /**
     * AbstractTraceableNormalizer constructor.
     * @param DenormalizerInterface|NormalizerInterface $delegate
     */
    public function __construct($delegate)
    {
        $this->delegate = $delegate;
    }

    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        return $this->delegate->denormalize($data, $type, $format, $context);
    }

    public function supportsDenormalization($data, string $type, string $format = null)
    {
        return $this->delegate->supportsDenormalization($data, $type, $format);
    }

    public function normalize($object, string $format = null, array $context = [])
    {
        $result = $this->delegate->normalize($object, $format, $context);

        $this->normalizations[] = new Normalization($this->delegate, $object, $format, $context);

        return $result;
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $this->delegate->supportsNormalization($data, $format);
    }

    /*
     * Since the Serializer, in its constructor, injects itself into its normalizers,
     * depending on the implementing interfaces, we need to mimic this behaviour here
     * and pass them to the delegate.
     *
     * Unfortunately this is heavily bound to the Serializer implementation. :(
     * @see Symfony\Component\Serializer\Serializer:77
     */

    public function setSerializer(SerializerInterface $serializer): void
    {
        if ($this->delegate instanceof SerializerAwareInterface) {
            $this->delegate->setSerializer($serializer);
        }
    }

    public function setDenormalizer(DenormalizerInterface $denormalizer): void
    {
        if ($this->delegate instanceof DenormalizerAwareInterface) {
            $this->delegate->setDenormalizer($denormalizer);
        }
    }

    public function setNormalizer(NormalizerInterface $normalizer): void
    {
        if ($this->delegate instanceof NormalizerAwareInterface) {
            $this->delegate->setNormalizer($normalizer);
        }
    }

    /**
     * @return array
     */
    public function getNormalizations(): array
    {
        return $this->normalizations;
    }

    /**
     * @return array
     */
    public function getDenormalizations(): array
    {
        return $this->denormalizations;
    }
}
