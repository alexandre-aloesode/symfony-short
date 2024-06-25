<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240624162415 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C67799D86650F');
        $this->addSql('DROP INDEX IDX_AF3C67799D86650F ON publication');
        $this->addSql('ALTER TABLE publication CHANGE user_id user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C67799D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_AF3C67799D86650F ON publication (user_id_id)');
        $this->addSql('ALTER TABLE publication_comments DROP FOREIGN KEY FK_70F9637B9A9AD8DB');
        $this->addSql('ALTER TABLE publication_comments DROP FOREIGN KEY FK_70F9637B9D86650F');
        $this->addSql('DROP INDEX IDX_70F9637B9A9AD8DB ON publication_comments');
        $this->addSql('DROP INDEX IDX_70F9637B9D86650F ON publication_comments');
        $this->addSql('ALTER TABLE publication_comments ADD publication_id_id INT NOT NULL, ADD user_id_id INT NOT NULL, DROP publication_id, DROP user_id');
        $this->addSql('ALTER TABLE publication_comments ADD CONSTRAINT FK_70F9637B9A9AD8DB FOREIGN KEY (publication_id_id) REFERENCES publication (id)');
        $this->addSql('ALTER TABLE publication_comments ADD CONSTRAINT FK_70F9637B9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_70F9637B9A9AD8DB ON publication_comments (publication_id_id)');
        $this->addSql('CREATE INDEX IDX_70F9637B9D86650F ON publication_comments (user_id_id)');
        $this->addSql('ALTER TABLE publication_images DROP FOREIGN KEY FK_4F4AF279A9AD8DB');
        $this->addSql('DROP INDEX IDX_4F4AF279A9AD8DB ON publication_images');
        $this->addSql('ALTER TABLE publication_images ADD publication_id_id INT NOT NULL, CHANGE publication_id id_publication_id INT NOT NULL');
        $this->addSql('ALTER TABLE publication_images ADD CONSTRAINT FK_4F4AF275D4AAA1 FOREIGN KEY (id_publication_id) REFERENCES publication (id)');
        $this->addSql('ALTER TABLE publication_images ADD CONSTRAINT FK_4F4AF279A9AD8DB FOREIGN KEY (publication_id_id) REFERENCES publication (id)');
        $this->addSql('CREATE INDEX IDX_4F4AF275D4AAA1 ON publication_images (id_publication_id)');
        $this->addSql('CREATE INDEX IDX_4F4AF279A9AD8DB ON publication_images (publication_id_id)');
        $this->addSql('ALTER TABLE user ADD is_verified TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE publication_comments DROP FOREIGN KEY FK_70F9637B9A9AD8DB');
        $this->addSql('ALTER TABLE publication_comments DROP FOREIGN KEY FK_70F9637B9D86650F');
        $this->addSql('DROP INDEX IDX_70F9637B9A9AD8DB ON publication_comments');
        $this->addSql('DROP INDEX IDX_70F9637B9D86650F ON publication_comments');
        $this->addSql('ALTER TABLE publication_comments ADD publication_id INT NOT NULL, ADD user_id INT NOT NULL, DROP publication_id_id, DROP user_id_id');
        $this->addSql('ALTER TABLE publication_comments ADD CONSTRAINT FK_70F9637B9A9AD8DB FOREIGN KEY (publication_id) REFERENCES publication (id)');
        $this->addSql('ALTER TABLE publication_comments ADD CONSTRAINT FK_70F9637B9D86650F FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_70F9637B9A9AD8DB ON publication_comments (publication_id)');
        $this->addSql('CREATE INDEX IDX_70F9637B9D86650F ON publication_comments (user_id)');
        $this->addSql('ALTER TABLE publication_images DROP FOREIGN KEY FK_4F4AF275D4AAA1');
        $this->addSql('ALTER TABLE publication_images DROP FOREIGN KEY FK_4F4AF279A9AD8DB');
        $this->addSql('DROP INDEX IDX_4F4AF275D4AAA1 ON publication_images');
        $this->addSql('DROP INDEX IDX_4F4AF279A9AD8DB ON publication_images');
        $this->addSql('ALTER TABLE publication_images ADD publication_id INT NOT NULL, DROP id_publication_id, DROP publication_id_id');
        $this->addSql('ALTER TABLE publication_images ADD CONSTRAINT FK_4F4AF279A9AD8DB FOREIGN KEY (publication_id) REFERENCES publication (id)');
        $this->addSql('CREATE INDEX IDX_4F4AF279A9AD8DB ON publication_images (publication_id)');
        $this->addSql('ALTER TABLE user DROP is_verified');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C67799D86650F');
        $this->addSql('DROP INDEX IDX_AF3C67799D86650F ON publication');
        $this->addSql('ALTER TABLE publication CHANGE user_id_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C67799D86650F FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_AF3C67799D86650F ON publication (user_id)');
    }
}
