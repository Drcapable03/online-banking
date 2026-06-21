-- Upgrade password columns for existing databases (safe to re-run on fresh installs)
ALTER TABLE tbl_account MODIFY password VARCHAR(255) NOT NULL;
ALTER TABLE tbl_admin MODIFY password VARCHAR(255) NOT NULL;