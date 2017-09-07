CREATE TABLE XOOPS_subscription2_type (
  subtypeid INT(11)     NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (subtypeid),
  psid      INT(11)              DEFAULT '0',
  type      VARCHAR(50) NOT NULL,
  groupid   INT(11)              DEFAULT '0'
) TYPE = MyISAM;

CREATE TABLE XOOPS_subscription2_interval (
  subintervalid  INT(11)     NOT NULL AUTO_INCREMENT,
  name           VARCHAR(25) NOT NULL,
  intervalamount INT(11)              DEFAULT 0,
  intervaltype   CHAR(1)     NOT NULL,
  orderbit       INT(2)      NOT NULL DEFAULT 0,
  PRIMARY KEY (subintervalid)
) TYPE = MyISAM;

CREATE TABLE XOOPS_subscription2 (
  subid         INT(11)      NOT NULL AUTO_INCREMENT,
  name          VARCHAR(100) NOT NULL DEFAULT '',
  subtypeid     INT(11)      NOT NULL,
  subintervalid INT(11)      NOT NULL DEFAULT '0',
  price         DECIMAL(7, 2)         DEFAULT '0.00',
  orderbit      INT(2)                DEFAULT '0',
  PRIMARY KEY (subid)
) TYPE = MyISAM;

CREATE TABLE XOOPS_subscription2_transaction (
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
  transactiondate DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  transactiontype CHAR(1)       NOT NULL DEFAULT 'S',
  PRIMARY KEY (id)
) ENGINE = MyISAM;

CREATE TABLE XOOPS_subscription2_user (
  id              INT      NOT NULL PRIMARY KEY AUTO_INCREMENT,
  subid           INT(11)  NOT NULL,
  uid             INT(11)  NOT NULL,
  expiration_date DATETIME NOT NULL             DEFAULT CURRENT_TIMESTAMP,
  intervaltype    CHAR(1),
  intervalamount  SMALLINT,
  amount          DECIMAL(7, 2),
  cancel          CHAR(1)  NOT NULL             DEFAULT 'N'
) ENGINE = MyISAM;

CREATE TABLE XOOPS_sequences2 (
  sequencename VARCHAR(50) NOT NULL PRIMARY KEY,
  nextval      INT         NOT NULL
);


DELETE FROM XOOPS_SUBSCRIPTION;

INSERT INTO XOOPS_SUBSCRIPTION SELECT *
                               FROM XOOPS_SUBSCRIPTION2;

DELETE FROM XOOPS_SUBSCRIPTION_TYPE;

INSERT INTO XOOPS_SUBSCRIPTION_TYPE SELECT *
                                    FROM XOOPS_SUBSCRIPTION2_TYPE;

DELETE FROM XOOPS_SUBSCRIPTION_INTERVAL;

INSERT INTO XOOPS_SUBSCRIPTION_INTERVAL SELECT *
                                        FROM
                                          XOOPS_SUBSCRIPTION2_INTERVAL;

DELETE FROM XOOPS_SUBSCRIPTION_USER;

INSERT INTO XOOPS_SUBSCRIPTION_USER SELECT *
                                    FROM XOOPS_SUBSCRIPTION2_USER;

DELETE FROM XOOPS_SUBSCRIPTION_TRANSACTION;

INSERT INTO XOOPS_SUBSCRIPTION_TRANSACTION
  SELECT
    id,
    uid,
    subid,
    cardnumber,
    cvv,
    issuerphone,
    expirationmonth,
    expirationyear,
    nameoncard,
    address,
    city,
    state,
    country,
    zipcode,
    referencenumber,
    responsecode,
    response,
    authcode,
    amount,
    transactiondate,
    'S'
  FROM
    XOOPS_SUBSCRIPTION2_TRANSACTION;

INSERT INTO XOOPS_SEQUENCES SELECT *
                            FROM XOOPS_SEQUENCES2;

DROP TABLE XOOPS_SEQUENCES2;
DROP TABLE XOOPS_SUBSCRIPTION2_TYPE;
DROP TABLE XOOPS_SUBSCRIPTION2_INTERVAL;
DROP TABLE XOOPS_SUBSCRIPTION2_USER;
DROP TABLE XOOPS_SUBSCRIPTION2_TRANSACTION;
DROP TABLE XOOPS_SUBSCRIPTION2;

