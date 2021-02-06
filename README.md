# Popular Words Counter

Counts popular words in passed text

## Limitations
* Uses naive text tokenizer - thinks that everything except letters, `'` and `` ` ``
  symbols is words delimiter
* Does not support languages without words delimiters (e.g. Chinese, Japanese, Khmer, etc.)
* Also splits compounded words to separate tokens (i.e. `"user-friendly" => ["user", "friendly"]`
* When there are more than `$topQuantity` words with same frequency, alphabetical ordering will be applied

## 

## How to use
```
# Run example script
λ cd /path/to/project/docker
λ  docker-compose run php php example.php

sample.txt content is passed to words counter - you are welcome to edit it


# Run tests
λ cd /path/to/project/docker
λ docker-compose run php composer install
λ docker-compose run php php vendor/phpunit/phpunit/phpunit tests

You can also add you own test cases at /path/to/project/app/tests/PopularWordsTest.php
```
