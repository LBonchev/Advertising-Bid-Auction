<?php
require_once __DIR__ . '/autoload.php';

$auctionProcessor = new \src\AuctionProcessor();
$auctionProcessorTest = new \tests\AuctionProcessorTest($auctionProcessor);
$auctionProcessorTest->run();