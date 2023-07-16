<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ViewChatList extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected Request $request;

    protected Response $response;

    protected function action(): Response
    {
        $unparsedValues = $this->request->getParsedBody();
        $this->logger->info($unparsedValues['groups']);
        $group = $unparsedValues['groups'];
        $messages = $this->userRepository->viewChatList($group);

        $style = $this->request->getQueryParams();
        #$this->logger->info($style['style']);
        $output = $style?'<link rel="stylesheet" type="text/css" href="chat_client.css">'."\n":'';
        foreach($messages as $message) {
            $this->logger->info($message);
            $sender = htmlspecialchars($message['username']);
            $text = htmlspecialchars($message['message_text']);
            #$text = create_html_links($text);
            $output .= "<div class=\"line\"><em>$sender</em>: $text</div>\n";
        }
        echo $output;
        return $this->response->withStatus(200);
    }
}
