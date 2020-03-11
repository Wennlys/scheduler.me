<?php

/*
 * NOSQL(MONGODB) DATABASE
 * */
define("NOSQL_DB_NAME", "schedulerMongo");
define("NOSQL_COLL_NAME", "notifications");

/*
 * SQL(MARIADB) DATABASE
 * */
define("SQL_DB_HOST", "172.17.0.2");
define("SQL_DB_USER", "root");
define("SQL_DB_PASS", "root");
define("SQL_DB_NAME", "scheduler");

/*
 * PASSWORD
 * */
define("MIN_PASS_LEN", 8);
define("MAX_PASS_LEN", 40);
define("PASS_ALGO", PASSWORD_DEFAULT);
define("PASS_OPTION", PASSWORD_BCRYPT_DEFAULT_COST);

/**
 * JWT
 */
define("JWT_SECRET", "97af779fec9b7be2dc0bd5855e77ba71!A");
define("JWT_EXPIRATION", time() + 10000);
define("JWT_ISSUER", "localhost");
