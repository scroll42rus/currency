CREATE TABLE currency_info (
  id                SERIAL PRIMARY KEY,
  name              VARCHAR(255) NOT NULL,
  code              VARCHAR(3) NOT NULL
);

CREATE TABLE currency_data (
  id                SERIAL PRIMARY KEY,
  info              INTEGER NOT NULL references currency_info(id),
  value             NUMERIC NOT NULL,
  create_date       TIMESTAMP NOT NULL
);