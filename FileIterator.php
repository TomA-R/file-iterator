<?php

/**
 * @link https://github.com/TomA-R/file-iterator
 */
class FileIterator implements Iterator
{
  /**
   * Line length - fgets() param
   */
  const LINE_LENGTH = 4096;

  /**
   * File handle
   *
   * @var resource
   */
  protected $_handle;

  /**
   * Current file line in iterator
   *
   * @var array|null
   */
  protected $_currentElement = null;

  /**
   * Current line number
   *
   * @var int
   */
  protected $_currentIndex = 0;

  /**
   * Create file pointer
   *
   * @param string $fileName
   */
  public function __construct($fileName)
  {
    $this->_handle = fopen($fileName, 'r');

    // Rewind
    $this->rewind();
  }

  /**
   * Return current element
   * Implements Iterator::current()
   *
   * @return string|null
   */
  public function current()
  {
    return trim($this->_currentElement, "\r\n");
  }

  /**
   * Return the key of the current element (Getter for currentLineNumber)
   * Implements Iterator::key()
   *
   * @return int
   */
  public function key()
  {
    return $this->_currentIndex;
  }

  /**
   * Move forward to next element
   * Implements Iterator::next()
   *
   * @throws Exception
   * @return void Any returned value is ignored.
   */
  public function next()
  {
    $this->_currentElement = fgets($this->_handle, self::LINE_LENGTH);
    $this->_currentIndex++;
  }

  /**
   * Rewind the Iterator to the first element
   * Implements Iterator::rewind()
   *
   * @return void Any returned value is ignored.
   */
  public function rewind()
  {
    rewind($this->_handle);
    $this->_currentIndex = -1;
    $this->next();
  }

  /**
   * Checks if current position is valid
   *
   * @return bool false if there's nothing left to iterate over
   */
  public function valid()
  {
    return (bool) $this->current();
  }

  /**
   * Checks whether current file line matches given regexp pattern
   * If $matches is provided, it will be filled with the results of search.
   *
   * @param string     $pattern
   * @param array|null $matches
   * @return int|false
   */
  public function match($pattern, &$matches = null)
  {
    return preg_match($pattern, $this->current(), $matches);
  }
}
