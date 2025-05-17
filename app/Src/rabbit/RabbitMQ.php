<?php

namespace App\Src\rabbit;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQ
{
    private $connection;
    private $queue_name;
    private $channel;


    public function __construct($queue_name)
    {
        $this->connection = new AMQPStreamConnection(
            config('queue.connections.rabbitmq.host'),
            config('queue.connections.rabbitmq.port'),
            config('queue.connections.rabbitmq.user'),
            config('queue.connections.rabbitmq.password'),
            config('queue.connections.rabbitmq.vhost')
        );
        $this->channel = $this->connection->channel();
        $this->queue_name = $queue_name;
        $this->addQueue();
    }

    private function addQueue()
    {
        $this->channel->queue_declare(
            $this->queue_name,
            false,
            true,
            false,
            false
        );
    }

    /**
     *  Добавляет в очередь
     */
    public function appendQueue(array $data)
    {
        $message = new AMQPMessage(
            json_encode($data),
            [
                'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
            ]
        );
        $this->channel->basic_publish($message, '', $this->queue_name);
    }

    /**
     *  Берет из очереди
     */
    public function getQueue()
    {
        $data = $this->channel->basic_get($this->queue_name, false);
        if ($data) {
            $this->channel->basic_ack($data->getDeliveryTag());
            return json_decode($data->body, 1);
        }
        return false;
    }
    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
