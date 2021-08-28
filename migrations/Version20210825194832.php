<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210825194832 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE team ADD league_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F58AFC4DE FOREIGN KEY (league_id) REFERENCES league (id)');
        $this->addSql('CREATE INDEX IDX_C4E0A61F58AFC4DE ON team (league_id)');

        $this->addSql("INSERT INTO `team` (`id`, `name`, `strip`, `league_id`)
VALUES
	(2, 'Arsenal', 'Arsenal', 1),
	(3, 'Chelsea', 'Chelsea', 1),
	(4, 'Bolton', 'Bolton', 5),
	(5, 'Cambridge', 'Cambridge', 5),
	(6, 'Cheltenham', 'Cheltenham', 5),
	(7, 'Hull City', 'Hull City', 4),
	(8, 'Peterborough', 'Peterborough', 4),
	(9, 'Blackpool', 'Blackpool', 4);
");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F58AFC4DE');
        $this->addSql('DROP INDEX IDX_C4E0A61F58AFC4DE ON team');
        $this->addSql('ALTER TABLE team DROP league_id');
    }
}
