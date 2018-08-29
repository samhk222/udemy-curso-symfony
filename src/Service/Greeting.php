<?php
/**
 * Created by PhpStorm.
 * User: samhk222
 * Date: 28/08/18
 * Time: 16:00
 */

namespace App\Service;


use Psr\Log\LoggerInterface;

class Greeting
{
    private $logger;
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function greet(string $name):string{
        $this->logger->info("Greet for {$name}");
        return "Hello {$name}";
    }
}