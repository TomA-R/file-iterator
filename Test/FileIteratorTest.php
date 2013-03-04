<?php

require_once '../FileIterator.php';

class FileIteratorTest extends PHPUnit_Framework_TestCase
{
  public function testIterator()
  {
    $fileIterator = new FileIterator('data.txt');

    $counter = 0;
    foreach ($fileIterator as $lineNumber => $line)
    {
      $counter++;

      switch ($lineNumber)
      {
        case 0:
          $this->assertEquals('This is a dummy file', $line);
          break;

        case 1:
          $this->assertEquals('Nothing to see here', $line);
          break;

        case 2:
          $this->assertEquals('Foo bar', $line);
          break;

        default:
          // Should not happen
          $this->assertTrue(false);
          break;
      }
    }

    $this->assertEquals(3, $counter);
  }
}
