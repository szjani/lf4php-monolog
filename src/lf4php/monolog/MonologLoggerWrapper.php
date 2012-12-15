<?php
/*
 * Copyright (c) 2012 Szurovecz János
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
 * of the Software, and to permit persons to whom the Software is furnished to do
 * so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace lf4php\monolog;

use Exception;
use lf4php\helpers\MessageFormatter;
use lf4php\LocationLogger;
use Monolog\Logger as MonologLogger;

/**
 * @author Szurovecz János <szjani@szjani.hu>
 */
class MonologLoggerWrapper extends LocationLogger
{
    /**
     * @var MonologLogger
     */
    private $monologLogger;

    /**
     * @param \Monolog\Logger $monologLogger
     */
    public function __construct(MonologLogger $monologLogger)
    {
        $this->monologLogger = $monologLogger;
        $this->setLocationPrefix('');
    }

    /**
     * @return MonologLogger
     */
    public function getMonologLogger()
    {
        return $this->monologLogger;
    }

    public function getName()
    {
        return $this->monologLogger->getName();
    }

    protected function getFormattedLocation()
    {
        return $this->getLocationPrefix() . $this->getShortLocation(self::DEFAULT_BACKTRACE_LEVEL + 1) . $this->getLocationSuffix();
    }

    public function debug($format, $params = array())
    {
        if ($this->isDebugEnabled()) {
            $this->monologLogger->debug($this->getFormattedLocation() . MessageFormatter::format($format, $params));
        }
    }

    public function error($format, $params = array())
    {
        if ($this->isErrorEnabled()) {
            $this->monologLogger->err($this->getFormattedLocation() . MessageFormatter::format($format, $params));
        }
    }

    public function info($format, $params = array())
    {
        if ($this->isInfoEnabled()) {
            $this->monologLogger->info($this->getFormattedLocation() . MessageFormatter::format($format, $params));
        }
    }

    public function trace($format, $params = array())
    {
        if ($this->isTraceEnabled()) {
            $e = new Exception();
            $this->monologLogger->debug($this->getFormattedLocation() . MessageFormatter::format($format, $params) . PHP_EOL . $e->getTraceAsString());
        }
    }

    public function warn($format, $params = array())
    {
        if ($this->isWarnEnabled()) {
            $this->monologLogger->warn($this->getFormattedLocation() . MessageFormatter::format($format, $params));
        }
    }

    public function isDebugEnabled()
    {
        return true;
    }

    public function isErrorEnabled()
    {
        return true;
    }

    public function isInfoEnabled()
    {
        return true;
    }

    public function isTraceEnabled()
    {
        return true;
    }

    public function isWarnEnabled()
    {
        return true;
    }
}
