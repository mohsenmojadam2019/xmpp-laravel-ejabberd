<?php

namespace App\Http\Controllers;

use Fabiang\Xmpp\Options;
use Fabiang\Xmpp\Client;
use Monolog\Logger;
use Fabiang\Xmpp\Protocol\Roster;
use Fabiang\Xmpp\Protocol\Presence;
use Fabiang\Xmpp\Protocol\Message;
use Monolog\Handler\StreamHandler;


class XmppController extends Controller
{

    public function sendMessage()
    {
        $logger = new Logger('xmpp');
        $logger->pushHandler(new StreamHandler('php://stdout', Logger::DEBUG));

        $hostname = 'localhost';
        $port = 5222;
        $connectionType = 'tcp';
        $address = "$connectionType://$hostname:$port";

        $username = 'admin';
        $password = 'passw0rd';

        $options = new Options($address);
        $options->setLogger($logger)
            ->setUsername($username)
            ->setPassword($password)
            ->setContextOptions([
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,

                ]
            ]);
        $client = new Client($options);

        $client->connect();
        $client->send(new Roster);
        $client->send(new Presence);
        $client->send(new Message);
        dd($client);
        $client->disconnect();


    }

  

}
