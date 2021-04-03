<?php

namespace Mugo\ActionAxiomBundle\Lib\Classifier;

/**
 * Provides an interface for classifier.
 * Implementing classes are classifiers capable of classifying documents into categories
 */
interface ClassifierInterface
{
    /**
     * Returns whether or not the document is of the category
     * @param  string  $category The category in question
     * @param  string  $document The document to check
     * @return boolean Whether or not the document is in the category
     */
    public function is($category, $document);
    /**
     * Classify the document and return its category
     * @param  string      $document The document to classify
     * @return string|bool The category of the document
     */
    public function classify($document);
}
