<?php
declare(strict_types=1);

namespace App\Controller\Game;

use App\Request\CreateGameControllerRequest;
use App\Support\Exception\ApplicationException;
use App\Support\Response\AppJsonResponder;
use App\UseCase\CreateGame;
use Assert\LazyAssertionException;
use Psr\Log\LoggerInterface;

class CreateGameController
{
    private CreateGame $createGame;
    private LoggerInterface $logger;
    private AppJsonResponder $appResponder;

    public function __construct(
        CreateGame $createGame,
        AppJsonResponder $appResponder,
        LoggerInterface $logger
    ) {
        $this->createGame = $createGame;
        $this->logger = $logger;
        $this->appResponder = $appResponder;
    }

    public function __invoke(CreateGameControllerRequest $request) {
        try{
            $createGameData = $request->getData();
        }catch(\Throwable $e) {
            return $this->appResponder->respondClientError([$e->getMessage()]);
        }

        try{
            $response = $this->createGame->execute($createGameData);

        } catch (ApplicationException $e) {
            return $this->appResponder->respondClientError(
                [$e->getMessage()]
            );
        } catch (\Throwable $e) {
            $this->logger->error('Server Error:' . $e->getMessage());

            return $this->appResponder->respondClientError(
                [$e->getMessage()]
            );
        }

        return $this->appResponder->respondWithSuccess($response->getData());
    }
}