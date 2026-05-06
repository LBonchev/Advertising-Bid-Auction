<?php
require_once __DIR__ . '/autoload.php';

$auctionProcessor = new \src\AuctionProcessor();
$csvReader = new \src\CsvReader();

try{
    $csvFilePath = $argv[1];
    if(empty($csvFilePath)){
        throw new \Exception("missing CSV filename");
    }

    [$winner, $secondHighestBid] = $auctionProcessor->getAuctionWinnerAndSecondHighestBid($csvReader->getRows($csvFilePath));

    echo $winner .", " . $secondHighestBid;
    exit(0);
}catch (Exception $e){
    file_put_contents('php://stderr', "Error: " . $e->getMessage());
    exit(1);
}