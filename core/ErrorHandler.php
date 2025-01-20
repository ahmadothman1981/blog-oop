<?php
namespace core;

class ErrorHandler
{
    public static function handleException(\Throwable $exception)
    {

        static::logError($exception);

        if(php_sapi_name() == 'cli')
        {
            static::renderCliError($exception);
        }else{
           // static::renderErrorPage($exception);
        }
    }
    private static function renderCliError(\Throwable $exception):void
    {
       $isDebug = App::get('config')['app']['debug'] ?? false;
       if($isDebug)
       {
        $errorMessage  = static::formatErrorMessage($exception ,"\033[31m[%s] Error:\033[0m %s: %s in %s on line %d\n");
        $trace = $exception->getTraceAsString();
       }else{
        $errorMessage = "\033[31m  An error occurred . Please try again later\033[0m\n";
        $trace = "";
       }

       fwrite(STDERR, $errorMessage);
       if($trace)
       {
        fwrite(STDERR, "\nStack trace:\n$trace\n");
       }
       //exit with status 1 means error occured
       exit(1);
    }
    private static function logError(\Throwable $exception):void
    {
        $logMessage = static::formatErrorMessage($exception, "[%s] %s: %s in %s on line %d");
        error_log($logMessage, 3,__DIR__ . '/../logs/errors.log');
    }
    public static function handleError($level, $message, $file, $line)
    {
        $exception = new \ErrorException($message, 0, $level, $file, $line);
        //using ststic not self because self refere to current class but static refere to current or child class
        static::handleException($exception);
    }

    private static function formatErrorMessage(\Throwable $exception , string $format): string
    {
        return sprintf(
            $format,
            date('Y-m-d H:i:s'),
            get_class($exception),
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine()
        );
    }
}