<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250511193115 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE traffic_returns (id INT AUTO_INCREMENT NOT NULL, company_id INT DEFAULT NULL, campaign_id INT DEFAULT NULL, traffic_source_id INT DEFAULT NULL, date DATETIME NOT NULL, amount NUMERIC(10, 2) NOT NULL, INDEX IDX_2EF9BDE2979B1AD6 (company_id), INDEX IDX_2EF9BDE2F639F774 (campaign_id), INDEX IDX_2EF9BDE2E0BEA2C6 (traffic_source_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE traffic_sources (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, image VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE traffic_returns ADD CONSTRAINT FK_2EF9BDE2979B1AD6 FOREIGN KEY (company_id) REFERENCES companies (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE traffic_returns ADD CONSTRAINT FK_2EF9BDE2F639F774 FOREIGN KEY (campaign_id) REFERENCES campaigns (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE traffic_returns ADD CONSTRAINT FK_2EF9BDE2E0BEA2C6 FOREIGN KEY (traffic_source_id) REFERENCES traffic_sources (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE traffic_return DROP FOREIGN KEY FK_42DA1328979B1AD6
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE traffic_return DROP FOREIGN KEY FK_42DA1328E0BEA2C6
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE traffic_return DROP FOREIGN KEY FK_42DA1328F639F774
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE traffic_source
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE traffic_return
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE traffic_source (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, image VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE traffic_return (id INT AUTO_INCREMENT NOT NULL, company_id INT DEFAULT NULL, campaign_id INT DEFAULT NULL, traffic_source_id INT DEFAULT NULL, date DATETIME NOT NULL, amount NUMERIC(10, 2) NOT NULL, INDEX IDX_42DA1328979B1AD6 (company_id), INDEX IDX_42DA1328E0BEA2C6 (traffic_source_id), INDEX IDX_42DA1328F639F774 (campaign_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE traffic_return ADD CONSTRAINT FK_42DA1328979B1AD6 FOREIGN KEY (company_id) REFERENCES companies (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE traffic_return ADD CONSTRAINT FK_42DA1328E0BEA2C6 FOREIGN KEY (traffic_source_id) REFERENCES traffic_source (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE traffic_return ADD CONSTRAINT FK_42DA1328F639F774 FOREIGN KEY (campaign_id) REFERENCES campaigns (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE traffic_returns DROP FOREIGN KEY FK_2EF9BDE2979B1AD6
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE traffic_returns DROP FOREIGN KEY FK_2EF9BDE2F639F774
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE traffic_returns DROP FOREIGN KEY FK_2EF9BDE2E0BEA2C6
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE traffic_returns
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE traffic_sources
        SQL);
    }
}
