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
     * @throws \RuntimeException
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
            throw new \RuntimeException(sprintf('Unable to login to Opensubtitles, because "%s"', $e->getMessage()));
        }
        return false;
    }

    /**
     * @param $hash
     * @param $fileSize
     * @return array
     * @throws \RuntimeException
     */
    public function searchSubtitlesByHash($hash, $fileSize)
    {
        try {
            $response = $this->rpcClient->call('SearchSubtitles', [
                $this->token,
                [
                    [
                        'sublanguageid' => 'eng',
                        'moviehash' =>  $hash,
                        'moviebytesize' => $fileSize
                    ]
                ]
            ]);
            return $response;
        } catch (\Exception $e) {
            throw new \RuntimeException(sprintf(
                'Unable to search for subtitles on Opensubtitles, because "%s"',
                $e->getMessage()
            ));
        }
    }
}
