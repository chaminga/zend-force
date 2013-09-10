<?php
namespace Salesforce\SoapClient\Soap;

use Salesforce\SoapClient\Soap\TypeConverter;

/**
 * Factory to create a \SoapClient properly configured for the Salesforce SOAP
 * client
 */
class SoapClientFactory
{
    /**
     * Default classmap
     *
     * @var array
     */
    protected $classmap = array(
        'ChildRelationship'     => 'Salesforce\SoapClient\Result\ChildRelationship',
        'DeleteResult'          => 'Salesforce\SoapClient\Result\DeleteResult',
        'DeletedRecord'         => 'Salesforce\SoapClient\Result\DeletedRecord',
        'DescribeGlobalResult'  => 'Salesforce\SoapClient\Result\DescribeGlobalResult',
        'DescribeGlobalSObjectResult' => 'Salesforce\SoapClient\Result\DescribeGlobalSObjectResult',
        'DescribeSObjectResult' => 'Salesforce\SoapClient\Result\DescribeSObjectResult',
        'DescribeTab'           => 'Salesforce\SoapClient\Result\DescribeTab',
        'EmptyRecycleBinResult' => 'Salesforce\SoapClient\Result\EmptyRecycleBinResult',
        'Error'                 => 'Salesforce\SoapClient\Result\Error',
        'Field'                 => 'Salesforce\SoapClient\Result\DescribeSObjectResult\Field',
        'GetDeletedResult'      => 'Salesforce\SoapClient\Result\GetDeletedResult',
        'GetServerTimestampResult' => 'Salesforce\SoapClient\Result\GetServerTimestampResult',
        'GetUpdatedResult'      => 'Salesforce\SoapClient\Result\GetUpdatedResult',
        'GetUserInfoResult'     => 'Salesforce\SoapClient\Result\GetUserInfoResult',
        'LeadConvert'           => 'Salesforce\SoapClient\Request\LeadConvert',
        'LeadConvertResult'     => 'Salesforce\SoapClient\Result\LeadConvertResult',
        'LoginResult'           => 'Salesforce\SoapClient\Result\LoginResult',
        'MergeResult'           => 'Salesforce\SoapClient\Result\MergeResult',
        'QueryResult'           => 'Salesforce\SoapClient\Result\QueryResult',
        'SaveResult'            => 'Salesforce\SoapClient\Result\SaveResult',
        'SearchResult'          => 'Salesforce\SoapClient\Result\SearchResult',
        'SendEmailError'        => 'Salesforce\SoapClient\Result\SendEmailError',
        'SendEmailResult'       => 'Salesforce\SoapClient\Result\SendEmailResult',
        'SingleEmailMessage'    => 'Salesforce\SoapClient\Request\SingleEmailMessage',
        'sObject'               => 'Salesforce\SoapClient\Result\SObject',
        'UndeleteResult'        => 'Salesforce\SoapClient\Result\UndeleteResult',
        'UpsertResult'          => 'Salesforce\SoapClient\Result\UpsertResult',
    );

    /**
     * Type converters collection
     *
     * @var TypeConverter\TypeConverterCollection
     */
    protected $typeConverters;

    /**
     * @param string $wsdl Some argument description
     *
     * @return SoapClient
     */
    public function factory($wsdl)
    {
        return new SoapClient($wsdl, array(
            'trace'     => 1,
            'features'  => \SOAP_SINGLE_ELEMENT_ARRAYS,
            'classmap'  => $this->classmap,
            'typemap'   => $this->getTypeConverters()->getTypemap(),
            'cache_wsdl' => \WSDL_CACHE_MEMORY
        ));
    }

    /**
     * test
     *
     * @param string $soap SOAP class
     * @param string $php  PHP class
     */
    public function setClassmapping($soap, $php)
    {
        $this->classmap[$soap] = $php;
    }

    /**
     * Get type converter collection that will be used for the \SoapClient
     *
     * @return TypeConverter\TypeConverterCollection
     */
    public function getTypeConverters()
    {
        if (null === $this->typeConverters) {
            $this->typeConverters = new TypeConverter\TypeConverterCollection(
                array(
                    new TypeConverter\DateTimeTypeConverter(),
                    new TypeConverter\DateTypeConverter()
                )
            );
        }

        return $this->typeConverters;
    }

    /**
     * Set type converter collection
     *
     * @param TypeConverter\TypeConverterCollection $typeConverters Type converter collection
     *
     * @return SoapClientFactory
     */
    public function setTypeConverters(TypeConverter\TypeConverterCollection $typeConverters)
    {
        $this->typeConverters = $typeConverters;

        return $this;
    }
}