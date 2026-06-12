CREATE TABLE IF NOT EXISTS event_store (
    id INT NOT NULL PRIMARY KEY generated always as identity,
    target VARCHAR(40) NOT NULL,
    action VARCHAR(25) NOT NULL,
    parameters JSON NOT NULL,
    occurred_on BIGINT NOT NULL,
    headers json NOT NULL
);
