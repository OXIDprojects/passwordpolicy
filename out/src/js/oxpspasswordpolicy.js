/**
 * Password strength live indication.
 */

jQuery(document).ready(function () {

    // Password type event to pass values to strength calculator
    jQuery('input#passwordNew,input#userPassword, input[name="password_new"]').keyup(function () {
        try {
            passwordStrength(jQuery(this).val());
        } catch (err) {
        }
    });
});

/**
 * Password strength indication.
 *
 * @param password
 */
function passwordStrength(password) {
    try {

        // Loading translations
        desc = oxpspasswordpolicy_translations;
    } catch (err) {

        // Use hardcoded default  values
        var desc = new Array();
        desc[0] = "Very Weak";
        desc[1] = "Weak";
        desc[2] = "Better";
        desc[3] = "Medium";
        desc[4] = "Strong";
        desc[5] = "Strongest";
    }

    try {

        // Loading settings
        var min_length = oxpspasswordpolicy_settings['iMinPasswordLength'];
        var good_length = oxpspasswordpolicy_settings['iGoodPasswordLength'];
    } catch (err) {

        // Use hardcoded default  values
        var min_length = 6;
        var good_length = 12;
    }

    var score = 0;

    //if password bigger than 6 give 1 point
    if (password.length >= min_length) score++;

    //if password has both lower and uppercase characters give 1 point
    if (( password.match(/[a-z]/) ) && ( password.match(/[A-Z]/) )) score++;

    //if password has at least one number give 1 point
    if (password.match(/\d+/)) score++;

    //if password has at least one special caracther give 1 point
    if (password.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/))    score++;

    //if password bigger than 12 give another 1 point
    if (password.length >= good_length) score++;

    document.getElementById("passwordDescription").innerHTML = desc[score];
    document.getElementById("passwordStrength").className = "strength" + score;
}
