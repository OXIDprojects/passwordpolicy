--
-- Table structure for table `oxpspasswordpolicy_attempt`
--

CREATE TABLE IF NOT EXISTS `oxpspasswordpolicy_attempt` (
  `OXID` char(32) COLLATE latin1_general_ci NOT NULL,
  `OXUSERID` char(32) COLLATE latin1_general_ci NOT NULL,
  `OXPSTIME` datetime NOT NULL,
  `OXPSIP` varchar(64) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`OXID`),
  KEY `OXUSERID` (`OXUSERID`)
) ENGINE=Innodb DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
