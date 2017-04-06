<?php

namespace Aichong;

use GuzzleHttp\Client;

/**
 * Class Consumer
 *
 * @package Aichong
 */
class Consumer
{

    /**
     * Queue host
     *
     * @var string
     */
    private $host;

    /**
     * Project Id
     *
     * @var string
     */
    private $projectId;

    /**
     * cURL option
     *
     * @var array
     */
    private $opt = [];

    public function __construct(string $host, string $projectId, string $consumerId, string $consumerToken)
    {
        $this->host = $host;
        $this->projectId = $projectId;

        $this->opt = [
            'timeout' => 10,
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => $consumerId . ':' . $consumerToken
            ]
        ];
    }

    public function get(string $topic, int $count = 1, int $timeout = 0): \stdClass
    {
        try {

            $client = new Client($this->opt);

            $query = '?count=' . $count;

            if ($timeout > 0) {

                $query .= '&timeout=' . $timeout;
            }

            $response = $client->get($this->host . '/' . $this->projectId . '/' . $topic . '/message' . $query);

            return json_decode($response->getBody()
                                        ->getContents());
        } catch (\Exception $exception) {

            throw new \Exception($exception->getMessage());
        }
    }

    public function ack(string $topic, array $messagesId): \stdClass
    {
        try {

            $client = new Client($this->opt);
            $response = $client->delete($this->host . '/' . $this->projectId . '/' . $topic . '/message',
                ['json' => ['MessageID' => $messagesId]]);

            return json_decode($response->getBody()
                                        ->getContents());
        } catch (\Exception $exception) {

            throw new \Exception($exception->getMessage());
        }
    }
}