<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;

class ListGroups extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $users = $this->userRepository->listAllGroups();

        $this->logger->info("Groups list was viewed.");

        return $this->respondWithData($users);
    }
}
