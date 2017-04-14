<?php

namespace SubtitleProviders\OpenSubtitles;

use fXmlRpc\Client as RpcClient;

class Client
{
    /**
     * @var RpcClient
     */
    private $rpcClient;
    /**
     * @var string
     */
    private $token;

    /**
     * Client constructor.
     * @param RpcClient $rpcClient
     */
    public function __construct(RpcClient $rpcClient)
    {
        $this->rpcClient = $rpcClient;
    }

    /**
     * @param string $username
     * @param string $password
     * @param string $userAgent
     * @return bool
     * @throws \Exception
     */
    public function login($username, $password, $userAgent)
    {
        try {
            $response = $this->rpcClient->call('LogIn', [
                'username' => $username,
                'password' => $password,
                'language' => 'eng',
                'useragent' => $userAgent
            ]);
            if (isset($response['token'])) {
                $this->token = $response['token'];
                return true;
            }
        } catch (\Exception $e) {
            throw $e;
        }
        return false;
    }

    /**
     * @param $hash
     * @param $fileSize
     * @return array
     * @throws \Exception
     */
    public function searchSubtitlesByHash($hash, $fileSize)
    {
        try {
            $response = $this->rpcClient->call('SearchSubtitles', [
                $this->token,
                [
                    [
                        'sublanguageid' => 'eng',
                        'moviehash' => $hash,
                        'moviebytesize' => $fileSize
                    ]
                ]
            ]);
            return $response;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
