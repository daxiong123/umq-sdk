<?php
/**
 * QueueTest.php
 *
 * @author     zhangweijian
 * @copyright  Copyright (c) 2015 Shanghai PZP Network Technology Co.,Ltd
 * @version    2017.04.04 18:18
 */

namespace Aichong\tests;

use Aichong\Consumer;
use Aichong\Producer;

class QueueTest extends TestCase
{

    private $messageId = '';

    /**
     */
    public function testPublish()
    {
        $producer = new Producer('http://bj2.mq.ucloud.cn', 'org-31335', 'PID_5ca2cc63-014e-448e-a5a0-644397c3090a',
            '22bf64a6b2cefd43c0b6f796e4729d5d');

        $ret = $producer->publish('phpunit', 'test');

        $this->assertObjectHasAttribute('MessageID', $ret);

        $this->messageId = $ret->MessageID;
    }

    /**
     * @depends testPublish
     */
    public function testGet()
    {
        $consumer = new Consumer('http://bj2.mq.ucloud.cn', 'org-31335', 'CID_6e96ad4b-4298-4264-8c6b-c96d113c40a1',
            '7228be7f0bbe49b1f1ea798bd786e928');

        $list = $consumer->get('phpunit', 20);

        $this->assertObjectHasAttribute('count', $list);

        $messagesId = [];

        foreach ($list->messages as $val) {

            $messagesId[] = $val->messageID;
        }

        $this->assertObjectHasAttribute('FailMessageID', $consumer->ack('phpunit', $messagesId));
    }
}
