<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180831192102 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE micro_post ADD srv_usuario_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE micro_post ADD CONSTRAINT FK_2AEFE017859E0088 FOREIGN KEY (srv_usuario_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_2AEFE017859E0088 ON micro_post (srv_usuario_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE micro_post DROP FOREIGN KEY FK_2AEFE017859E0088');
        $this->addSql('DROP INDEX IDX_2AEFE017859E0088 ON micro_post');
        $this->addSql('ALTER TABLE micro_post DROP srv_usuario_id');
    }
}
