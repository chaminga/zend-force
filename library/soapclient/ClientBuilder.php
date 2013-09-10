<?php
namespace Salesforce\SoapClient;

use Salesforce\SoapClient\Soap\SoapClientFactory;

/**
 * Salesforce SOAP client builder
 *
 */
class ClientBuilder
{
    /**
     * Construct client builder with required parameters
     *
     * @param string $wsdl     Path to your Salesforce WSDL
     * @param string $username Your Salesforce username
     * @param string $password Your Salesforce password
     * @param string $token    Your Salesforce security token
     */
    public function __construct($wsdl, $username, $password, $token)
    {
        $this->wsdl = $wsdl;
        $this->username = $username;
        $this->password = $password;
        $this->token = $token;
    }

    /**
     * Build the Salesforce SOAP client
     *
     * @return Client
     */
    public function build()
    {
        $soapClientFactory = new SoapClientFactory();
        $soapClient = $soapClientFactory->factory($this->wsdl);

        $client = new Client($soapClient, $this->username, $this->password, $this->token);

        return $client;
    }
}

