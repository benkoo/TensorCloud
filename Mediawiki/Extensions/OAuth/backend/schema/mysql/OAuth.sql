-- (c) Aaron Schulz, 2013

-- Replace /*_*/ with the proper prefix

-- These tables should belong in one central DB per wiki-farm

-- Client consumers (proposed as well as and accepted)
CREATE TABLE IF NOT EXISTS /*_*/oauth_registered_consumer (
    -- Immutable fields below:
    -- Consumer ID (1:1 with oarc_consumer_key)
    oarc_id integer unsigned NOT NULL PRIMARY KEY auto_increment,
    -- OAuth consumer key and secret (or RSA key)
    oarc_consumer_key varbinary(32) NOT NULL,
    -- Name of the application
    oarc_name varchar(128) binary NOT NULL,
    -- (Central) user id of the user who proposed the application
    oarc_user_id integer unsigned NOT NULL,
    -- Version of the application
    oarc_version varbinary(32) NOT NULL,
    -- Callback URL
    oarc_callback_url blob NOT NULL,
    -- Is the consumer allowed to specify a callback URL? (See MWOAuthServer::checkCallback().)
    oarc_callback_is_prefix tinyblob NULL DEFAULT NULL,
    -- Application description
    oarc_description blob NOT NULL,
    -- Contact email address
    oarc_email varchar(255) binary NOT NULL,
    -- Confirmation of contact email address
    oarc_email_authenticated varbinary(14) NULL,
    -- Did the owner accept the developer agreement?
    oarc_developer_agreement tinyint NOT NULL DEFAULT 0,
    -- Is this consumer owner-only
    oarc_owner_only tinyint NOT NULL DEFAULT 0,
    -- What wiki this is allowed on (a single wiki or '*' for all)
    oarc_wiki varbinary(32) NOT NULL,
    -- Grants needed for client consumers
    oarc_grants blob NOT NULL,
    -- Timestamp of consumer proposal
    oarc_registration varbinary(14) NOT NULL,

    -- Mutable fields below:
    oarc_secret_key varbinary(32) NULL,
    oarc_rsa_key blob NULL,
    -- JSON blob of allowed IP ranges
    oarc_restrictions blob NOT NULL,
    -- Stage in registration pipeline:
    -- (0=proposed, 1=approved, 2=rejected, 3=expired, 4=disabled)
    oarc_stage tinyint unsigned NOT NULL DEFAULT 0,
    -- Timestamp of the last stage change
    oarc_stage_timestamp varbinary(14) NOT NULL,
    -- Whether this consumer is suppressed (hidden)
    oarc_deleted tinyint unsigned NOT NULL DEFAULT 0
) /*$wgDBTableOptions*/;

CREATE UNIQUE INDEX /*i*/oarc_consumer_key
    ON /*_*/oauth_registered_consumer (oarc_consumer_key);
CREATE UNIQUE INDEX /*i*/oarc_name_version_user
    ON /*_*/oauth_registered_consumer (oarc_name,oarc_user_id,oarc_version);
CREATE INDEX /*i*/oarc_user_id ON /*_*/oauth_registered_consumer (oarc_user_id);
CREATE INDEX /*i*/oarc_stage_timestamp
    ON /*_*/oauth_registered_consumer (oarc_stage,oarc_stage_timestamp);

-- Grant approvals by users for consumers
CREATE TABLE IF NOT EXISTS /*_*/oauth_accepted_consumer (
    oaac_id integer unsigned NOT NULL PRIMARY KEY auto_increment,
    -- The name of a wiki or "*"
    oaac_wiki varchar(255) binary NOT NULL,
    -- Key to the user who approved the consumer (on the central wiki)
    oaac_user_id integer unsigned NOT NULL,
    -- Key to the consumer
    oaac_consumer_id integer unsigned NOT NULL,
    -- Tokens for the consumer to act on behave of the user
    oaac_access_token varbinary(32) NOT NULL,
    oaac_access_secret varbinary(32) NOT NULL,
    -- JSON blob of actually accepted grants
    oaac_grants blob NOT NULL,
    -- Timestamp of grant approval by the user
    oaac_accepted varbinary(14) NOT NULL
) /*$wgDBTableOptions*/;

CREATE UNIQUE INDEX /*i*/oaac_access_token
    ON /*_*/oauth_accepted_consumer (oaac_access_token);
CREATE UNIQUE INDEX /*i*/oaac_user_consumer_wiki
    ON /*_*/oauth_accepted_consumer (oaac_user_id,oaac_consumer_id,oaac_wiki);
CREATE INDEX /*i*/oaac_consumer_user
    ON /*_*/oauth_accepted_consumer (oaac_consumer_id,oaac_user_id);
CREATE INDEX /*i*/oaac_user_id ON /*_*/oauth_accepted_consumer (oaac_user_id,oaac_id);
