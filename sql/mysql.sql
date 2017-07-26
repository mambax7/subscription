CREATE TABLE subscription_type (
  subtypeid INT(11)     NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (subtypeid),
  psid      INT(11)              DEFAULT '0',
  type      VARCHAR(50) NOT NULL,
  groupid   INT(11)              DEFAULT '0'
)
  ENGINE = MyISAM;

INSERT INTO subscription_type VALUES (1, 0, 'Basic', 4);
INSERT INTO subscription_type VALUES (2, 0, 'Premium', 5);

CREATE TABLE subscription_interval (
  subintervalid  INT(11)     NOT NULL AUTO_INCREMENT,
  name           VARCHAR(25) NOT NULL,
  intervalamount INT(11)              DEFAULT 0,
  intervaltype   CHAR(1)     NOT NULL,
  orderbit       INT(2)      NOT NULL DEFAULT 0,
  PRIMARY KEY (subintervalid)
)
  ENGINE = MyISAM;

INSERT INTO subscription_interval VALUES (1, 'Monthly', 1, 'm', 0);
INSERT INTO subscription_interval VALUES (2, 'Yearly', 12, 'm', 2);

CREATE TABLE subscription (
  subid          INT(11)      NOT NULL AUTO_INCREMENT,
  alternatesubid VARCHAR(50)  NULL,
  name           VARCHAR(100) NOT NULL DEFAULT '',
  subtypeid      INT(11)      NOT NULL,
  subintervalid  INT(11)      NOT NULL DEFAULT '0',
  price          DECIMAL(7, 2)         DEFAULT '0.00',
  orderbit       INT(2)                DEFAULT '0',
  PRIMARY KEY (subid)
)
  ENGINE = MyISAM;

INSERT INTO subscription VALUES (2, NULL, 'Monthly Premium', 2, 1, 14.95, 2);
INSERT INTO subscription VALUES (1, NULL, 'Yearly Basic', 1, 2, 75.95, 1);
INSERT INTO subscription VALUES (3, NULL, 'Yearly Premium', 2, 2, 129.95, 3);

CREATE TABLE subscription_transaction (
  id              INT(11)       NOT NULL AUTO_INCREMENT,
  uid             INT(11)       NOT NULL DEFAULT '0',
  subid           INT(11)       NOT NULL DEFAULT '0',
  cardnumber      VARCHAR(20)   NOT NULL DEFAULT '',
  cvv             VARCHAR(4)    NOT NULL,
  issuerphone     VARCHAR(50),
  expirationmonth CHAR(2)       NOT NULL DEFAULT '',
  expirationyear  VARCHAR(4)    NOT NULL DEFAULT '',
  nameoncard      VARCHAR(50)   NOT NULL DEFAULT '',
  address         VARCHAR(50)   NOT NULL DEFAULT '',
  city            VARCHAR(50)   NOT NULL DEFAULT '',
  state           CHAR(2)                DEFAULT NULL,
  country         CHAR(2)                DEFAULT NULL,
  zipcode         VARCHAR(15)            DEFAULT NULL,
  referencenumber VARCHAR(50)   NOT NULL DEFAULT '',
  responsecode    SMALLINT,
  response        VARCHAR(255),
  authcode        VARCHAR(50)   NOT NULL DEFAULT '',
  amount          DECIMAL(7, 2) NOT NULL,
  transactiondate DATETIME      NULL     DEFAULT NULL,
  transactiontype CHAR(1)       NOT NULL DEFAULT 'S',
  PRIMARY KEY (id)
)
  ENGINE = MyISAM;

CREATE TABLE subscription_user (
  id              INT      NOT NULL PRIMARY KEY AUTO_INCREMENT,
  subid           INT(11)  NOT NULL,
  uid             INT(11)  NOT NULL,
  expiration_date DATETIME NULL                 DEFAULT NULL,
  intervaltype    CHAR(1),
  intervalamount  SMALLINT,
  amount          DECIMAL(7, 2),
  cancel          CHAR(1)  NOT NULL             DEFAULT 'N'
)
  ENGINE = MyISAM;

CREATE TABLE subscription_gateway_config (
  gateway  VARCHAR(25) NOT NULL,
  name     VARCHAR(50) NOT NULL,
  value    VARCHAR(150),
  title    VARCHAR(150),
  orderbit SMALLINT,
  PRIMARY KEY (gateway, name)
)
  ENGINE = MyISAM;

CREATE TABLE sequences (
  sequencename VARCHAR(50) NOT NULL PRIMARY KEY,
  nextval      INT         NOT NULL
);

INSERT INTO sequences VALUES ('subscription_transaction_seq', 1);


