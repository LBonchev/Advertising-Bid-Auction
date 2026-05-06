<?php

namespace src;

class CsvReader
{
    const ALLOWED_EXTENSIONS = ['csv'];
    public function getRows(string $filePath): \Generator
    {
        if(!file_exists($filePath)){
            throw new \Exception("CSV file not found");
        }
        if(!is_readable($filePath)){
            throw new \Exception("CSV file not readable");
        }

        if(!$this->isAllowedExtension(pathinfo($filePath, PATHINFO_EXTENSION))){
            throw new \Exception("File extension not allowed");
        }

        $handle = fopen($filePath, "r");

        try{
            while(($data = fgetcsv($handle)) !== false){
                [$adID, $bid] = explode(";", $data[0]);
                if($adID == 'ad_id' && $bid == 'bid') continue; //skip first row from csv

                yield ['ad_id' => $adID, 'bid' => $bid];
            }
        } finally {
            fclose($handle);
        }
    }

    private function isAllowedExtension(string $ext): bool
    {
        return in_array($ext, self::ALLOWED_EXTENSIONS);
    }
}