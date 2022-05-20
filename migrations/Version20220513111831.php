<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220513111831 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE billing DROP FOREIGN KEY FK1');
        $this->addSql('ALTER TABLE billing CHANGE id_user id_user INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE billing ADD CONSTRAINT FK_EC224CAA6B3CA4B FOREIGN KEY (id_user) REFERENCES users (id_user)');
        $this->addSql('ALTER TABLE features CHANGE game_desc game_desc LONGTEXT NOT NULL, CHANGE game_stock game_stock INT UNSIGNED NOT NULL, CHANGE min_req min_req LONGTEXT NOT NULL, CHANGE max_req max_req LONGTEXT NOT NULL, CHANGE game_price game_price NUMERIC(5, 2) NOT NULL, CHANGE game_discount game_discount INT UNSIGNED NOT NULL, CHANGE game_valoration game_valoration NUMERIC(2, 1) NOT NULL');
        $this->addSql('ALTER TABLE game_keys DROP FOREIGN KEY FK8');
        $this->addSql('ALTER TABLE game_keys DROP FOREIGN KEY FK7');
        $this->addSql('ALTER TABLE game_keys DROP FOREIGN KEY FK9');
        $this->addSql('ALTER TABLE game_keys CHANGE id_platform id_platform INT UNSIGNED DEFAULT NULL, CHANGE id_game id_game INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE game_keys ADD CONSTRAINT FK_5F9B28C069893C5E FOREIGN KEY (id_platform) REFERENCES platforms (id_platform)');
        $this->addSql('ALTER TABLE game_keys ADD CONSTRAINT FK_5F9B28C01BACD2A8 FOREIGN KEY (id_order) REFERENCES orders (id_order)');
        $this->addSql('ALTER TABLE game_keys ADD CONSTRAINT FK_5F9B28C0A80B2D8E FOREIGN KEY (id_game) REFERENCES games (id_game)');
        $this->addSql('ALTER TABLE games_platform DROP FOREIGN KEY FK5');
        $this->addSql('ALTER TABLE games_platform DROP FOREIGN KEY FK20');
        $this->addSql('ALTER TABLE games_platform DROP FOREIGN KEY FK6');
        $this->addSql('ALTER TABLE games_platform CHANGE id_feature id_feature INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE games_platform ADD CONSTRAINT FK_9055B7F7C14ADC16 FOREIGN KEY (id_feature) REFERENCES features (id_feature)');
        $this->addSql('ALTER TABLE games_platform ADD CONSTRAINT FK_9055B7F769893C5E FOREIGN KEY (id_platform) REFERENCES platforms (id_platform)');
        $this->addSql('ALTER TABLE games_platform ADD CONSTRAINT FK_9055B7F7E48FD905 FOREIGN KEY (game_id) REFERENCES games (id_game)');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK12');
        $this->addSql('ALTER TABLE media CHANGE id_game id_game INT UNSIGNED DEFAULT NULL, CHANGE media_InfoImg media_InfoImg TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10CA80B2D8E FOREIGN KEY (id_game) REFERENCES games (id_game)');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK3');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK2');
        $this->addSql('ALTER TABLE orders CHANGE id_user id_user INT UNSIGNED DEFAULT NULL, CHANGE id_billing id_billing INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE6B3CA4B FOREIGN KEY (id_user) REFERENCES users (id_user)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE32BFE5DA FOREIGN KEY (id_billing) REFERENCES billing (id_billing)');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK15');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK14');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY Fk16');
        $this->addSql('ALTER TABLE reviews DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0FA80B2D8E FOREIGN KEY (id_game) REFERENCES games (id_game)');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0F89B967A8 FOREIGN KEY (id_plaftorm) REFERENCES platforms (id_platform)');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0F6B3CA4B FOREIGN KEY (id_user) REFERENCES users (id_user)');
        $this->addSql('ALTER TABLE reviews ADD PRIMARY KEY (id_game, id_plaftorm, id_user)');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK4');
        $this->addSql('ALTER TABLE users CHANGE user_wishlist user_wishlist INT UNSIGNED DEFAULT NULL, CHANGE user_name user_name VARCHAR(20) NOT NULL, CHANGE user_email user_email VARCHAR(50) NOT NULL, CHANGE user_pass user_pass VARCHAR(60) NOT NULL, CHANGE user_img user_img VARCHAR(50) DEFAULT \'default\', CHANGE user_rol user_rol VARCHAR(255) DEFAULT \'ROLE_USER\', CHANGE user_state user_state VARCHAR(255) DEFAULT \'ACTIVE\'');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E97C6CCE31 FOREIGN KEY (user_wishlist) REFERENCES wishlist (id_wishlist)');
        $this->addSql('ALTER TABLE wishlist_games DROP FOREIGN KEY FK11');
        $this->addSql('ALTER TABLE wishlist_games DROP FOREIGN KEY FK10');
        $this->addSql('ALTER TABLE wishlist_games DROP FOREIGN KEY FK13');
        $this->addSql('ALTER TABLE wishlist_games DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE wishlist_games ADD CONSTRAINT FK_AB8643C9A80B2D8E FOREIGN KEY (id_game) REFERENCES games (id_game)');
        $this->addSql('ALTER TABLE wishlist_games ADD CONSTRAINT FK_AB8643C969893C5E FOREIGN KEY (id_platform) REFERENCES platforms (id_platform)');
        $this->addSql('ALTER TABLE wishlist_games ADD CONSTRAINT FK_AB8643C9CC3AC6A4 FOREIGN KEY (id_wishlist) REFERENCES wishlist (id_wishlist)');
        $this->addSql('ALTER TABLE wishlist_games ADD PRIMARY KEY (id_game, id_platform, id_wishlist)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE billing DROP FOREIGN KEY FK_EC224CAA6B3CA4B');
        $this->addSql('ALTER TABLE billing CHANGE id_user id_user INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE billing ADD CONSTRAINT FK1 FOREIGN KEY (id_user) REFERENCES users (id_user) ON UPDATE CASCADE');
        $this->addSql('ALTER TABLE features CHANGE game_desc game_desc LONGTEXT NOT NULL COLLATE `utf8mb4_bin`, CHANGE game_stock game_stock INT UNSIGNED DEFAULT 0 NOT NULL, CHANGE min_req min_req LONGTEXT NOT NULL COLLATE `utf8mb4_bin`, CHANGE max_req max_req LONGTEXT NOT NULL COLLATE `utf8mb4_bin`, CHANGE game_price game_price NUMERIC(5, 2) UNSIGNED NOT NULL, CHANGE game_discount game_discount INT UNSIGNED DEFAULT 0 NOT NULL, CHANGE game_valoration game_valoration NUMERIC(2, 1) UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE game_keys DROP FOREIGN KEY FK_5F9B28C069893C5E');
        $this->addSql('ALTER TABLE game_keys DROP FOREIGN KEY FK_5F9B28C01BACD2A8');
        $this->addSql('ALTER TABLE game_keys DROP FOREIGN KEY FK_5F9B28C0A80B2D8E');
        $this->addSql('ALTER TABLE game_keys CHANGE id_platform id_platform INT UNSIGNED NOT NULL, CHANGE id_game id_game INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE game_keys ADD CONSTRAINT FK8 FOREIGN KEY (id_game) REFERENCES games (id_game) ON UPDATE CASCADE');
        $this->addSql('ALTER TABLE game_keys ADD CONSTRAINT FK7 FOREIGN KEY (id_platform) REFERENCES platforms (id_platform) ON UPDATE CASCADE');
        $this->addSql('ALTER TABLE game_keys ADD CONSTRAINT FK9 FOREIGN KEY (id_order) REFERENCES orders (id_order) ON UPDATE CASCADE');
        $this->addSql('ALTER TABLE games_platform DROP FOREIGN KEY FK_9055B7F7C14ADC16');
        $this->addSql('ALTER TABLE games_platform DROP FOREIGN KEY FK_9055B7F769893C5E');
        $this->addSql('ALTER TABLE games_platform DROP FOREIGN KEY FK_9055B7F7E48FD905');
        $this->addSql('ALTER TABLE games_platform CHANGE id_feature id_feature INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE games_platform ADD CONSTRAINT FK5 FOREIGN KEY (game_id) REFERENCES games (id_game) ON UPDATE CASCADE');
        $this->addSql('ALTER TABLE games_platform ADD CONSTRAINT FK20 FOREIGN KEY (id_feature) REFERENCES features (id_feature) ON UPDATE CASCADE ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE games_platform ADD CONSTRAINT FK6 FOREIGN KEY (id_platform) REFERENCES platforms (id_platform) ON UPDATE CASCADE');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10CA80B2D8E');
        $this->addSql('ALTER TABLE media CHANGE id_game id_game INT UNSIGNED NOT NULL, CHANGE media_InfoImg media_InfoImg TINYINT(1) DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK12 FOREIGN KEY (id_game) REFERENCES games (id_game) ON UPDATE CASCADE');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE6B3CA4B');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE32BFE5DA');
        $this->addSql('ALTER TABLE orders CHANGE id_user id_user INT UNSIGNED NOT NULL, CHANGE id_billing id_billing INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK3 FOREIGN KEY (id_billing) REFERENCES billing (id_billing) ON UPDATE CASCADE');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK2 FOREIGN KEY (id_user) REFERENCES users (id_user) ON UPDATE CASCADE');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0FA80B2D8E');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0F89B967A8');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0F6B3CA4B');
        $this->addSql('ALTER TABLE reviews DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK15 FOREIGN KEY (id_user) REFERENCES users (id_user) ON UPDATE CASCADE');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK14 FOREIGN KEY (id_game) REFERENCES games (id_game) ON UPDATE CASCADE');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT Fk16 FOREIGN KEY (id_plaftorm) REFERENCES platforms (id_platform) ON UPDATE CASCADE');
        $this->addSql('ALTER TABLE reviews ADD PRIMARY KEY (id_plaftorm, id_game, id_user)');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E97C6CCE31');
        $this->addSql('ALTER TABLE users CHANGE user_wishlist user_wishlist INT UNSIGNED NOT NULL, CHANGE user_name user_name VARCHAR(100) NOT NULL, CHANGE user_email user_email VARCHAR(100) NOT NULL, CHANGE user_pass user_pass VARCHAR(100) NOT NULL, CHANGE user_img user_img VARCHAR(50) DEFAULT \'\'\'default\'\'\' NOT NULL, CHANGE user_rol user_rol VARCHAR(255) DEFAULT \'\'\'ROLE_USER\'\'\' NOT NULL, CHANGE user_state user_state VARCHAR(255) DEFAULT \'\'\'ACTIVE\'\'\' NOT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK4 FOREIGN KEY (user_wishlist) REFERENCES wishlist (id_wishlist) ON UPDATE CASCADE');
        $this->addSql('ALTER TABLE wishlist_games DROP FOREIGN KEY FK_AB8643C9A80B2D8E');
        $this->addSql('ALTER TABLE wishlist_games DROP FOREIGN KEY FK_AB8643C969893C5E');
        $this->addSql('ALTER TABLE wishlist_games DROP FOREIGN KEY FK_AB8643C9CC3AC6A4');
        $this->addSql('ALTER TABLE wishlist_games DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE wishlist_games ADD CONSTRAINT FK11 FOREIGN KEY (id_wishlist) REFERENCES wishlist (id_wishlist) ON UPDATE CASCADE');
        $this->addSql('ALTER TABLE wishlist_games ADD CONSTRAINT FK10 FOREIGN KEY (id_game) REFERENCES games (id_game) ON UPDATE CASCADE');
        $this->addSql('ALTER TABLE wishlist_games ADD CONSTRAINT FK13 FOREIGN KEY (id_platform) REFERENCES platforms (id_platform) ON UPDATE CASCADE');
        $this->addSql('ALTER TABLE wishlist_games ADD PRIMARY KEY (id_game, id_wishlist, id_platform)');
    }
}
