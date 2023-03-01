<?php

namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class LleegoAvailCommandTest extends KernelTestCase
{
    private const TABLE_ASSERTION = '+-------------+------------------------------+------------------+------------------+------------+------------+------------------+--------------+--------------+
| Origin Code | Origin Name                  | Destination Code | Destination Name | Start      | End        | Transport Number | Company Code | Company Name |
+-------------+------------------------------+------------------+------------------+------------+------------+------------------+--------------+--------------+
| MAD         | Madrid Adolfo Suarez-Barajas | BIO              | Bilbao           | 2022-06-01 | 2022-06-01 | 0426             | IB           | Iberia       |
| MAD         | Madrid Adolfo Suarez-Barajas | BIO              | Bilbao           | 2022-06-01 | 2022-06-01 | 0438             | IB           | Iberia       |
| MAD         | Madrid Adolfo Suarez-Barajas | BIO              | Bilbao           | 2022-06-01 | 2022-06-01 | 0440             | IB           | Iberia       |
| MAD         | Madrid Adolfo Suarez-Barajas | BIO              | Bilbao           | 2022-06-01 | 2022-06-01 | 0442             | IB           | Iberia       |
| MAD         | Madrid Adolfo Suarez-Barajas | BIO              | Bilbao           | 2022-06-01 | 2022-06-01 | 0448             | IB           | Iberia       |
+-------------+------------------------------+------------------+------------------+------------+------------+------------------+--------------+--------------+';

    public function testExecuteWithValidArguments(): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('lleego:avail');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'origin' => 'MAD',
            'destination' => 'BIO',
            'date' => '2022-06-01',
        ]);

        $commandTester->assertCommandIsSuccessful();

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString(self::TABLE_ASSERTION, $output);
    }

    public function testExecuteWithInvalidArguments(): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('lleego:avail');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'origin' => 'MAD',
            'destination' => 'BIO',
            'date' => '2023-06-01',
        ]);

        $commandTester->assertCommandIsSuccessful('[WARNING] No flights found');

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('[WARNING] No flights found', $output);
    }

    public function testExecuteWithWrongDateFormat(): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('lleego:avail');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'origin' => 'MAD',
            'destination' => 'BIO',
            'date' => '1-8',
        ]);

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('[ERROR] Invalid date', $output);
    }
}