<?php

namespace Mugo\ActionAxiomBundle\Lib\Classifier\DataSource;

class Serialized extends DataArray
{
    /**
     * The filename to read and write to
     * @var string
     */
    private $filename;
    /**
     * Creates the data source using the filename
     * @param string $filename The filename to use
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
    }
    /**
     * @{inheritdoc}
     */
    public function read()
    {
        if (file_exists($this->filename)) {
            $data = unserialize(file_get_contents($this->filename));
            if (is_array($data)) {
                return $data;
            }
        }

        return array();
    }
    /**
     * @{inheritdoc}
     */
    public function write()
    {
        file_put_contents($this->filename, serialize($this->data));
    }
}
