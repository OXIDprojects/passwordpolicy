<?php

// Components files
PHPUnit_Util_Filter::addFileToWhitelist(oxPATH . '/modules/oxps/passwordpolicy/components/oxpspasswordpolicymodule.php');
PHPUnit_Util_Filter::addFileToWhitelist(oxPATH . '/modules/oxps/passwordpolicy/components/oxpspasswordpolicyuser.php');

// Controllers files
PHPUnit_Util_Filter::addFileToWhitelist(oxPATH . '/modules/oxps/passwordpolicy/controllers/admin/oxpspasswordpolicy.php');
PHPUnit_Util_Filter::addFileToWhitelist(oxPATH . '/modules/oxps/passwordpolicy/controllers/oxpspasswordpolicy.php');
PHPUnit_Util_Filter::addFileToWhitelist(oxPATH . '/modules/oxps/passwordpolicy/controllers/oxpspasswordpolicyaccountpassword.php');
PHPUnit_Util_Filter::addFileToWhitelist(oxPATH . '/modules/oxps/passwordpolicy/controllers/oxpspasswordpolicyregister.php');

// Model files
PHPUnit_Util_Filter::addFileToWhitelist(oxPATH . '/modules/oxps/passwordpolicy/models/oxpspasswordpolicyattempt.php');
