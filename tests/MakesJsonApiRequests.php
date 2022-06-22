<?php


namespace Tests;


trait MakesJsonApiRequests
{
    /**
     * Call the given URI with a JSON request.
     *
     * @param string $method
     * @param string $uri
     * @param array $data
     * @param array $headers
     * @return \Illuminate\Testing\TestResponse
     */
    public function json($method, $uri, array $data = [], array $headers = [])
    {
        $headers['accept'] = 'application/vnd.api+json';
        return parent::json($method, $uri, $data, $headers);
    }

    /**
     * Visit the given URI with a POST request, expecting a JSON response.
     *
     * @param string $uri
     * @param array $data
     * @param array $headers
     * @return \Illuminate\Testing\TestResponse
     */
    public function postJson($uri, array $data = [], array $headers = [])
    {
        $headers['content-type'] = 'application/vnd.api+json';

        return parent::postJson($uri, $data, $headers);
    }

    public function patchJson($uri, array $data = [], array $headers = [])
    {
        $headers['content-type'] = 'application/vnd.api+json';

        return parent::patchJson($uri, $data, $headers);
    }
}
