<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241217080340 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE articles (id INT AUTO_INCREMENT NOT NULL, createAt DATETIME NOT NULL, libelle VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, qteStock INT NOT NULL, reference VARCHAR(255) NOT NULL, updateAt DATETIME NOT NULL, UNIQUE INDEX UNIQ_BFDD3168A4D60759 (libelle), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clients (id INT AUTO_INCREMENT NOT NULL, compte_id INT DEFAULT NULL, adresse VARCHAR(255) NOT NULL, createAt DATETIME NOT NULL, surname VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, updateAt DATETIME NOT NULL, UNIQUE INDEX UNIQ_C82E74E7769B0F (surname), UNIQUE INDEX UNIQ_C82E74450FF010 (telephone), UNIQUE INDEX UNIQ_C82E74F2C56620 (compte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comptes (id INT AUTO_INCREMENT NOT NULL, createAt DATETIME NOT NULL, email VARCHAR(255) NOT NULL, isActive TINYINT(1) NOT NULL, login VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, role INT NOT NULL, updateAt DATETIME NOT NULL, UNIQUE INDEX UNIQ_56735801E7927C74 (email), UNIQUE INDEX UNIQ_56735801AA08CB10 (login), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demandes (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, createAt DATETIME NOT NULL, montant DOUBLE PRECISION NOT NULL, updateAt DATETIME NOT NULL, etat INT NOT NULL, INDEX IDX_BD940CBB19EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE details (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, dette_id INT NOT NULL, createAt DATETIME NOT NULL, prix DOUBLE PRECISION NOT NULL, qte INT NOT NULL, total DOUBLE PRECISION NOT NULL, updateAt DATETIME NOT NULL, INDEX IDX_72260B8A7294869C (article_id), INDEX IDX_72260B8AE11400A1 (dette_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE details_demande (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, damande_id INT NOT NULL, createAt DATETIME NOT NULL, prix DOUBLE PRECISION NOT NULL, qte INT NOT NULL, total DOUBLE PRECISION NOT NULL, updateAt DATETIME NOT NULL, INDEX IDX_C0C7AEB47294869C (article_id), INDEX IDX_C0C7AEB4DD050F14 (damande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dettes (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, createAt DATETIME NOT NULL, montant DOUBLE PRECISION NOT NULL, updateAt DATETIME NOT NULL, isSolde TINYINT(1) NOT NULL, montant_verser DOUBLE PRECISION NOT NULL, INDEX IDX_15565CF119EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE paiements (id INT AUTO_INCREMENT NOT NULL, dette_id INT NOT NULL, createAt DATETIME NOT NULL, montant DOUBLE PRECISION NOT NULL, updateAt DATETIME NOT NULL, INDEX IDX_E1B02E12E11400A1 (dette_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE clients ADD CONSTRAINT FK_C82E74F2C56620 FOREIGN KEY (compte_id) REFERENCES comptes (id)');
        $this->addSql('ALTER TABLE demandes ADD CONSTRAINT FK_BD940CBB19EB6921 FOREIGN KEY (client_id) REFERENCES clients (id)');
        $this->addSql('ALTER TABLE details ADD CONSTRAINT FK_72260B8A7294869C FOREIGN KEY (article_id) REFERENCES articles (id)');
        $this->addSql('ALTER TABLE details ADD CONSTRAINT FK_72260B8AE11400A1 FOREIGN KEY (dette_id) REFERENCES dettes (id)');
        $this->addSql('ALTER TABLE details_demande ADD CONSTRAINT FK_C0C7AEB47294869C FOREIGN KEY (article_id) REFERENCES articles (id)');
        $this->addSql('ALTER TABLE details_demande ADD CONSTRAINT FK_C0C7AEB4DD050F14 FOREIGN KEY (damande_id) REFERENCES demandes (id)');
        $this->addSql('ALTER TABLE dettes ADD CONSTRAINT FK_15565CF119EB6921 FOREIGN KEY (client_id) REFERENCES clients (id)');
        $this->addSql('ALTER TABLE paiements ADD CONSTRAINT FK_E1B02E12E11400A1 FOREIGN KEY (dette_id) REFERENCES dettes (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clients DROP FOREIGN KEY FK_C82E74F2C56620');
        $this->addSql('ALTER TABLE demandes DROP FOREIGN KEY FK_BD940CBB19EB6921');
        $this->addSql('ALTER TABLE details DROP FOREIGN KEY FK_72260B8A7294869C');
        $this->addSql('ALTER TABLE details DROP FOREIGN KEY FK_72260B8AE11400A1');
        $this->addSql('ALTER TABLE details_demande DROP FOREIGN KEY FK_C0C7AEB47294869C');
        $this->addSql('ALTER TABLE details_demande DROP FOREIGN KEY FK_C0C7AEB4DD050F14');
        $this->addSql('ALTER TABLE dettes DROP FOREIGN KEY FK_15565CF119EB6921');
        $this->addSql('ALTER TABLE paiements DROP FOREIGN KEY FK_E1B02E12E11400A1');
        $this->addSql('DROP TABLE articles');
        $this->addSql('DROP TABLE clients');
        $this->addSql('DROP TABLE comptes');
        $this->addSql('DROP TABLE demandes');
        $this->addSql('DROP TABLE details');
        $this->addSql('DROP TABLE details_demande');
        $this->addSql('DROP TABLE dettes');
        $this->addSql('DROP TABLE paiements');
    }
}
