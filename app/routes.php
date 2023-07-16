<?php

declare(strict_types=1);

use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use src\Application\Actions\User\UserAction as UserAction;
use Psr\Log\LoggerInterface;
use App\Application\Actions\User\ViewUserAction;
use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\CreateUserGroup;
use App\Application\Actions\User\ChatRequest;
use App\Application\Actions\User\ViewChatList;
use App\Application\Actions\User\ListGroups;
use App\Application\Actions\User\UpdateUser;
use App\Application\Actions\User\AddUser;
use App\Application\Actions\User\AddUserAction;

return function (App $app) {
    
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        
        return $response;
    });
    // homepage
    $app->get('/homepage', function (Request $request, Response $response) {
  
        return $response->withRedirect('chat_client.html');               
         
    });  


    // chat list of users
    
    //redirect to login page
    $app->get('/', function (Request $request, Response $response){
        
        return $response->withRedirect('login_page.php');    
      
    });
    //Add Username 
    $app->post('/login', AddUserAction::class);
    //List All User
    $app->get('/logged_users', ListUsersAction::class);
    //Create New Group
    $app->post('/newgroup', CreateUserGroup::class);
    //Send Message in group
    $app->post('/chatsend', ChatRequest::class);
    //List All Messages in the group
    $app->get('/chatlist', ViewChatList::class);
    //List All Groups
    $app->get('/allgroups', ListGroups::class);
    //Update User with Group
    $app->put('/addgroup', UpdateUser::class);
};
