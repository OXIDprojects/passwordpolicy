--
-- Remove table `oxpspasswordpolicy_attempt`
--

DROP TABLE `oxpspasswordpolicy_attempt`;

--
-- Remove module related settings
--
DELETE FROM `oxconfig` WHERE `OXMODULE` = "oxpspasswordpolicy";
