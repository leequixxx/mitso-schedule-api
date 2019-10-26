<?php


namespace App\Services\MitsoService\MitsoStudyModelsProvider\Fetcher;

use App\Services\MitsoService\MitsoStudyModelsProvider\Exceptions\FailedToFetchStudyModelsException;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use App\Services\MitsoService\MitsoFacultiesProvider\MitsoFaculty;

class GuzzleMitsoStudyModelsFetcher implements MitsoStudyModelsFetcher
{
    private const HTTP_METHOD = 'GET';
    private const STUDY_MODELS_DEFAULT_URI = 'https://www.mitso.by/schedule_update?type=form&kaf=Glavnaya+kafedra&fak={faculty}';

    /**
     * @var ClientInterface $client
     */
    private $client;

    /**
     * @var string $uri
     */
    private $uri;

    /**
     * GuzzleMitsoStudyModelsFetcher constructor.
     * @param ClientInterface $client guzzle http client, if not provided - default client will be used
     * @param string $uri of page that contains study models
     */
    public function __construct(ClientInterface $client = null, string $uri = self::STUDY_MODELS_DEFAULT_URI)
    {
        $this->client = $client ?? $this->getDefaultClient();
        $this->uri = $uri;
    }


    /**
     * Fetch study models available on current or next week in html format.
     * @param string $facultyName name of faculty
     * @return string html of study models
     * @throws FailedToFetchStudyModelsException when failed to fetch
     */
    public function fetch(string $facultyName): string
    {
        try {
            $uri = $this->uri;
            $uri = str_replace('{faculty}', $facultyName, $uri);

            $response = $this->client->request(self::HTTP_METHOD, $uri);

            return $response->getBody();
        } catch (GuzzleException $e) {
            throw new FailedToFetchStudyModelsException($e->getMessage(), $e->getCode(), $e);
        }
    }

    private function getDefaultClient(): ClientInterface
    {
        $client = new Client();

        return $client;
    }
}
