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

require_once __DIR__ . '/../bootstrap.php';

use lf4php\LoggerFactory;
use lf4php\monolog\MonologLoggerFactory;
use lf4php\monolog\MonologLoggerWrapper;

// initialize Monolog
$monolog = new \Monolog\Logger('root');
$monolog->pushHandler(new Monolog\Handler\StreamHandler('php://output'));

// configure lf4php
$monologgerFactory = new MonologLoggerFactory();
$monologgerFactory->setRootLogger(new MonologLoggerWrapper($monolog));
LoggerFactory::setILoggerFactory($monologgerFactory);

// logging
$logger = LoggerFactory::getLogger('default');
$logger->error('Hello {}!', array('World'), new Exception());
$logger->info(Test::getException());

class Test
{
    public static function getException()
    {
        LoggerFactory::getLogger(__CLASS__)->debug(__METHOD__);
        return new Exception('ouch');
    }
}
