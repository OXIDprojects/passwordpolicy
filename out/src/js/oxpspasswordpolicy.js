/**
 * Password strength live indication.
 */

var error_messages = [];
jQuery(document).ready(function () {

    var wrapper = jQuery('#password-indicator-wrapper');
    let block = wrapper.parent();
    var passwordDiv = block.find('div').first();
    var helpblock = block.find('.help-block');

    passwordDiv.append(wrapper);
    if (helpblock) {
        passwordDiv.append(helpblock);
    }
    wrapper.show();

    let pswField = jQuery('input#passwordNew,input#userPassword, input[name="password_new"]');
    pswField.on('keyup', function () {
        //workaround for current oxid validation that does not do validation on keyup
        //keyup is important for valuidation because at this point the value is changed and validation will notice change
        jQuery(this).trigger('keydown');
    });
    // Password type event to pass values to strength calculator
    pswField.on('validation.validation', function () {
        try {
            error_messages = [];
            passwordValidate(jQuery(this), jQuery(this).val());
        } catch (err) {
        }
        return error_messages;
    });

});

/**
 * Password strength indication.
 *
 * @param password
 */
function passwordStrength(password) {
    var desc;
    try {

        // Loading translations
        desc = oxpspasswordpolicy_translations;
    } catch (err) {

        // Use hardcoded default  values
        desc = [];
        desc[0] = "Very Weak";
        desc[1] = "Weak";
        desc[2] = "Better";
        desc[3] = "Medium";
        desc[4] = "Strong";
        desc[5] = "Strongest";
    }
    var min_length;
    var good_length;
    try {

        // Loading settings
        min_length = oxpspasswordpolicy_settings['iMinPasswordLength'];
        good_length = oxpspasswordpolicy_settings['iGoodPasswordLength'];
    } catch (err) {

        // Use hardcoded default  values
        min_length = 6;
        good_length = 12;
    }

    var score = 0;

    //if password bigger than 6 give 1 point
    if (password.length >= min_length) score++;

    //if password has both lower and uppercase characters give 1 point
    if (( password.match(/[a-z]/) ) && ( password.match(/[A-Z]/) )) score++;

    //if password has at least one number and one non number give 1 point
    if (password.match(/\d+/) && password.match(/[^\d]+/)) score++;

    //if password has at least one special caracther give 1 point
    if (password.match(/.[!,@#$%^&*?_~()\-]/))    score++;

    //if password bigger than 12 give another 1 point
    if (password.length >= good_length) score++;

    //if password bigger than 24 give another 1 point
    if (password.length >= (good_length * 2) ) score++;

    if (score > 5) score = 5;

    $("#passwordStrengthText").text(desc[score]);
    document.getElementById("passwordStrength").className = "strength" + score;
}

/**
 * Display all missing requirements for an password when focus get lost.
 * @param object
 * @param password
 */
function passwordValidate(object, password) {

    passwordStrength(password);

    // Loading settings
    var min_length = oxpspasswordpolicy_settings['iMinPasswordLength'];
    var digits = oxpspasswordpolicy_settings['digits'];
    var capital = oxpspasswordpolicy_settings['capital'];
    var lower   = oxpspasswordpolicy_settings['lower'];
    var special = oxpspasswordpolicy_settings['special'];

    if (password.length < min_length) validationError(object, 'minlength');
    //unicode class check like /\p{Lu}/u are not yet supported by FF and IE
    //see https://javascript.info/regexp-unicode so fall back to ASCII
    if (capital && !(password.match(/[A-Z]/))) validationError(object, 'capital');

    if (lower && !(password.match(/[a-z]/))) validationError(object, 'lower');

    if (digits && !(password.match(/\d+/))) validationError(object, 'digits');

    if (special && !(password.match(/.[!,@#$%^&*?_~()\-]/))) validationError(object, 'special');

}

/**
 * Append an div after given object if not exist.
 * Append the error messages for not full filled the password policies
 *
 * @param object    The calling object (here the input for password)
 * @param errortype The type of error that do not match password policies.
 */
function validationError(object, errortype) {

    // Loading translations
    desc = oxpspasswordpolicy_translations;

    error_messages.push(desc[errortype]);
}
