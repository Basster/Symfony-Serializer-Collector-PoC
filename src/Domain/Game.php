<?php
declare(strict_types=1);

namespace App\Domain;
/**
 * Class Game
 * @package App\Domain
 */
final class Game
{
    private string $name;

    private float $price = 0.0;

    private ?Genre $genre = null;

    /**
     * Game constructor.
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

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return Game
     */
    public function setPrice(float $price): Game
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return Genre|null
     */
    public function getGenre(): ?Genre
    {
        return $this->genre;
    }

    /**
     * @param Genre|null $genre
     * @return Game
     */
    public function setGenre(?Genre $genre): Game
    {
        $this->genre = $genre;
        return $this;
    }
}
