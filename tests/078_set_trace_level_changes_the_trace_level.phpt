--TEST--
setTraceLevel() changes the trace level.
--SKIPIF--
<?php include("should_run_online_tests.inc"); ?>
--FILE--
<?php

// remove old trace files
$files = glob('rfc*.trc');
if(count($files) > 0) {
    array_map(function($f) {
        unlink($f);
    }, $files);
}

$config = include "sapnwrfc.config.inc";
$config['trace'] = \SAPNWRFC\Connection::TRACE_LEVEL_OFF;
$c = new \SAPNWRFC\Connection($config);

// trace level is off, so no *.trc files should be here
$files = glob('rfc*.trc');
var_dump(count($files));

// change the trace level and do a function lookup, this should generate a trace
\SAPNWRFC\Connection::setTraceLevel(\SAPNWRFC\Connection::TRACE_LEVEL_FULL);
$f = $c->getFunction('RFC_PING');
$f->invoke([]);

// make sure there is a trace file
$files = glob('rfc*.trc');
var_dump(count($files) > 0);

--EXPECT--
int(0)
bool(true)
--CLEAN--
// remove trace files
$files = glob('*.trc');
if(count($files) > 0) {
    array_map(function($f) {
        unlink($f);
    }, $files);
}
