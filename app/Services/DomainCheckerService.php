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
        $domains = Domain::where('verified', 0)->limit(10)->get();
//
//        echo "<pre>";
//        print_r($domains);
//        echo "</pre>";
//        die;
        $i = 0;
        foreach ($domains as $domain) {
            if ($this->checkHost($domain->domain)) {
                $this->verifyDoain($domain, $domain->domain);
            }
            $i++;
            if($i > 1){
                continue;
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
        } catch (ConnectException $e) {
            return false;
        } catch (ClientException $e){
            return false;
        }
    }

    private
    function verifyDoain($domain, $url)
    {
        //$domain->domain =$url;
        $domain->verified = 1;
        $domain->save();
    }
}
