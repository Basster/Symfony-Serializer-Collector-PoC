<?php
declare(strict_types=1);

namespace App\Serializer;
/**
 * Class Deserialization
 * @package App\Serializer
 */
class Deserialization extends SerializerAction
{
    public string $type;

    public function __construct($data, string $type, string $format, array $context = [])
    {
        parent::__construct($data, $format, $context);
        $this->type = $type;
    }
}
