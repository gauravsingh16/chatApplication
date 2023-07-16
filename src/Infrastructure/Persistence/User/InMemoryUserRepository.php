<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\User;

use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;
use PDO;
use src\Util\DatabaseConfig;
use Psr\Log\LoggerInterface;

class InMemoryUserRepository implements UserRepository
{
    /**
     * @var User[]
     * 
     */

    /**
     * @param User[]|null $users
     * 
     */

    
    protected LoggerInterface $logger;
    public function __construct(LoggerInterface $logger)
    {
       $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */

    
    //Execute all query and called in routes for direct query passing.
    public function pdo_execute($sql, $params = []) {
        global $pdo;
        print "this is sql $sql";
        $stat = $pdo->prepare($sql);
        assert($stat);
        $res = $stat->execute($params);
        
        assert($res);
        return $stat;
    }
    public function findAll(): array
    {   global $pdo;
        $users = $this->pdo_execute('SELECT username FROM chat_messages');
        $res = $users->fetchAll(PDO::FETCH_OBJ);
        #assert($res);
        return array_values($res);
    }

    /**
     * {@inheritdoc}
     */
    

    public function addUsername(string $username): bool{
       
            $usernames = array($username);
              $this->pdo_execute('INSERT INTO chat_messages (username) VALUES (:username)', $usernames);
              $this->logger->info("Added User of username '$username' in table");
              return true;
    }
    public function addGroupToUsername(string $username, string $group): bool{
        $usernames = array( $group, $username);
        $this->pdo_execute('UPDATE chat_messages SET (groups) WHERE (username)', $usernames);
        $this->logger->info("Added User");
        return true;
        }
        
        public function listAllGroups(): array
        { global $pdo;
        $users = $this->pdo_execute('SELECT group_name FROM user_group');
        $res = $users->fetchAll(PDO::FETCH_OBJ);
        #assert($res);
        return array_values($res);
        }
        public function createGroup(string $username , string $group): bool{
        $usernames = array($username, $group);
        $this->pdo_execute('INSERT INTO user_group (username, group_name) VALUES (:username, :group)', $usernames);
        $this->logger->info("Added User of username '$username' in table ");
        return true;
        }

        public function sendMessage(string $username , string $group, string $message): bool{
            $usernames = array($username, $group, $message);
            $this->pdo_execute('INSERT INTO user_group (message_text) WHERE (username, group_name) VALUES (:username, :group, :message_text)', $usernames);
            $this->logger->info("Added message in text ");
            return true;
        }

        public function viewChatList(string $group):array{
            $group = array($group);
            $messages = $this->pdo_execute('SELECT * FROM (SELECT (username, message_text) FROM user_group WHERE (group_name) ORDER BY creation_timestamp DESC LIMIT 15) AS res ORDER BY creation_timestamp ASC', $group);
            $res = $messages->fetchAll(PDO::FETCH_OBJ);
            $this->logger->info("List Array chat ");
            return $res;
        }
}
