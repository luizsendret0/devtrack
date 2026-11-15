-- Execute uma única vez, após criar a tabela users.
USE devtrack;
ALTER TABLE users ADD COLUMN avatar_path VARCHAR(255) NULL;
