<?php
declare(strict_types=1);

namespace App\Domain;
/**
 * Class Genre
 * @package App\Domain
 */
final class Genre
{
    private string $name;

    /**
     * Genre constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

}
