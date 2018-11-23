<?php declare(strict_types=1);

namespace App\Infrastructure\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SchemaEventStoreCreateCommand extends AbstractSchemaEventStoreCommand
{
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('broadway:event-store:schema:init')
            ->setDescription('Creates the event store schema')
            ->setHelp(
                <<<EOT
The <info>%command.name%</info> command creates the schema in the default
connections database:

<info>php app/console %command.name%</info>
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->connection) {
            $output->writeln('<error>Could not create Broadway event-store schema</error>');
            $output->writeln(sprintf('<error>%s</error>', $this->exception->getMessage()));

            return 1;
        }

        try {
            $schemaManager = $this->connection->getSchemaManager();
            $schema        = $schemaManager->createSchema();
            $eventStore    = $this->getEventStore();

            $table = $eventStore->configureSchema($schema);
            if (null !== $table) {
                $schemaManager->createTable($table);
                $output->writeln('<info>Created Broadway event-store schema</info>');
            } else {
                $output->writeln('<info>Broadway event-store schema already exists</info>');
            }
        } catch (\Exception $e) {
            $output->writeln('<error>Could not create Broadway event-store schema</error>');
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));

            return 1;
        }

        return 0;
    }
}
