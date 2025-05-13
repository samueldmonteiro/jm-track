<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250513010618 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE campaigns (id INT AUTO_INCREMENT NOT NULL, company_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, start_date DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', end_date DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', status VARCHAR(255) NOT NULL, INDEX IDX_E3737470979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE companies (id INT AUTO_INCREMENT NOT NULL, document VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(100) NOT NULL, email VARCHAR(100) NOT NULL, phone VARCHAR(100) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', updated_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', UNIQUE INDEX UNIQ_IDENTIFIER_DOCUMENT (document), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE traffic_sources (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, image VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE traffic_transactions (id INT AUTO_INCREMENT NOT NULL, company_id INT DEFAULT NULL, campaign_id INT DEFAULT NULL, traffic_source_id INT DEFAULT NULL, date DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', amount NUMERIC(10, 2) NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_4F6F30E6979B1AD6 (company_id), INDEX IDX_4F6F30E6F639F774 (campaign_id), INDEX IDX_4F6F30E6E0BEA2C6 (traffic_source_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE campaigns ADD CONSTRAINT FK_E3737470979B1AD6 FOREIGN KEY (company_id) REFERENCES companies (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE traffic_transactions ADD CONSTRAINT FK_4F6F30E6979B1AD6 FOREIGN KEY (company_id) REFERENCES companies (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE traffic_transactions ADD CONSTRAINT FK_4F6F30E6F639F774 FOREIGN KEY (campaign_id) REFERENCES campaigns (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE traffic_transactions ADD CONSTRAINT FK_4F6F30E6E0BEA2C6 FOREIGN KEY (traffic_source_id) REFERENCES traffic_sources (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE campaigns DROP FOREIGN KEY FK_E3737470979B1AD6
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE traffic_transactions DROP FOREIGN KEY FK_4F6F30E6979B1AD6
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE traffic_transactions DROP FOREIGN KEY FK_4F6F30E6F639F774
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE traffic_transactions DROP FOREIGN KEY FK_4F6F30E6E0BEA2C6
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE campaigns
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE companies
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE traffic_sources
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE traffic_transactions
        SQL);
    }
}
