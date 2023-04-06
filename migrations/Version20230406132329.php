<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230406132329 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE acquisition ADD address_id INT NOT NULL, ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE acquisition ADD CONSTRAINT FK_2FEB9033F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE acquisition ADD CONSTRAINT FK_2FEB9033A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_2FEB9033F5B7AF75 ON acquisition (address_id)');
        $this->addSql('CREATE INDEX IDX_2FEB9033A76ED395 ON acquisition (user_id)');
        $this->addSql('ALTER TABLE address ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F81A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_D4E6F81A76ED395 ON address (user_id)');
        $this->addSql('ALTER TABLE annonce ADD user_id INT NOT NULL, ADD acquisition_id INT NOT NULL');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E56F52F3C FOREIGN KEY (acquisition_id) REFERENCES acquisition (id)');
        $this->addSql('CREATE INDEX IDX_F65593E5A76ED395 ON annonce (user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F65593E56F52F3C ON annonce (acquisition_id)');
        $this->addSql('ALTER TABLE commentary ADD annonce_id INT DEFAULT NULL, ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE commentary ADD CONSTRAINT FK_1CAC12CA8805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id)');
        $this->addSql('ALTER TABLE commentary ADD CONSTRAINT FK_1CAC12CAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_1CAC12CA8805AB2F ON commentary (annonce_id)');
        $this->addSql('CREATE INDEX IDX_1CAC12CAA76ED395 ON commentary (user_id)');
        $this->addSql('ALTER TABLE user ADD bank_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64911C8FB41 FOREIGN KEY (bank_id) REFERENCES bank (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64911C8FB41 ON user (bank_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE acquisition DROP FOREIGN KEY FK_2FEB9033F5B7AF75');
        $this->addSql('ALTER TABLE acquisition DROP FOREIGN KEY FK_2FEB9033A76ED395');
        $this->addSql('DROP INDEX IDX_2FEB9033F5B7AF75 ON acquisition');
        $this->addSql('DROP INDEX IDX_2FEB9033A76ED395 ON acquisition');
        $this->addSql('ALTER TABLE acquisition DROP address_id, DROP user_id');
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F81A76ED395');
        $this->addSql('DROP INDEX IDX_D4E6F81A76ED395 ON address');
        $this->addSql('ALTER TABLE address DROP user_id');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5A76ED395');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E56F52F3C');
        $this->addSql('DROP INDEX IDX_F65593E5A76ED395 ON annonce');
        $this->addSql('DROP INDEX UNIQ_F65593E56F52F3C ON annonce');
        $this->addSql('ALTER TABLE annonce DROP user_id, DROP acquisition_id');
        $this->addSql('ALTER TABLE commentary DROP FOREIGN KEY FK_1CAC12CA8805AB2F');
        $this->addSql('ALTER TABLE commentary DROP FOREIGN KEY FK_1CAC12CAA76ED395');
        $this->addSql('DROP INDEX IDX_1CAC12CA8805AB2F ON commentary');
        $this->addSql('DROP INDEX IDX_1CAC12CAA76ED395 ON commentary');
        $this->addSql('ALTER TABLE commentary DROP annonce_id, DROP user_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64911C8FB41');
        $this->addSql('DROP INDEX UNIQ_8D93D64911C8FB41 ON user');
        $this->addSql('ALTER TABLE user DROP bank_id');
    }
}
