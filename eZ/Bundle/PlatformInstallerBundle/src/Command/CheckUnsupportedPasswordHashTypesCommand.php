<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\PlatformInstallerBundle\Command;

use Doctrine\DBAL\Connection;
use eZ\Publish\API\Repository\Values\User\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class CheckUnsupportedPasswordHashTypesCommand extends Command
{
    /** @var \Doctrine\DBAL\Connection */
    private $connection;

    public function __construct(
        Connection $connection
    ) {
        $this->connection = $connection;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('ezplatform:check-unsupported-password-hash-types');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $unsupportedHashesCounter = $this->countUnsupportedHashTypes();

        if ($unsupportedHashesCounter > 0) {
            $output->writeln(sprintf('<error>Found %s users with unsupported password hash types</error>', $unsupportedHashesCounter));
            $output->writeln('<info>For more details check documentation:</info> <href=https://doc.ezplatform.com/en/latest/releases/ez_platform_v3.0_deprecations/#password-hashes>https://doc.ezplatform.com/en/latest/releases/ez_platform_v3.0_deprecations/#password-hashes</>');
        } else {
            $output->writeln('OK - <info>All users have supported password hash types</info>');
        }

        return Command::SUCCESS;
    }

    private function countUnsupportedHashTypes(): int
    {
        $selectQuery = $this->connection->createQueryBuilder();

        $selectQuery
            ->select('count(u.login)')
            ->from('ezuser', 'u')
            ->andWhere(
                $selectQuery->expr()->notIn('u.password_hash_type', User::SUPPORTED_PASSWORD_HASHES)
            );

        return $selectQuery
            ->execute()
            ->fetchColumn();
    }
}
