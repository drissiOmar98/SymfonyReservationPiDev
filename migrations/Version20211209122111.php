<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211209122111 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE banque (id INT AUTO_INCREMENT NOT NULL, nom_banque VARCHAR(255) NOT NULL, code INT NOT NULL, pass INT NOT NULL, solde INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE books (id INT AUTO_INCREMENT NOT NULL, equipement VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, etat VARCHAR(255) NOT NULL, employe VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE calendar (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL, start DATETIME NOT NULL, end DATETIME NOT NULL, description LONGTEXT NOT NULL, all_day TINYINT(1) NOT NULL, background_color VARCHAR(7) NOT NULL, border_color VARCHAR(7) NOT NULL, text_color VARCHAR(7) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (idcategorie INT AUTO_INCREMENT NOT NULL, id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, INDEX id (id), PRIMARY KEY(idcategorie)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, post_id INT DEFAULT NULL, content TINYTEXT NOT NULL, active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_67F068BC4B89032C (post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaires (id INT AUTO_INCREMENT NOT NULL, nom_user VARCHAR(255) NOT NULL, prenom_user VARCHAR(255) NOT NULL, comm VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE detail_reservation (iddetail VARCHAR(255) NOT NULL, idH VARCHAR(255) NOT NULL, idT VARCHAR(255) NOT NULL, idV VARCHAR(255) NOT NULL, idoffr VARCHAR(255) NOT NULL, idCli VARCHAR(255) NOT NULL, ideven VARCHAR(255) NOT NULL, prixT INT NOT NULL, INDEX idT (idT), INDEX idH (idH), INDEX idV (idV), UNIQUE INDEX idCli (idCli), PRIMARY KEY(iddetail)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE detail_t (id INT AUTO_INCREMENT NOT NULL, transport_id INT DEFAULT NULL, marque VARCHAR(255) NOT NULL, etat VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, date_creation DATETIME NOT NULL, date_modification DATETIME NOT NULL, UNIQUE INDEX UNIQ_B1447D339909C13F (transport_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE events (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, period INT NOT NULL, location VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, date DATETIME NOT NULL, available VARCHAR(255) NOT NULL, prix INT NOT NULL, INDEX idevent (id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE factures_clients (banque_id INT DEFAULT NULL, id_Fac INT AUTO_INCREMENT NOT NULL, nom_client VARCHAR(42) NOT NULL, date_fac DATE NOT NULL, reglement_fac VARCHAR(42) NOT NULL, etat_fac VARCHAR(42) NOT NULL, TVA_fac INT NOT NULL, remise_fac INT NOT NULL, NB_fac VARCHAR(42) NOT NULL, Totale_fac INT NOT NULL, INDEX IDX_2BAB04F37E080D9 (banque_id), PRIMARY KEY(id_Fac)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fav (idFav VARCHAR(100) NOT NULL, idoffre VARCHAR(100) NOT NULL, VL INT NOT NULL, datelike DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX idoffre (idoffre), PRIMARY KEY(idFav)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hotel (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, etoile INT NOT NULL, hebergement VARCHAR(100) NOT NULL, lieu VARCHAR(100) NOT NULL, path VARCHAR(255) NOT NULL, Path_video VARCHAR(255) NOT NULL, chambre VARCHAR(100) NOT NULL, prix DOUBLE PRECISION NOT NULL, dateValidation DATE NOT NULL, INDEX idH (id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lieu (hootels_id INT DEFAULT NULL, IdL INT AUTO_INCREMENT NOT NULL, lieux VARCHAR(255) NOT NULL, INDEX IDX_2F577D5957FD335D (hootels_id), PRIMARY KEY(IdL)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maison (Id INT AUTO_INCREMENT NOT NULL, Lieu VARCHAR(255) NOT NULL, Hebergement VARCHAR(255) NOT NULL, Prix INT NOT NULL, Nom VARCHAR(255) NOT NULL, PRIMARY KEY(Id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre (id INT AUTO_INCREMENT NOT NULL, id_res INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, date_validite DATETIME NOT NULL, taux_de_remise VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, Path_video VARCHAR(255) NOT NULL, prix INT NOT NULL, INDEX id_reservation (id_res), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier (idPanier INT AUTO_INCREMENT NOT NULL, idH VARCHAR(255) DEFAULT NULL, INDEX idH (idH), PRIMARY KEY(idPanier)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_dislike (id INT AUTO_INCREMENT NOT NULL, post_id INT DEFAULT NULL, INDEX IDX_C3D35B994B89032C (post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_l (id INT AUTO_INCREMENT NOT NULL, post_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_653627B84B89032C (post_id), INDEX IDX_653627B8A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_like (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, post_id INT DEFAULT NULL, INDEX IDX_653627B84B89032C (post_id), INDEX IDX_653627B8A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservaide (id INT AUTO_INCREMENT NOT NULL, id_patient VARCHAR(255) NOT NULL, id_aide VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, img VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation_panier (id INT AUTO_INCREMENT NOT NULL, items LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', prix DOUBLE PRECISION NOT NULL, date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resevation (referance INT DEFAULT NULL, numv INT DEFAULT NULL, idR INT AUTO_INCREMENT NOT NULL, etat VARCHAR(200) NOT NULL, pos_map VARCHAR(255) NOT NULL, prixT INT NOT NULL, datereservation DATETIME NOT NULL, idHo INT DEFAULT NULL, INDEX idRes (idR), INDEX idHo (idHo), INDEX referance (referance), INDEX numv (numv), PRIMARY KEY(idR)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE saisonoffre (idsaison INT AUTO_INCREMENT NOT NULL, id INT DEFAULT NULL, titresaison VARCHAR(255) NOT NULL, INDEX id (id), PRIMARY KEY(idsaison)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transport (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, availability VARCHAR(255) NOT NULL, driver VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, apartir VARCHAR(255) NOT NULL, vers VARCHAR(255) NOT NULL, date DATE NOT NULL, prix INT NOT NULL, INDEX reference (id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, Nom VARCHAR(255) NOT NULL, Prenom VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', Cin INT NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, image_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE userlike (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vol (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, apartir VARCHAR(255) NOT NULL, vers VARCHAR(255) NOT NULL, dated DATE NOT NULL, path VARCHAR(255) NOT NULL, chauffeur VARCHAR(255) NOT NULL, prix INT NOT NULL, UNIQUE INDEX numv (id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categorie ADD CONSTRAINT FK_497DD634BF396750 FOREIGN KEY (id) REFERENCES events (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC4B89032C FOREIGN KEY (post_id) REFERENCES offre (id)');
        $this->addSql('ALTER TABLE detail_t ADD CONSTRAINT FK_B1447D339909C13F FOREIGN KEY (transport_id) REFERENCES transport (id)');
        $this->addSql('ALTER TABLE factures_clients ADD CONSTRAINT FK_2BAB04F37E080D9 FOREIGN KEY (banque_id) REFERENCES banque (id)');
        $this->addSql('ALTER TABLE lieu ADD CONSTRAINT FK_2F577D5957FD335D FOREIGN KEY (hootels_id) REFERENCES hotel (id)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FE7163212 FOREIGN KEY (id_res) REFERENCES reservation_panier (id)');
        $this->addSql('ALTER TABLE post_dislike ADD CONSTRAINT FK_C3D35B994B89032C FOREIGN KEY (post_id) REFERENCES offre (id)');
        $this->addSql('ALTER TABLE post_l ADD CONSTRAINT FK_F2D7EFE84B89032C FOREIGN KEY (post_id) REFERENCES events (id)');
        $this->addSql('ALTER TABLE post_l ADD CONSTRAINT FK_F2D7EFE8A76ED395 FOREIGN KEY (user_id) REFERENCES userlike (id)');
        $this->addSql('ALTER TABLE post_like ADD CONSTRAINT FK_653627B8A76ED395 FOREIGN KEY (user_id) REFERENCES userlike (id)');
        $this->addSql('ALTER TABLE post_like ADD CONSTRAINT FK_653627B84B89032C FOREIGN KEY (post_id) REFERENCES offre (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE resevation ADD CONSTRAINT FK_6E8E407B21C1DE44 FOREIGN KEY (referance) REFERENCES transport (id)');
        $this->addSql('ALTER TABLE resevation ADD CONSTRAINT FK_6E8E407BC1B23474 FOREIGN KEY (numv) REFERENCES vol (id)');
        $this->addSql('ALTER TABLE resevation ADD CONSTRAINT FK_6E8E407BCD19BDAD FOREIGN KEY (idHo) REFERENCES hotel (id)');
        $this->addSql('ALTER TABLE saisonoffre ADD CONSTRAINT FK_C6D96888BF396750 FOREIGN KEY (id) REFERENCES offre (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE factures_clients DROP FOREIGN KEY FK_2BAB04F37E080D9');
        $this->addSql('ALTER TABLE categorie DROP FOREIGN KEY FK_497DD634BF396750');
        $this->addSql('ALTER TABLE post_l DROP FOREIGN KEY FK_F2D7EFE84B89032C');
        $this->addSql('ALTER TABLE lieu DROP FOREIGN KEY FK_2F577D5957FD335D');
        $this->addSql('ALTER TABLE resevation DROP FOREIGN KEY FK_6E8E407BCD19BDAD');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC4B89032C');
        $this->addSql('ALTER TABLE post_dislike DROP FOREIGN KEY FK_C3D35B994B89032C');
        $this->addSql('ALTER TABLE post_like DROP FOREIGN KEY FK_653627B84B89032C');
        $this->addSql('ALTER TABLE saisonoffre DROP FOREIGN KEY FK_C6D96888BF396750');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866FE7163212');
        $this->addSql('ALTER TABLE detail_t DROP FOREIGN KEY FK_B1447D339909C13F');
        $this->addSql('ALTER TABLE resevation DROP FOREIGN KEY FK_6E8E407B21C1DE44');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE post_l DROP FOREIGN KEY FK_F2D7EFE8A76ED395');
        $this->addSql('ALTER TABLE post_like DROP FOREIGN KEY FK_653627B8A76ED395');
        $this->addSql('ALTER TABLE resevation DROP FOREIGN KEY FK_6E8E407BC1B23474');
        $this->addSql('DROP TABLE banque');
        $this->addSql('DROP TABLE books');
        $this->addSql('DROP TABLE calendar');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE commentaires');
        $this->addSql('DROP TABLE detail_reservation');
        $this->addSql('DROP TABLE detail_t');
        $this->addSql('DROP TABLE events');
        $this->addSql('DROP TABLE factures_clients');
        $this->addSql('DROP TABLE fav');
        $this->addSql('DROP TABLE hotel');
        $this->addSql('DROP TABLE lieu');
        $this->addSql('DROP TABLE maison');
        $this->addSql('DROP TABLE offre');
        $this->addSql('DROP TABLE panier');
        $this->addSql('DROP TABLE post_dislike');
        $this->addSql('DROP TABLE post_l');
        $this->addSql('DROP TABLE post_like');
        $this->addSql('DROP TABLE reservaide');
        $this->addSql('DROP TABLE reservation_panier');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE resevation');
        $this->addSql('DROP TABLE saisonoffre');
        $this->addSql('DROP TABLE transport');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE userlike');
        $this->addSql('DROP TABLE vol');
    }
}
