<?php declare(strict_types=1);

/**
 * Splits text into tokens
 * Implements naive text tokenization pattern - thinks that everything except letters, ' and ` symbols is words delimiter
 * Does not support languages without words delimiters (e.g. Chinese, Japanese, Khmer, etc.)
 * Also splits compounded words to separate tokens (i.e. "user-friendly" => ["user", "friendly"]
 * @param string $text - text to tokenize
 * @return array - tokens
 * @throws Exception
 */
function tokenizeText(string $text): array
{
    $text = trim($text);

    $text = mb_strtolower($text);

    $tokens = preg_split("/[^\w'`]|\d/u", $text, -1, PREG_SPLIT_NO_EMPTY);

    if ($tokens === false) {
        throw new \Exception('Could not tokenize your text');
    }

    return $tokens;
}

/**
 * Returns most popular words in passed text
 * Uses naive text tokenizer - thinks that everything except letters, ' and ` symbols is words delimiter
 * Does not support languages without words delimiters (e.g. Chinese, Japanese, Khmer, etc.)
 * Also splits compounded words to separate tokens (i.e. "user-friendly" => ["user", "friendly"]
 * When there are more than $topQuantity words with same frequency, alphabetical ordering will be applied
 * @param string $text - text to count most popular words
 * @param int $topQuantity - quantity of popular words to return, five by default
 * @return array - $topQuantity most common words as ['word'] => frequency
 * @throws Exception
 */
function getMostPopularWords(string $text, int $topQuantity = 5): array
{
    $tokens = tokenizeText($text);

    if (count($tokens) < 1) {
        throw new \Exception('There are no any word in your text');
    }

    $tokenFrequency = array_count_values($tokens);

    if (array_multisort(
            array_values($tokenFrequency),
            SORT_DESC,
            array_keys($tokenFrequency),
            SORT_STRING,
            $tokenFrequency
        ) !== true) {
        throw new \Exception('An error occurred during words sorting');
    }

    return array_slice($tokenFrequency, 0, $topQuantity);
}
