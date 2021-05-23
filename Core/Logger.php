<?php

class Logger
{
  /**
   * Specify the logger directory
   */
  protected string $logPath = "log";

  public function __construct()
  {
    // check if logger directory doesn't exists
    if (!file_exists($this->logPath)) {
      // create a logger directory
      mkdir($this->logPath, 0700);
    }
  }

  /**
   * Create a log file
   * 
   * @param string $msg
   * @return int|bool
   */
  public function log(string $msg): int|false
  {
    // path of log file
    $path = "./{$this->logPath}/log-{$this->date()}";
    // create log file
    return file_put_contents($path, $msg) ?? false;
  }

  /**
   * !FIXME: Improve
   * Get a specific log
   */
  public function getLog(string $filename): string|false
  {
    return file_get_contents($filename) ?? false;
  }

  /** 
   * !FIXME: Improve
   * Get all logs
   */
  public function getAllLogs(): array
  {
    return scandir("./$this->logPath");
  }

  /**
   * Determine logged file DateTime
   * 
   * @return string
   */
  protected function date(): string
  {
    // create DateTime object
    $datetime = new DateTime();
    // set DateTime timezone
    $datetime->setTimezone(new DateTimeZone('UTC'));
    // return formatted DateTime as string
    return $datetime->format('Y/m/d H:i:s');
  }

  // TODO: blueprint for returned logged?
  // $return = [
  //   'msg' => 'Something went wrong.',
  //   'code' => '504',
  //   'url' => $_SERVER['REQUEST_URI'],
  //   'username' => 'John Doe',
  // ];
}
