<?php

namespace Aichong;

use GuzzleHttp\Client;

/**
 * Class Producer
 *
 * @package Aichong
 */
class Producer
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
     * Producer Id
     *
     * @var string
     */
    private $producerId;

    /**
     * Producer Token
     *
     * @var string
     */
    private $producerToken;

    public function __construct(string $host, string $projectId, string $producerId, string $producerToken)
    {
        $this->host = $host;
        $this->projectId = $projectId;
        $this->producerId = $producerId;
        $this->producerToken = $producerToken;
    }

    /**
     * Post messages queue
     *
     * @param string $topic
     * @param string $content
     * @return \stdClass
     * @throws \Exception
     */
    public function publish(string $topic, string $content): \stdClass
    {
        try {

            $client = new Client([
                'timeout' => 10,
                'headers' => [
                    'Content-Type' => 'text/plain',
                    'Authorization' => $this->producerId . ':' . $this->producerToken
                ]
            ]);
            $response = $client->post($this->host . '/' . $this->projectId . '/' . $topic . '/message',
                ['body' => $content]);

            return json_decode($response->getBody()
                                        ->getContents());
        } catch (\Exception $exception) {

            throw new \Exception($exception->getMessage());
        }
    }
}