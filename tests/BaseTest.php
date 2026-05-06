<?php

namespace tests;

abstract class BaseTest
{
    protected int $passed = 0;
    protected int $failed = 0;

    protected function assertEquals(string $message, mixed $expected, callable $execution): void
    {
        try {
            $actual = $execution();

            if ($expected === $actual) {
                $this->passed++;
                echo "✅ PASS: $message" . PHP_EOL;
            } else {
                $this->failed++;
                echo "❌ FAIL: $message" . PHP_EOL;
                echo "   -> Expected: " . json_encode($expected) . PHP_EOL;
                echo "   -> Actual:   " . json_encode($actual) . PHP_EOL;
            }
        } catch (\Exception $e) {
            $this->failed++;
            echo "❌ FAIL: $message (Logic crashed unexpectedly)" . PHP_EOL;
            echo "   -> Error: " . $e->getMessage() . PHP_EOL;
        }
    }

    protected function assertThrows(string $message, string $expectedExceptionClass, callable $code): void {
        try {
            $code();
            $this->failed++;
            echo "❌ FAIL: $message (Expected exception $expectedExceptionClass was not thrown)" . PHP_EOL;
        } catch (\Exception $e) {
            if ($e instanceof $expectedExceptionClass) {
                $this->passed++;
                echo "✅ PASS: $message (Caught expected " . get_class($e) . ")" . PHP_EOL;
            } else {
                $this->failed++;
                echo "❌ FAIL: $message (Caught " . get_class($e) . " but expected $expectedExceptionClass)" . PHP_EOL;
            }
        }
    }

    abstract public function run(): void;

    public function printSummary(): void
    {
        echo "\n--- Final Results ---\n";
        echo "Passed: {$this->passed} | Failed: {$this->failed}\n";
    }

    public function hasFailed(): bool {
        return $this->failed > 0;
    }
}