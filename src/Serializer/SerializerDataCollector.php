<?php
declare(strict_types=1);

namespace App\Serializer;

use App\Serializer\Normalizer\AbstractTraceableNormalizer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Service\ResetInterface;

/**
 * Class NormalizerCollector
 * @package App\Serializer
 */
final class SerializerDataCollector extends DataCollector
{
    private ?SerializerInterface $serializer;
    /**
     * @var array|iterable
     */
    private $normalizers;

    public function __construct(SerializerInterface $serializer = null, iterable $normalizers = [])
    {
        $this->serializer = $serializer;
        $this->normalizers = $normalizers;
    }

    public function collect(Request $request, Response $response, \Throwable $exception = null): void
    {
        $this->data = [
            'serializations' => [],
            'deserializations' => [],
            'normalizations' => [],
            'denormalizations' => [],
        ];

        if ($this->serializer instanceof TraceableSerializer) {
            $this->data['serializations'] = $this->serializer->getSerializations();
            $this->data['deserializations'] = $this->serializer->getDeserializations();
        }

        foreach ($this->normalizers as $normalizer) {
            if ($normalizer instanceof AbstractTraceableNormalizer) {
                foreach ($normalizer->getNormalizations() as $denormalization) {
                    $this->data['normalizations'][] = $denormalization;
                }
                foreach ($normalizer->getDenormalizations() as $denormalization) {
                    $this->data['denormalizations'][] = $denormalization;
                }
            }
        }

        $this->data = $this->cloneVar($this->data);
    }

    public function getName(): string
    {
        return 'serializer.data_collector';
    }

    public function reset(): void
    {
        $this->data = [];

        if ($this->serializer instanceof ResetInterface) {
            $this->serializer->reset();
        }
    }

    public function getSerializations()
    {
        return $this->data['serializations'];
    }

    public function getDeserializations()
    {
        return $this->data['deserializations'];
    }

    public function getNormalizations()
    {
        return $this->data['normalizations'];
    }

    public function getDenormalizations()
    {
        return $this->data['denormalizations'];
    }
}
