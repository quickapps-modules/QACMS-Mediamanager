<?php 
/**
 * Simple example how to use logger with elFinder
 **/
class elFinderLogger implements elFinderILogger {
	
	public function log($cmd, $ok, $context, $err='', $errorData = array()) {
        $str = $ok ? 
        "cmd: $cmd; OK; context: ".str_replace("\n", '', var_export($context, true))."; \n" :
        "cmd: $cmd; FAILED; context: ".str_replace("\n", '', var_export($context, true))."; error: $err; errorData: ".str_replace("\n", '', var_export($errorData, true))."\n";
        LogError($str);
	}
}