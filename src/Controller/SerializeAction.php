<?php
declare(strict_types=1);

namespace App\Controller;
use App\Domain\Game;
use App\Domain\Genre;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class TestAction
 * @package App\Controller
 */
final class SerializeAction
{
    /**
     * @Route("/", name="serialize")
     */
    public function __invoke(SerializerInterface $serializer)
    {
        $game = new Game('World of Warcraft');
        $game->setPrice(39.99);
        $game->setGenre(new Genre('MMORPG'));

        $newGame = $serializer->deserialize(
            '{"name":"3d Chess","price":125.99,"genre":{"name":"Strategy"}}',
            Game::class,
            'json'
        );

        return JsonResponse::fromJsonString(
            $serializer->serialize($game, 'json')
        );
    }
}
