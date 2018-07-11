ALTER TABLE /*_*/oauth_registered_consumer ADD COLUMN `oarc_developer_agreement` tinyint NOT NULL DEFAULT 0 AFTER `oarc_email_authenticated`;
