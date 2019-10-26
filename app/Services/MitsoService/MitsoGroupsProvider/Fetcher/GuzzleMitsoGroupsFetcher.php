<?php


namespace App\Services\MitsoService\MitsoGroupsProvider\Fetcher;

use App\Services\MitsoService\MitsoGroupsProvider\Exceptions\FailedToFetchGroupsExceptions;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class GuzzleMitsoGroupsFetcher implements MitsoGroupsFetcher
{
    private const HTTP_METHOD = 'GET';
    private const GROUPS_DEFAULT_URI = 'https://www.mitso.by/schedule_update?type=group_class&kaf=Glavnaya+kafedra&form={study_model}&fak={faculty}&kurse={year}';

    /**
     * @var ClientInterface $client
     */
    private $client;

    /**
     * @var string $uri
     */
    private $uri;

    /**
     * GuzzleMitsoGroupsFetcher constructor.
     * @param ClientInterface $client guzzle http client, if not provided - default client will be used
     * @param string $uri of page that contains groups
     */
    public function __construct(ClientInterface $client = null, string $uri = self::GROUPS_DEFAULT_URI)
    {
        $this->client = $client ?? $this->getDefaultClient();
        $this->uri = $uri;
    }


    /**
     * Fetch groups available on current or next week in html format.
     * @param string $facultyName name of faculty
     * @param string $studyModelName name of study model
     * @param string $yearName name of year
     * @return string html of groups
     * @throws FailedToFetchGroupsExceptions when failed to fetch
     */
    public function fetch(string $facultyName, string $studyModelName, string $yearName): string
    {
        try {
            $uri = $this->uri;
            $uri = str_replace('{faculty}', $facultyName, $uri);
            $uri = str_replace('{study_model}', $studyModelName, $uri);
            $uri = str_replace('{year}', $yearName, $uri);

            $response = $this->client->request(self::HTTP_METHOD, $uri);

            return $response->getBody();
        } catch (GuzzleException $e) {
            throw new FailedToFetchGroupsExceptions($e->getMessage(), $e->getCode(), $e);
        }
    }

    private function getDefaultClient(): ClientInterface
    {
        $client = new Client();

        return $client;
    }
}
