<?php
namespace Core;

/**
 * Error and exception handler
 */
class Error
{
	/**
	 * Error handler. Convert all errors to Exceptions bythrowing an ErrorException
	 *
	 * @param int 	 $level   Error level
	 * @param string $message Error message
	 * @param string $file 	  Filename the error was raised in
	 * @param int 	 $line 	  Line number in the file
	 */
	public static function errorHandler($level, $message, $file, $line)
	{
		if (error_reporting() !== 0) { // to keep the @ operator working
			/**
			 * TODO: Find out why this error happens
			 * 
			 * Fatal error: Wrong parameters for ErrorException([string
			 * $exception [, long $code, [ long $severity, [ string $filename,
			 * [ long $lineno [, Exception $previous = NULL]]]]]]) in
			 * C:\OpenServer\domains\exlibris\Core\Error.php on line 21
			 * 
			 */
			
			// throw new \ErrorException($message, 0, $file, $line);
		}
	}

	/**
	 * Exception handler
	 *
	 * @param Exception $exception The exception
	 *
	 * @return void
	 */
	public static function exceptionHandler($exception)
	{
		/**
		 * Error code
		 * 404 -> not found
		 * 500 -> general error (server error)
		 */
		$code = $exception->getCode();
		if ($code != 404) {
			$code = 500;
		}

		http_response_code($code);

		if (\App\Config::SHOW_ERRORS) {
			echo '
				<h1>Fatal error</h1>
				<p>Uncaught exception: '. get_class($exception) .'</p>
				<p>Message: '. $exception->getMessage() .'</p>
				<p>Stack trace:</p><pre>'. $exception->getTraceAsString() .'</pre>
				<p>Thrown in '. $exception->getFile().
				' on line '. $exception->getLine() .'</p>
			';
		} else {
			$log = dirname(__DIR__) . '/logs/' . date('Y-m-d') . '.txt';
			ini_set('error_log', $log);

			$message = "Uncaught exception: '". get_class($exception) ."'";
			$message .= "\nMessage: '". $exception->getMessage() ."'";
			$message .= "\nStack trace:\n". $exception->getTraceAsString();
			$message .= "\nThrown in ". $exception->getFile()
			. " on line " . $exception->getLine();

			error_log($message);
			// $codeMessage = ($code == 404) ? '<h1>Page not found</h1>' : '<h1>An error occured</h1>';
			// echo $codeMessage;
			View::renderTemplate("$code.html");
		}
	}
}