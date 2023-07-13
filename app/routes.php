<?php

declare(strict_types=1);

use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require ('/home/gaurav/chatApplication/src/Util/DatabaseConfig.php');

return function (App $app) {
    
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });
    // homepage
    $app->get('/homepage', function (Request $request, Response $response) {
  
        return $response->withRedirect('chat_client.html');               
         
    });

    // setup database tables
    $app->get('/util/db_setup', function (Request $request, Response $response) {
      
        pdo_execute(setup_db_sql());
        echo 'DB tables are now setup.';
        return $response->withStatus(200);
    });
    // chat list of users
    $app->get('/chat_list', function (Request $request, Response $response) {
        // OUT: $messages
        $messages = pdo_execute('SELECT * FROM (SELECT * FROM chat_messages ORDER BY creation_timestamp DESC LIMIT 15) AS res ORDER BY creation_timestamp ASC');
        // - produce HTML output
        // IN: $messages OUT: $output
        $style = $request->getQueryParam('style', false);
        $output = $style?'<link rel="stylesheet" type="text/css" href="chat_client.css">'."\n":'';
        foreach($messages as $message) {
            $sender = htmlspecialchars($message['username']);
            $text = htmlspecialchars($message['message_text']);
            #$text = create_html_links($text);
            $output .= "<div class=\"line\"><em>$sender</em>: $text</div>\n";
        }
        echo $output;
        return $response->withStatus(200);
    });
    function user(){
        @session_start();
        return @$_SESSION["user-tavatar"];
    }
    
    // insert new message
    $app->post('/chat_send', function (Request $request, Response $response) {
        $unparsedBodyJSON = $request->getBody();
        $message = json_decode((string) $unparsedBodyJSON, true);
        $message['username'] = user();
        $allow_anonymous_user = true;
        if(!$allow_anonymous_user && $message['username']=='') {
            return $response->withStatus(401); 
            if($message['username']=='') {
                $message['username'] = 'not authenticated sender user';
            }
            pdo_execute('INSERT INTO messagging.chat_messages (username) VALUES (::username)', $message);
            return $response->withStatus(200);
        }
    });
    
    // show all logged users
    $app->get('/logged_users', function (Request $request, Response $response){
        $sql = pdo_execute('SELECT username FROM chat_messages');
        
        return $response->withStatus(200);
    });
    
    //redirect to login page
    $app->get('/', function (Request $request, Response $response){
        
        return $response->withRedirect('login_page.php');    
      
    });
    // get username from login
    $app->post('/login', function (Request $request, Response $response){
        #$username = $request['username'];
        $data = file_get_contents('php://input');
        print($data);
        pdo_execute('INSERT INTO chat_messages (username) VALUES (:username)', $data["username"]);
        return $response->withStatus(200);
    } );

};
