<?php
declare(strict_types=1);

namespace App\Serializer;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Service\ResetInterface;

/**
 * Class TraceableSerializer
 * @package App\Serializer
 */
final class TraceableSerializer implements SerializerInterface, ResetInterface
{
    private array $serializations = [];
    private array $deserializations = [];
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $delegate;

    public function __construct(SerializerInterface $delegate)
    {
        $this->delegate = $delegate;
    }

    public function serialize($data, string $format, array $context = []): string
    {
        $serialization = new Serialization($data, $format, $context);
        $serialization->result = $this->delegate->serialize($data, $format, $context);
        $this->serializations[] = $serialization;

        return $serialization->result;
    }

    public function deserialize($data, string $type, string $format, array $context = [])
    {
        $deserialization = new Deserialization($data, $type, $format, $context);
        $deserialization->result = $this->delegate->deserialize($data, $type, $format, $context);
        $this->deserializations[] = $deserialization;

        return $deserialization->result;
    }

    /**
     * @return array|Serialization[]
     */
    public function getSerializations(): array
    {
        return $this->serializations;
    }

    /**
     * @return array|Deserialization[]
     */
    public function getDeserializations(): array
    {
        return $this->deserializations;
    }

    public function reset()
    {
        // TODO: Implement reset() method.
    }
}
