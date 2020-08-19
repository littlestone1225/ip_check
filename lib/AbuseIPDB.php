<?php
use GuzzleHttp\Client;
include_once(dirname(__FILE__) . '/DBconnect.php');
require_once (dirname(__FILE__) . '/../vendor/autoload.php');
Class AbuseIPDB{
    function abuseipdb_download(){
        $client = new GuzzleHttp\Client([
            'base_uri' => BASE_URL
        ]);

        $response = $client->request('GET', 'blacklist', [
            'query' => [
                'limit' => '9999999'
            ],
            'headers' => [
                'Accept' => 'text/plaintext',
                'Key' => MYKEY
            ],

        ]);

        $output = $response->getBody();
        return $output;
    }

    function abuseipdb_check_IP($ip){
        $client = new GuzzleHttp\Client([
            'base_uri' => BASE_URL
        ]);

        $response = $client->request('GET', 'check', [
            'query' => [
                'ipAddress' => $ip,
                'maxAgeInDays' => '90',
            ],
            'headers' => [
                'Accept' => 'application/json',
                'Key' => MYKEY
            ],
        ]);

        $output = $response->getBody();
        // Store response as a PHP object.
        $ipDetails = json_decode($output, true);

        return $ipDetails['data']['abuseConfidenceScore'];
    }

    function abuseipdb_check_CIDR($ip_cidr){
        $client = new GuzzleHttp\Client([
            'base_uri' => BASE_URL
        ]);

        $response = $client->request('GET', 'check-block', [
            'query' => [
                'network' => $ip_cidr,
                'maxAgeInDays' => '15'
            ],
            'headers' => [
                'Accept' => 'application/json',
                'Key' => MYKEY
            ],
        ]);

        $json = $response->getBody();
        $array = json_decode($json,true);

        $ip_list = array();
        foreach ($array['data']['reportedAddress'] as $a){
            array_push($ip_list, [$a['ipAddress'],$a['abuseConfidenceScore']]);
        }

        return $ip_list;
    }


    function abuseipdb_get(){
        $db = new Dbconnect();
        $dbc=$db->connect();
        $rs=$dbc->prepare("SELECT * FROM abuseipdb_blacklist WHERE 1 ORDER BY num ");
        $rs->execute();
        $result = $rs->fetchAll();
        return $result;
    }
    function abuseipdb_update($data){

        $db = new Dbconnect();
        $dbc=$db->connect();
        foreach ($data as $d){
            $rs=$dbc->prepare("INSERT INTO `abuseipdb_blacklist`(`ipAddress`,`abuseConfidenceScore`) VALUES (:ipAddress, :abuseConfidenceScore)");
            $array['ipAddress'] = $d['ipAddress'];
            $array['abuseConfidenceScore'] = $d['abuseConfidenceScore'];
            $result =  $rs->execute($array);
        }
        return $dbc->lastInsertId();
    }
}
?>