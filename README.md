Update composer.json "autoload" to:
```javascript
    "autoload": {
        "psr-4": {
            "App\\": "src/",
            "": "bundles/"
        }
    },
```

Create ./bundles

Copy the bundle folder to ./bundles/Mugo/.

Copy mugo_editor_word_suggestion.yaml.sample to ./config/routes/mugo_editor_word_synonyms.yaml

Then update ./config/bundles.php

And update the bundles array with the new bundle

Mugo\ActionAxiomBundle\MugoActionAxiomBundle::class => ['all' => true],

composer dumpautoload

sudo apt-get install libsvm-dev
sudo pecl install -f svm

composer require wamania/php-stemmer "^2.0"
composer require php-ai/php-ml


MySQL:

- Create table

```sql
CREATE TABLE `mugo_word_synonym` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` int(11) NOT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `word` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `language` varchar(15) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `antonyms_code` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=377487 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
```

Import the data:

```bash
mysql -u root -p db < bundles/Mugo/ActionAxiomBundle/Resources/data/mugo_word_synonym/por.sql

mysql -u root -p db < bundles/Mugo/ActionAxiomBundle/Resources/data/mugo_word_synonym/eng.sql
```

Credits:

Portuguese synonym data based on https://github.com/stavarengo/portuguese-brazilian-synonyms

AI Classifiers base lib based on https://github.com/camspiers/statistical-classifier (with a few adaptions)

Sample Text Data from Wikipedia

PHP Simple HTML DOM Parser Manual https://simplehtmldom.sourceforge.io/manual.htm (with a few adaptions)
