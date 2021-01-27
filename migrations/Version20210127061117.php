<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210127061117 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_9474526CA76ED395');
        $this->addSql('DROP INDEX IDX_9474526C4B89032C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, post_id, user_id, content, created FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, post_id INTEGER DEFAULT NULL, user_id INTEGER DEFAULT NULL, content CLOB NOT NULL COLLATE BINARY, created DATETIME NOT NULL, CONSTRAINT FK_9474526C4B89032C FOREIGN KEY (post_id) REFERENCES post (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO comment (id, post_id, user_id, content, created) SELECT id, post_id, user_id, content, created FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE INDEX IDX_9474526CA76ED395 ON comment (user_id)');
        $this->addSql('CREATE INDEX IDX_9474526C4B89032C ON comment (post_id)');
        $this->addSql('DROP INDEX IDX_AC6340B3A76ED395');
        $this->addSql('DROP INDEX IDX_AC6340B34B89032C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__like AS SELECT id, user_id, post_id FROM "like"');
        $this->addSql('DROP TABLE "like"');
        $this->addSql('CREATE TABLE "like" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, post_id INTEGER DEFAULT NULL, CONSTRAINT FK_AC6340B3A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_AC6340B34B89032C FOREIGN KEY (post_id) REFERENCES post (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO "like" (id, user_id, post_id) SELECT id, user_id, post_id FROM __temp__like');
        $this->addSql('DROP TABLE __temp__like');
        $this->addSql('CREATE INDEX IDX_AC6340B3A76ED395 ON "like" (user_id)');
        $this->addSql('CREATE INDEX IDX_AC6340B34B89032C ON "like" (post_id)');
        $this->addSql('DROP INDEX IDX_5A8A6C8DA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__post AS SELECT id, user_id, title, description, photo, created FROM post');
        $this->addSql('DROP TABLE post');
        $this->addSql('CREATE TABLE post (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, description CLOB NOT NULL COLLATE BINARY, photo VARCHAR(255) DEFAULT NULL COLLATE BINARY, created DATETIME NOT NULL, CONSTRAINT FK_5A8A6C8DA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO post (id, user_id, title, description, photo, created) SELECT id, user_id, title, description, photo, created FROM __temp__post');
        $this->addSql('DROP TABLE __temp__post');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DA76ED395 ON post (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_9474526C4B89032C');
        $this->addSql('DROP INDEX IDX_9474526CA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, post_id, user_id, content, created FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, post_id INTEGER DEFAULT NULL, user_id INTEGER DEFAULT NULL, content CLOB NOT NULL, created DATETIME NOT NULL)');
        $this->addSql('INSERT INTO comment (id, post_id, user_id, content, created) SELECT id, post_id, user_id, content, created FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE INDEX IDX_9474526C4B89032C ON comment (post_id)');
        $this->addSql('CREATE INDEX IDX_9474526CA76ED395 ON comment (user_id)');
        $this->addSql('DROP INDEX IDX_AC6340B3A76ED395');
        $this->addSql('DROP INDEX IDX_AC6340B34B89032C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__like AS SELECT id, user_id, post_id FROM "like"');
        $this->addSql('DROP TABLE "like"');
        $this->addSql('CREATE TABLE "like" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, post_id INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO "like" (id, user_id, post_id) SELECT id, user_id, post_id FROM __temp__like');
        $this->addSql('DROP TABLE __temp__like');
        $this->addSql('CREATE INDEX IDX_AC6340B3A76ED395 ON "like" (user_id)');
        $this->addSql('CREATE INDEX IDX_AC6340B34B89032C ON "like" (post_id)');
        $this->addSql('DROP INDEX IDX_5A8A6C8DA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__post AS SELECT id, user_id, title, description, photo, created FROM post');
        $this->addSql('DROP TABLE post');
        $this->addSql('CREATE TABLE post (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL, description CLOB NOT NULL, photo VARCHAR(255) DEFAULT NULL, created DATETIME NOT NULL)');
        $this->addSql('INSERT INTO post (id, user_id, title, description, photo, created) SELECT id, user_id, title, description, photo, created FROM __temp__post');
        $this->addSql('DROP TABLE __temp__post');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DA76ED395 ON post (user_id)');
    }
}
