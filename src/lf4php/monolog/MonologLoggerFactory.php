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

use ArrayObject;
use lf4php\ILoggerFactory;
use lf4php\Logger;
use Monolog\Logger as MonologLogger;

/**
 * @author Szurovecz János <szjani@szjani.hu>
 */
class MonologLoggerFactory implements ILoggerFactory
{
    private $map;

    private $defaultLogger;

    public function __construct()
    {
        $this->map = new ArrayObject();
    }

    private function getDefaultLogger()
    {
        if ($this->defaultLogger === null) {
            $this->defaultLogger = new MonologLoggerWrapper(new MonologLogger(Logger::ROOT_LOGGER_NAME));
        }
        return $this->defaultLogger;
    }

    /**
     * Useful for class names.
     * If $name is \foo\bar and there is a registered
     * logger for \foo then it will returns it in case
     * of no registered logger for \foo\bar.
     *
     * If it does not find any logger, creates a default one.
     *
     * @param string $name
     * @return MonologLoggerWrapper
     */
    protected function findClosestAncestor($name)
    {
        $name = trim($name, '\\');
        $parts = explode('\\', $name);
        while (!array_key_exists($name, $this->map) && !empty($parts)) {
            array_pop($parts);
            $name = implode('\\', $parts);
        }
        if (!array_key_exists($name, $this->map)) {
            $this->map[$name] = $this->getDefaultLogger();
        }
        return $this->map[$name];
    }

    /**
     * @param MonologLogger $monologLogger
     */
    public function registerLogger(MonologLogger $monologLogger)
    {
        $this->map[$monologLogger->getName()] = new MonologLoggerWrapper($monologLogger);
    }

    /**
     * @param string $name
     * @return Logger
     */
    public function getLogger($name)
    {
        return $this->findClosestAncestor($name);
    }
}
