<?php

namespace Mugo\ActionAxiomBundle\Lib\Classifier\DataSource;

class Converter
{
    /**
     * The source to convert from
     * @var DataSourceInterface
     */
    private $convertFrom;
    /**
     * The source to convert to
     * @var DataSourceInterface
     */
    private $convertTo;
    /**
     * Creates the converter using to data sources
     * @param DataSourceInterface $convertFrom
     * @param DataSourceInterface $convertTo
     */
    public function __construct(DataSourceInterface $convertFrom, DataSourceInterface $convertTo)
    {
        $this->convertFrom = $convertFrom;
        $this->convertTo = $convertTo;
    }
    /**
     * run the conversion
     * @return null
     */
    public function run()
    {
        $this->convertTo->setData($this->convertFrom->getData());
        $this->convertTo->write();
    }
}
