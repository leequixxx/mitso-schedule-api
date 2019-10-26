<?php


namespace App\Services\MitsoService\MitsoFacultiesProvider\Fetcher;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use App\Services\MitsoService\MitsoFacultiesProvider\Exceptions\FailedToFetchFacultiesException;

class GuzzleMitsoFacultiesFetcher implements MitsoFacultiesFetcher
{
    private const HTTP_METHOD = 'GET';
    private const FACULTIES_DEFAULT_URI = 'https://www.mitso.by/schedule/search';

    /**
     * @var ClientInterface $client
     */
    private $client;

    /**
     * @var string $uri
     */
    private $uri;

    /**
     * GuzzleMitsoFacultiesFetcher constructor.
     * @param ClientInterface $client guzzle http client, if not provided - default client will be used
     * @param string $uri of page that contains faculties
     */
    public function __construct(ClientInterface $client = null, string $uri = self::FACULTIES_DEFAULT_URI)
    {
        $this->client = $client ?? $this->getDefaultClient();
        $this->uri = $uri;
    }


    /**
     * Fetch faculties available on current or next week in html format.
     * @return string html of faculties
     * @throws FailedToFetchFacultiesException when failed to fetch
     */
    public function fetch(): string
    {
        try {
            $response = $this->client->request(self::HTTP_METHOD, $this->uri);

            return $response->getBody();
        } catch (GuzzleException $e) {
            throw new FailedToFetchFacultiesException($e->getMessage(), $e->getCode(), $e);
        }
    }

    private function getDefaultClient(): ClientInterface
    {
        $client = new Client();

        return $client;
    }
}
