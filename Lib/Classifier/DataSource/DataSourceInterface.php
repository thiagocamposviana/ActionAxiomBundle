<?php

namespace Mugo\ActionAxiomBundle\Lib\Classifier\DataSource;

interface DataSourceInterface
{
    /**
     * Write the data source if possible
     * @return null
     */
    public function write();
    /**
     * Get the data
     * @return array The data
     */
    public function getData();
    /**
     * Set data to the data source
     * @param  array $data
     * @return null
     */
    public function setData(array $data);
    /**
     * Returns the categories of the data
     * @return array The categories
     */
    public function getCategories();
    /**
     * Returnnes whether or not the data has a category
     * @param  string  $category The category to check
     * @return boolean [description]
     */
    public function hasCategory($category);
    /**
     * Adds a document by category to the data
     * @param string $category The category of the document
     * @param string $document The document
     */
    public function addDocument($category, $document);
}
