<?php
declare(strict_types=1);

namespace App\Serializer;
/**
 * Class SerializerAction
 * @package App\Serializer
 */
abstract class SerializerAction
{
    /**
     * @var mixed
     */
    public $data;
    public string $format;
    public array $context;
    /**
     * @var mixed
     */
    public $result;

    public function __construct($data, string $format, array $context = [])
    {
        $this->data = $data;
        $this->format = $format;
        $this->context = $context;
    }
}
