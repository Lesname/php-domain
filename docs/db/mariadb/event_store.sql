CREATE TABLE IF NOT EXISTS event_store (
    id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    target VARCHAR(40) NOT NULL,
    action VARCHAR(25) NOT NULL,
    parameters JSON NOT NULL,
    occurred_on BIGINT(14) NOT NULL,
    headers json NOT NULL
);
