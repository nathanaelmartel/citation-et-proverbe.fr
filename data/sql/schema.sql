CREATE TABLE ads (id BIGINT AUTO_INCREMENT, title VARCHAR(255), code LONGTEXT, position INT, is_active INT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
CREATE TABLE author (id BIGINT AUTO_INCREMENT, author VARCHAR(255), twitter_account VARCHAR(255), twitter_keys VARCHAR(255), is_active INT, slug VARCHAR(255), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX author_sluggable_idx (slug), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE category (id BIGINT AUTO_INCREMENT, name VARCHAR(255) NOT NULL, is_active INT, slug VARCHAR(255), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX category_sluggable_idx (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
CREATE TABLE category_citation (category_id BIGINT, citation_id BIGINT, PRIMARY KEY(category_id, citation_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
CREATE TABLE category_expression (id BIGINT AUTO_INCREMENT, category_id BIGINT, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
CREATE TABLE citation (id BIGINT AUTO_INCREMENT, quote TEXT, author VARCHAR(255), source VARCHAR(255), website VARCHAR(255), is_active INT, last_published_at datetime, author_last_published_at datetime, hash VARCHAR(64), slug VARCHAR(255), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX citation_sluggable_idx (slug), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE contact (id BIGINT AUTO_INCREMENT, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, comments LONGTEXT, referer LONGTEXT, host VARCHAR(255), keywords VARCHAR(255), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
CREATE TABLE link (id BIGINT AUTO_INCREMENT, url VARCHAR(255), website VARCHAR(255), statut INT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE newsletter (id BIGINT AUTO_INCREMENT, email VARCHAR(255), is_confirmed TINYINT(1) DEFAULT '0', referer LONGTEXT, host VARCHAR(255), keywords VARCHAR(255), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
CREATE TABLE word (id BIGINT AUTO_INCREMENT, name VARCHAR(255) NOT NULL, is_active INT, slug VARCHAR(255), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX word_sluggable_idx (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
CREATE TABLE word_citation (word_id BIGINT, citation_id BIGINT, PRIMARY KEY(word_id, citation_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
ALTER TABLE category_citation ADD CONSTRAINT category_citation_citation_id_citation_id FOREIGN KEY (citation_id) REFERENCES citation(id);
ALTER TABLE category_citation ADD CONSTRAINT category_citation_category_id_category_id FOREIGN KEY (category_id) REFERENCES category(id);
ALTER TABLE word_citation ADD CONSTRAINT word_citation_word_id_word_id FOREIGN KEY (word_id) REFERENCES word(id);
ALTER TABLE word_citation ADD CONSTRAINT word_citation_citation_id_citation_id FOREIGN KEY (citation_id) REFERENCES citation(id);
