<?php

namespace Anticom\ShowcaseBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\StreamOutput;

class Tools {
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
}