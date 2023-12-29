-- CREATES BIZNET DATABASE
CREATE DATABASE TIMECODES;

-- SETS BIZNET AS DEFAULT DB
USE TIMECODES;

-- CREATES USERINFO TABLE
CREATE TABLE USERINFO (
	USERNAME VARCHAR(20),
    FIRSTNAME VARCHAR(20),
    LASTNAME VARCHAR(20),
    PHONE VARCHAR(20),
    EMAIL VARCHAR(20),
    PASSWORD VARCHAR(100)
);

-- CREATES TIMECODES TABLE
CREATE TABLE TIMECODES (
	TIMECODE VARCHAR(20),
    DESCRIPTION VARCHAR(100),
    ISACTIVE INT
);

-- CREATE TIMECODESLOGGING TABLE
CREATE TABLE TIMECODESLOGGING (
	USERNAME VARCHAR(20),
    TIMECODE VARCHAR(20),
    TIMECODESTART DATETIME,
    TIMECODEEND DATETIME
);

-- LISTS USER AND TIME CODES USED, TIME FROM AND TIME TO

