<?php

namespace Anticom\ShowcaseBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\StreamOutput;
use Symfony\Component\HttpFoundation\Response;

class Tools {
    protected static $loggedResponses = array();

    /**
     * @param Client $client
     * @param        $command
     * @return string
     */
    public static function runCommand(Client $client, $command) {
        $application = new Application($client->getKernel());
        $application->setAutoExit(false);

        $fp     = tmpfile();
        $input  = new StringInput($command);
        $output = new StreamOutput($fp);

        $application->run($input, $output);

        fseek($fp, 0);
        $output = '';
        while(!feof($fp)) {
            $output = fread($fp, 4096);
        }
        fclose($fp);

        return $output;
    }

    /**
     * @param Client $client
     * @param array  $commands
     * @return string[]
     */
    public static function runCommands(Client $client, array $commands = array()) {
        $output = array();
        foreach($commands as $command) {
            $output[] = static::runCommand($client, $command);
        }
        return $output;
    }

    /**
     * @param Response $response
     * @param string   $filename  usually Tools::classAndMethodToFilename is used here
     * @param string   $extension default is html
     */
    public static function logResponse(Response $response, $filename = '[default]', $extension = 'html') {
        if(isset(self::$loggedResponses[$filename])) {
            self::$loggedResponses[$filename]++;
        } else {
            self::$loggedResponses[$filename] = 1;
        }

        $appendix = self::$loggedResponses[$filename];
        $filename = $filename . '_' . $appendix . '.' . $extension;

        $content = '';
        $content .= "<!--\n";
        $content .= "Status-code: " . $response->getStatusCode() . "\n";
        $content .= "Complete headers: " . $response->headers . "\n";
        $content .= "-->\n";

        $content .= $response->getContent();

        file_put_contents($filename, $content);
    }

    /**
     * @param string $class  usually __CLASS__
     * @param string $method usually __METHOD__
     * @return string
     */
    public static function classAndMethodToFilename($class = '[null]', $method = '[null]') {
        $classFragments = explode('\\', $class);
        $className      = array_pop($classFragments);
        $namespace      = implode('\\', $classFragments);

        if(!empty($namespace)) {
            $namespaceHash = md5($namespace);
            $className .= '[' . $namespaceHash . ']';
        }

        if(strpos($method, '::') !== false) {
            $methodName = substr($method, strpos($method, '::') + 2);
        } else {
            $methodName = $method;
        }

        return $className . '_' . $methodName;
    }
}