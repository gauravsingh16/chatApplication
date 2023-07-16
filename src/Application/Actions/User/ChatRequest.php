<?php

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
class ChatRequest extends UserAction {
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
            $message = $unparsedValues['message_text'];
            $value = $this->userRepository->sendMessage($username, $group, $message);
            $this->logger->info("added chats");
    
            return $this->respondwithData($username);
        }
    
    }