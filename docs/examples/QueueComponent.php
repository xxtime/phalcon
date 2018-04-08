<?php

/**
 * 消息队列 rabbitMQ
 * 需要composer支持php-amqplib
 * @link http://www.rabbitmq.com/
 * @link https://github.com/php-amqplib/php-amqplib
 */
namespace App\Providers\Components;


use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Phalcon\DI;

// define('AMQP_DEBUG', true);

class QueueComponent
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
        $cfg = DI::getDefault()->get('config')->mq;
        $exchange = 'router';   // direct类型默认交换机
        $connection = new AMQPStreamConnection($cfg->host, $cfg->port, $cfg->user, $cfg->pass, $cfg->vhost);
        $channel = $connection->channel();


        /**
         * 声明一个队列
         * name: $queue
         * passive: false
         * durable: true        // the queue will survive server restarts
         * exclusive: false     // the queue can be accessed in other channels
         * auto_delete: false   //the queue won't be deleted once the channel is closed.
         */
        $channel->queue_declare($queue, false, true, false, false);


        /**
         * 声明一个交换器
         * name: $exchange
         * type: direct
         * passive: false
         * durable: true        // the exchange will survive server restarts
         * auto_delete: false   //the exchange won't be deleted once the channel is closed.
         */
        $channel->exchange_declare($exchange, 'direct', false, true, false);


        /**
         * 绑定队列到交换器
         * @param string $queue
         * @param string $exchange
         * @param string $routing_key
         * @param bool $nowait
         * @param array $arguments
         * @param int $ticket
         * @return mixed|null
         */
        $channel->queue_bind($queue, $exchange);


        // 准备发布消息
        if (!is_array($messageBody)) {
            $messageBody = [$messageBody];
        }
        foreach ($messageBody as $msg) {
            // 定义消息
            $message = new AMQPMessage(
                $msg,
                array(
                    'content_type'  => 'text/plain',
                    'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
                )
            );
            /**
             * 发布消息
             * @param AMQPMessage $msg
             * @param string $exchange
             * @param string $routing_key
             * @param bool $mandatory
             * @param bool $immediate
             * @param int $ticket
             */
            $channel->basic_publish($message, $exchange);
        }

        $channel->close();
        $connection->close();
        return true;
    }

}