<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190806211520 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE courses_lectors (lector_id INT NOT NULL, course_id INT NOT NULL, INDEX IDX_9D3B1723ADEC45C7 (lector_id), INDEX IDX_9D3B1723591CC992 (course_id), PRIMARY KEY(lector_id, course_id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE courses_lectors ADD CONSTRAINT FK_9D3B1723ADEC45C7 FOREIGN KEY (lector_id) REFERENCES lectors (id)');
        $this->addSql('ALTER TABLE courses_lectors ADD CONSTRAINT FK_9D3B1723591CC992 FOREIGN KEY (course_id) REFERENCES courses (id)');
        $this->addSql('ALTER TABLE articles CHANGE view_count view_count INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE courses_lectors');
        $this->addSql('ALTER TABLE articles CHANGE view_count view_count INT NOT NULL');
    }
}
