==Title==
Password policy for OXID eShop

==Author==
OXID Professional Services

==Prefix==
oxps

==Shop Version==
6.x

==Link==
http://www.oxid-sales.com

==Mail==
info@oxid-esales.com

==Description==
Password validation, strength visualization and expiry rules.

Concerning password strength indicator logic.

It works very simple - tracks what user is typing and gives strength points for:
1. Length more or equal minimal length set in Password Policy configuration.
2. Length more or equal recommended length set in Password Policy configuration.
3. Password contains digits. (Has no direct relation with Password Policy configuration.)
4. Password contains capital (UPPERCASE) letters. (Has no direct relation with Password Policy configuration.)
5. Password contains special characters (dots, dashes, underscores, etc.) (Has no direct relation with Password Policy configuration.)

NOTE: Those rules work independently - indicator just gives +1 strength for any on requirement fulfilled. Double length gives +2.

And the validation on form submit is fully dependent on Password Policy configuration.
So password strength meter is just an indicator helping to visualize strength, but not a validation mechanism.

==Installation==
see readme in root folder

==Uninstall==
Execute included uninstall.sql on Your database.
