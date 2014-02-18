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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


--
-- Module configuration params with default values.
--
[{assign var="iShopId" value=$oConfig->getShopId()}]

INSERT INTO `oxconfig` (`OXID`, `OXSHOPID`, `OXMODULE`, `OXVARNAME`, `OXVARTYPE`, `OXVARVALUE`) VALUES
('oxpspasswordpolicyiMaxAttemptsAllowed', [{$iShopId}], 'oxpspasswordpolicy', 'iMaxAttemptsAllowed', 'int', 0xb0),
('oxpspasswordpolicyiTrackingPeriod', [{$iShopId}], 'oxpspasswordpolicy', 'iTrackingPeriod', 'int', 0x17c3),
('oxpspasswordpolicyblAllowUnblock', [{$iShopId}], 'oxpspasswordpolicy', 'blAllowUnblock', 'bool', ''),
('oxpspasswordpolicyiMinPasswordLength', [{$iShopId}], 'oxpspasswordpolicy', 'iMinPasswordLength', 'int', 0x17),
('oxpspasswordpolicyiGoodPasswordLength', [{$iShopId}], 'oxpspasswordpolicy', 'iGoodPasswordLength', 'int', 0x07c4),
('oxpspasswordpolicyiMaxPasswordLength', [{$iShopId}], 'oxpspasswordpolicy', 'iMaxPasswordLength', 'int', 0x07c4b1),
('oxpspasswordpolicyaPasswordRequirements', [{$iShopId}], 'oxpspasswordpolicy', 'aPasswordRequirements', 'aarr', 0x4dba852e754d5626a674dc848a3e4f4642d1f3251a245ef60b81bc5809f68c0170a3491caac14aace714b48392fc07e5f95875e0cf3cdef18b8e02);
