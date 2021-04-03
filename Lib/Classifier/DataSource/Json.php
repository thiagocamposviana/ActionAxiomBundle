<?php

namespace Mugo\ActionAxiomBundle\Lib\Classifier\DataSource;

class Json extends DataArray
{
    /**
     * The filename of the json file
     * @var string
     */
    private $filename;
    /**
     * Creates the object from the filename
     * @param string $filename The filename of the json file
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
            $data = json_decode(file_get_contents($this->filename), true);
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
        $data = array();
        foreach ($this->data as $category => $documents) {
            foreach ($documents as $document) {
                $data[] = array(
                    'category' => $category,
                    'document' => $document
                );
            }
        }
        file_put_contents($this->filename, json_encode($data));
    }
}
