<?php


namespace App\Services\MitsoService\MitsoYearsProvider\Fetcher;

use App\Services\MitsoService\MitsoYearsProvider\Exceptions\FailedToFetchYearsException;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class GuzzleMitsoYearsFetcher implements MitsoYearsFetcher
{
    private const HTTP_METHOD = 'GET';
    private const YEARS_DEFAULT_URI = 'https://mitso.by/schedule_update?type=kurse&kaf=Glavnaya+kafedra&form={study_model}&fak={faculty}';

    /**
     * @var ClientInterface $client
     */
    private $client;

    /**
     * @var string $uri
     */
    private $uri;

    /**
     * GuzzleMitsoYearsFetcher constructor.
     * @param ClientInterface $client guzzle http client, if not provided - default client will be used
     * @param string $uri of page that contains years
     */
    public function __construct(ClientInterface $client = null, string $uri = self::YEARS_DEFAULT_URI)
    {
        $this->client = $client ?? $this->getDefaultClient();
        $this->uri = $uri;
    }

    /**
     * Fetch years available on current or next week in html format.
     * @param string $facultyName name of faculty
     * @param string $studyModelName name of study model
     * @return string html of years
     * @throws FailedToFetchYearsException when failed to fetch
     */
    public function fetch(string $facultyName, string $studyModelName): string
    {
        try {
            $uri = $this->uri;
            $uri = str_replace('{faculty}', $facultyName, $uri);
            $uri = str_replace('{study_model}', $studyModelName, $uri);

            $response = $this->client->request(self::HTTP_METHOD, $uri);

            return $response->getBody();
        } catch (GuzzleException $e) {
            throw new FailedToFetchYearsException($e->getMessage(), $e->getCode(), $e);
        }
    }

    private function getDefaultClient(): ClientInterface
    {
        $client = new Client();

        return $client;
    }
}
