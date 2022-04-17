<?php
declare(strict_types=1);

namespace App\Controller\Game;

use App\Request\PlayMoveControllerRequest;
use App\Support\Exception\ApplicationException;
use App\Support\Response\Contract\AppResponder;
use App\UseCase\PlayMove;
use Assert\LazyAssertionException;
use Psr\Log\LoggerInterface;

class PlayMoveController
{
    private PlayMove $playMove;
    private AppResponder $appResponder;
    private LoggerInterface $logger;

    public function __construct(
        PlayMove $playMove,
        LoggerInterface $logger,
        AppResponder $appResponder
    ) {
        $this->playMove = $playMove;
        $this->logger = $logger;
        $this->appResponder = $appResponder;
    }

    public function __invoke(PlayMoveControllerRequest $request) {
        try{
            $playMove = $request->getData();
        }catch(\Throwable $e) {
            return $this->appResponder->respondClientError([$e->getMessage()]);
        }

        try{
            $response = $this->playMove->execute($playMove);

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