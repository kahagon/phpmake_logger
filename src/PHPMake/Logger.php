<?php
namespace PHPMake;
use Psr\Log;

class Logger extends Log\AbstractLogger {
    protected $_url;
    protected $_stream;
    protected $_threshold;
    protected $_levelValueMap = array(
        Log\LogLevel::EMERGENCY => 800,
        Log\LogLevel::ALERT     => 700,
        Log\LogLevel::CRITICAL  => 600,
        Log\LogLevel::ERROR     => 500,
        Log\LogLevel::WARNING   => 400,
        Log\LogLevel::NOTICE    => 300,
        Log\LogLevel::INFO      => 200,
        Log\LogLevel::DEBUG     => 100,
    );

    public function __construct($url = 'php://stdout', $mode = 'a') {
        $this->_url = $url;
        $this->_stream = fopen($this->_url, $mode);
        $this->setThreshold(Log\LogLevel::DEBUG);
    }

    public function __destruct() {
        $this->close();
    }

    public function setThreshold($level) {
        $this->_threshold = $this->_logLevelValue($level);
    }

    /**
     * copied from psr log example.
     * Interpolates context values into the message placeholders.
     *
     * @see https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md
     */
    public static function interpolate($message, array $context = array()) {
        // build a replacement array with braces around the context keys
        $replace = array();
        foreach ($context as $key => $val) {
            $replace['{' . $key . '}'] = $val;
        }

        // interpolate replacement values into the message and return
        return strtr($message, $replace);
    }

    public function log($level, $message, array $context = array()) {
        if ($this->_threshold > $this->_logLevelValue($level)) {
            return;
        }

        $text = self::interpolate($message, $context);
        fwrite($this->_stream, $text . "\n");
        fflush($this->_stream);
    }

    public function close() {
        fclose($this->_stream);
    }

    protected function _logLevelValue($level) {
        if (!array_key_exists($level, $this->_levelValueMap)) {
            throw new \Exception(sprintf('specified log level(%s) is not registered.', $level));
        }

        return $this->_levelValueMap[$level];
    }
}
