
<?php
require "rna-transcription.php";
use PHPUnit\Framework\TestCase;
class ComplementTest extends TestCase
{
    public function testTranscribesGuanineToCytosine()
    {
        $this->assertSame('G', toRna('C'));
    }
    public function testTranscribesCytosineToGuanine()
    {
        $this->assertSame('C', toRna('G'));
    }
    public function testTranscribesThymineToAdenine()
    {
        $this->assertSame('A', toRna('T'));
    }
    public function testTranscribesAdenineToUracil()
    {
        $this->assertSame('U', toRna('A'));
    }
    public function testTranscribesAllOccurencesOne()
    {
        $this->assertSame('UGCACCAGAAUU', toRna('ACGTGGTCTTAA'));
    }
}