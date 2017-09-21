<?php

/**
 * 消息队列 rabbitMQ
 * 需要composer支持php-amqplib
 * @link http://www.rabbitmq.com/
 * @link https://github.com/php-amqplib/php-amqplib
 */
namespace MyApp\Services;


use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Phalcon\DI;

// define('AMQP_DEBUG', true);

class Queue
{

    /**
     * 写入消息队列
     * @param string $queue
     * @param string|array $messageBody
     * @return bool
     */
    public function publish($queue = 'myQueue', $messageBody = '')
    {
        if (!$messageBody) {
            return false;
        }
        $config = DI::getDefault()->get('config')->mq;
        $exchange = 'router'; // direct类型默认交换机
        $connection = new AMQPStreamConnection($config->host, $config->port, $config->username, $config->password,
            $config->vhost);
        $channel = $connection->channel();


        /**
         * name: $queue
         * passive: false
         * durable: true // the queue will survive server restarts
         * exclusive: false // the queue can be accessed in other channels
         * auto_delete: false //the queue won't be deleted once the channel is closed.
         */
        $channel->queue_declare($queue, false, true, false, false);


        /**
         * name: $exchange
         * type: direct
         * passive: false
         * durable: true // the exchange will survive server restarts
         * auto_delete: false //the exchange won't be deleted once the channel is closed.
         */
        $channel->exchange_declare($exchange, 'direct', false, true, false);
        $channel->queue_bind($queue, $exchange);
        if (!is_array($messageBody)) {
            $messageBody = [$messageBody];
        }
        foreach ($messageBody as $msg) {
            $message = new AMQPMessage($msg,
                array('content_type' => 'text/plain', 'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT));
            $channel->basic_publish($message, $exchange);
        }
        $channel->close();
        $connection->close();
        return true;
    }

}