<?php

namespace tests;

use src\AuctionProcessor;

class AuctionProcessorTest extends BaseTest
{
    private AuctionProcessor $auctionProcessor;

    public function __construct(AuctionProcessor $auctionProcessor)
    {
        $this->auctionProcessor = $auctionProcessor;
    }

    public function run(): void
    {
        echo "Running Tests for Task 1: Advertising Bid Auction...\n";

        $this->testBasicAuction();
        $this->testEmptyData();
        $this->testIfOnlyOneBidExistItShouldWin();
        $this->testSkipRowsWithWrongADId();
        $this->testSkipRowsWithWrongBidPrice();
        $this->testBidsWithSamePriceFirstShouldWin();
        $this->testOnlyBidsWithSamePriceFirstShouldWin();

        $this->printSummary();
    }

    private function testBasicAuction(): void {
        $this->assertEquals(
            "(testBasicAuction) Check winner and second bid",
            ['2', 10],
            function() {
                return $this->auctionProcessor->getAuctionWinnerAndSecondHighestBid([
                    ['ad_id' => '1', 'bid' => 10],
                    ['ad_id' => '2', 'bid' => 20]
                ]);
            }
        );
    }

    private function testSkipRowsWithWrongADId(): void {
        $this->assertEquals(
            "(testSkipRowsWithWrongADId) Skip rows with wrong ad id",
            ['2', 10],
            function() {
                return $this->auctionProcessor->getAuctionWinnerAndSecondHighestBid([
                    ['ad_id' => '', 'bid' => 30],
                    ['ad_id' => '2', 'bid' => 20],
                    ['ad_id' => '3', 'bid' => 10]
                ]);
            }
        );
    }

    private function testSkipRowsWithWrongBidPrice(): void {
        $this->assertEquals(
            "(testSkipRowsWithWrongBidPrice) Skip rows with wrong bid price",
            ['2', 10],
            function() {
                return $this->auctionProcessor->getAuctionWinnerAndSecondHighestBid([
                    ['ad_id' => '1', 'bid' => ''],
                    ['ad_id' => '2', 'bid' => 20],
                    ['ad_id' => '3', 'bid' => 10]
                ]);
            }
        );
    }

    private function testBidsWithSamePriceFirstShouldWin(): void {
        $this->assertEquals(
            "(testBidsWithSamePriceFirstShouldWin) When there are 2 bids with same price, first one should win",
            ['1', 10],
            function() {
                return $this->auctionProcessor->getAuctionWinnerAndSecondHighestBid([
                    ['ad_id' => '1', 'bid' => 20],
                    ['ad_id' => '2', 'bid' => 20],
                    ['ad_id' => '3', 'bid' => 10]
                ]);
            }
        );
    }

    private function testEmptyData(): void {
        $this->assertThrows(
            "(testEmptyData) Should throw error when no bids were found",
            \Exception::class,
            function (){
                $this->auctionProcessor->getAuctionWinnerAndSecondHighestBid([]);
            }
        );
    }

    private function testIfOnlyOneBidExistItShouldWin(): void {
        $this->assertEquals(
            "(testIfOnlyOneBidExistItShouldWin) When there is only 1 bid, this bid should win",
            ['1', 10],
            function() {
                return $this->auctionProcessor->getAuctionWinnerAndSecondHighestBid([
                    ['ad_id' => '1', 'bid' => 10]
                ]);
            }
        );
    }

    private function testOnlyBidsWithSamePriceFirstShouldWin(): void {
        $this->assertEquals(
            "(testOnlyBidsWithSamePriceFirstShouldWin) When all bids are with same price, first bid should win",
            ['1', 10],
            function() {
                return $this->auctionProcessor->getAuctionWinnerAndSecondHighestBid([
                    ['ad_id' => '1', 'bid' => 10],
                    ['ad_id' => '2', 'bid' => 10],
                ]);
            }
        );
    }
}