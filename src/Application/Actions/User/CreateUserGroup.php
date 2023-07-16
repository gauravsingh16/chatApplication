<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
class CreateUserGroup extends UserAction {
        /**
         * {@inheritdoc}
         */
        protected $user;
        protected Request $request;
       
    
        protected function action(): Response
        {   $unparsedValues = $this->request->getParsedBody();
            $this->logger->info($unparsedValues['username']);
            $username = $unparsedValues['username'];
            $group = $unparsedValues['groups'];
            $value = $this->userRepository->createGroup($username, $group);
            $this->logger->info("added username");
    
            return $this->respondwithData($username);
        }
    
    }
