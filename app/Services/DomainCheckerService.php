<?php

namespace App\Services;

use App\Models\DomainsRedirects\Domain;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;

class DomainCheckerService
{
    private $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client();
    }

    public function check()
    {
        $domains = Domain::where('verified', 0)->get();


        foreach ($domains as $domain) {
            if ($this->checkHost($domain->domain)) {
                $this->verifyDomain($domain);
            }
        }
    }

    private function checkHost(string $url): bool
    {

        try {
            $response = $this->httpClient->request('GET', $url, ['connect_timeout' => 2]);

            if ($response->getStatusCode() == 200) {
                return true;
            }
            return false;
        } catch (\Exception $e) {
            return false;
        }
    }

    private function verifyDomain($domain)
    {
        $domain->verified = 1;
        $domain->save();
    }
}
