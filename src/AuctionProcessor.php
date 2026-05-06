<?php

namespace src;

class AuctionProcessor
{
    public function getAuctionWinnerAndSecondHighestBid(iterable $rows): array
    {
        $adID = null;
        $highestBid = -1;
        $secondHighestBid = -1;

        foreach ($rows as $row){
            $bid = $row['bid'];
            $tempAdID = $row['ad_id'];

            if(!$this->isValidAdID($tempAdID)) continue;
            if(!$this->isValidBid($bid)) continue;

            if($bid > $highestBid){
                $secondHighestBid = $highestBid;
                $adID = $tempAdID;
                $highestBid = $bid;
            }else if($bid > $secondHighestBid && $bid != $highestBid){
                $secondHighestBid = $bid;
            }
        }

        if(is_null($adID) || $highestBid < 0){
            throw new \Exception("Not enough valid bids to determine a winner.");
        }

        if($secondHighestBid < 0){
            $secondHighestBid = $highestBid;//if $secondHighestBid < 0 it means all bids are with same price or there is only 1 bid
        }

        return [$adID, $secondHighestBid];
    }

    private function isValidAdID($adID): bool
    {
        return !empty($adID);
    }

    private function isValidBid($bid): bool
    {
        return is_numeric($bid) && $bid > 0;
    }
}