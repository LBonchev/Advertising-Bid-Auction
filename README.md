# Advertising Bid Auction


## Installing
1. PHP 8.0+ installed
2. Download/Clone: Extract the project files into your local directory.
3. Permissions: Permission to read the source CSV files.


## Executing program
To run the main auction processing logic or the testing suite, follow these steps:

Initialize and Run
```php index.php path_to_csv.csv```

Run the Custom Unit Test
```php tests.php```

## Business Logic Assumptions
To ensure consistent behavior across all datasets, the following logic has been implemented:

1. Single Bidder: If only one valid bid exists, that bid is declared the winner (second-highest bid logic applies only when multiple bids are present).
2. Tie-Breaking: If two or more bids have the exact same price, the one appearing first in the dataset takes precedence.
3. Zero Valid Bids: If no bids are provided, or if all provided bids contain invalid data, the system reports no winner.
4. ID Validation: Any bid with a missing or malformed Ad ID is skipped to maintain data integrity.
5. Price Validation: Bids with non-numeric prices or values less than or equal to zero are treated as invalid and skipped.

## File Validation & Requirements
To prevent execution errors and protect system resources, the program enforces the following file-level constraints:

1. Existence: The target file must exist at the specified path.
2. Readability: The system must have sufficient permissions to read the file.
3. Format: The file must have a .csv extension.
4. Column Ordering:
   * Column 1: ad_id (String/Identifier)
   * Column 2: bid (Numeric/Float)
5. Header Handling: The program is designed to automatically detect and skip the first row if it contains headers (e.g., ad_id, bid).
6. Strict Positioning: Data must strictly follow the two-column format; any additional columns are ignored, and rows with missing columns are skipped to maintain data integrity.
7. Safety: If any of these conditions are not met, the program will terminate early with a descriptive error message rather than attempting to parse invalid data.