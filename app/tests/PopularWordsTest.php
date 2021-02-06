<?php declare(strict_types=1);

require_once __DIR__.'/../functions.php';

use PHPUnit\Framework\TestCase;

class PopularWordsTest extends TestCase
{
    public function testEmptyText(): void
    {
        $text = '';

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('There are no any word in your text');

        getMostPopularWords($text);
    }

    public function testBlankText(): void
    {
        $text = <<<EOT
        
        
                            
                            
        EOT;

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('There are no any word in your text');

        getMostPopularWords($text);
    }

    public function testTextWithoutWords(): void
    {
        $text = '123.';

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('There are no any word in your text');

        getMostPopularWords($text);
    }

    public function testEnglish(): void
    {
        $text = <<<EOT
        One morning, when Gregor Samsa woke from troubled dreams, he found himself transformed in his bed into a horrible vermin.

        He lay on his armour-like back, and if he lifted his head a little he could see his brown belly, slightly domed and divided by arches into stiff sections.
        EOT;

        $result = getMostPopularWords($text);

        $this->assertSame(
            [
                'he' => 4,
                'his' => 4,
                'a' => 2,
                'and' => 2,
                'into' => 2,
            ],
            $result
        );
    }

    public function testRussian(): void
    {
        $text = <<<EOT
        Проснувшись однажды утром после беспокойного сна, Грегор Замза обнаружил, что он у себя в постели превратился в страшное насекомое.
        
        Лежа на панцирнотвердой спине, он видел, стоило ему приподнять голову, свой коричневый, выпуклый, разделенный дугообразными чешуйками живот, на верхушке которого еле держалось готовое вот-вот окончательно сползти одеяло.
        EOT;

        $result = getMostPopularWords($text);

        $this->assertSame(
            [
                'в' => 2,
                'вот' => 2,
                'на' => 2,
                'он' => 2,
                'беспокойного' => 1,
            ],
            $result
        );
    }

    public function testGreek(): void
    {
        $text = <<<EOT
        Ένα πρωί, όταν ο Γκρέγκορ Σάμσα ξύπνησε από ταραγμένα όνειρα, βρέθηκε να μετατρέπεται στο κρεβάτι του σε ένα φρικτό παράσιτο.

        Ξαπλώθηκε στην πλάτη του σαν θωράκιση, και αν σηκώσει λίγο το κεφάλι του, θα μπορούσε να δει την καφέ κοιλιά του, ελαφρώς θολωτή και χωρισμένη από καμάρες σε δύσκαμπτα τμήματα.
        EOT;

        $result = getMostPopularWords($text);

        $this->assertSame(
            [
                'του' => 4,
                'ένα' => 2,
                'από' => 2,
                'και' => 2,
                'να' => 2,
            ],
            $result
        );
    }

    public function testArabic(): void
    {
        $text = <<<EOT
        أنا قادر على أكل الزجاج و هذا لا يؤلمني. أنا قادر على
        EOT;

        $result = getMostPopularWords($text);

        $this->assertSame(
            [
                'أنا' => 2,
                'على' => 2,
                'قادر' => 2,
                'أكل' => 1,
                'الزجاج' => 1,
            ],
            $result
        );
    }

    public function testSeveralWordsWithSameFrequencyOrdering(): void
    {
        $text = <<<EOT
        foo foo bar bar baz baz fizz fizz buzz buzz
        EOT;

        $result = getMostPopularWords($text);

        $this->assertSame(
            [
                'bar' => 2,
                'baz' => 2,
                'buzz' => 2,
                'fizz' => 2,
                'foo' => 2,
            ],
            $result
        );
    }

    public function testWithLessThanFiveWords(): void
    {
        $text = <<<EOT
        foo
        EOT;

        $result = getMostPopularWords($text);

        $this->assertSame(
            [
                'foo' => 1,
            ],
            $result
        );
    }

    public function testWithMoreThanFiveWordsWithEqualFrequency(): void
    {
        $text = <<<EOT
        a b c d e f g h
        EOT;

        $result = getMostPopularWords($text);

        $this->assertSame(
            [
                'a' => 1,
                'b' => 1,
                'c' => 1,
                'd' => 1,
                'e' => 1,
            ],
            $result
        );
    }

    public function testMixedWhitespacesBetweenPunctuationMarks(): void
    {
        $text = <<<EOT
        One morning,when Gregor Samsa woke from troubled dreams!he found himself transformed in his bed into a horrible vermin.        
        One morning, when he
        EOT;

        $result = getMostPopularWords($text);

        $this->assertSame(
            [
                'he' => 2,
                'morning' => 2,
                'one' => 2,
                'when' => 2,
                'a' => 1,
            ],
            $result
        );
    }
}
