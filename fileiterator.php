<?php

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
   * Valid element or not
   *
   * @var bool
   */
  protected $_valid;

  /**
   * Essentially, the number of lines
   *
   * @var int
   */
  protected $_eof;

  /**
   * Create file pointer
   *
   * @param string $fileName
   */
  public function __construct($fileName)
  {
    $this->_handle = fopen($fileName, 'r');

    // Determine EOF
    fseek($this->_handle, 0, SEEK_END);
    $this->_eof = ftell($this->_handle);

    // Rewind
    rewind($this->_handle);
  }

  /**
   * Return current element
   * Implements Iterator::current()
   *
   * @return string|null
   */
  public function current()
  {
    return $this->_currentElement;
  }

  /**
   * Return the key of the current element (Getter for currentIndex)
   * Implements Iterator::key()
   *
   * @return int
   */
  public function key()
  {
    return ftell($this->_handle);
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
  }

  /**
   * Checks if current position is valid
   *
   * @return bool false if there's nothing left to iterate over
   */
  public function valid()
  {
    if (ftell($this->_handle) >= $this->_eof)
    {
      return false;
    }
    return true;
  }

  /**
   * Checks whether current file line matches given regexp pattern
   * If $matches is provided, it will be filled with the results of search.
   *
   * @param string $pattern
   * @param array|null $matches
   * @return int|false
   */
  public function match($pattern, &$matches = null)
  {
    return preg_match($pattern, $this->current(), $matches);
  }
}
