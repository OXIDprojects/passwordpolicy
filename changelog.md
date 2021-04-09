# 2.0.0 unreleased

## removed
* removed password attempts feature (should become a new module)
* removed extra settings page (use module setting, extensions->modules, select password policy module -> select settings)

### changed
the feature did not pass the security check, it needs captcha dynamic blocking times and cleaner implementation and so it will be transferred in a separate module
* big refactoring (before upgrade disable and remove the old module from source /modules directory)
* config parameter names changed

### added
* tests and development tools


# 1.0.0
* Reworked the module to match the metadata 2.1 specifications
* Introduced namespaces
* Changed the folder structure and class names to be closer to PSR-4
* Fixed an error with the installer that occurred when attempting to enable the module repeatedly
* Changed layout by having the indicator directly blow the password field
* Workaround for key up validation 


# 0.8.6
- fix settings in metadata 
related issue: https://github.com/OXIDprojects/passwordpolicy/issues/2
related pull request: https://github.com/OXIDprojects/passwordpolicy/pull/1


# 0.8.5
- fix bug that caused 
message Cannot execute queries while other unbuffered queries are active. Consider using PDOStatement::fetchAll(). Alternatively, if your code is only ever going to run against mysql, you may enable query buffering by setting the PDO::MYSQL_ATTR_USE_BUFFERED_QUERY attribute.
- fix styling issue in a edge case where input fields using float

# 0.8.4
- add check for lowercase characters
- support wide range of uppercase unicode characters during javascript validation  

# 0.8.3
- use innodb as db engine

# 0.8.2
- update license to GPL 3

# 0.8.1
- added composer.json
