<?php

/**
 * set appfog logger
 */
Event::listen('illuminate.log', function($level, $message, $context)
{
    $conf = Config::get('app.logentries');
    list($token, $persistent, $use_ssl, $severity) = array_values($conf);
    $logger = LeLogger::getLogger($token, $persistent, $use_ssl, $severity);
    $logger->$level($message);
});
