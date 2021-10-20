<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script>
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
        // Password type event to pass values to strength calculator
        pswField.on('keydown', function () {
            try {
                error_messages = [];
                passwordValidate(jQuery(this), jQuery(this).val());
            } catch (err) {
            }
            var str = '<ul style="list-style-type: none; padding-left: initial;">'
            error_messages.forEach(function(error) {
                str += '<li>'+ error + '</li>';
            });
            str += '</ul>';
            $( helpblock).empty();
            helpblock.append(str);
            return error_messages;
        });

    });



</script>
<form action="[{$oViewConf->getSelfLink()}]" name="forgotpwd" method="post" role="form"  novalidate="novalidate">
    [{assign var="aErrors" value=$oView->getFieldValidationErrors()}]
    [{include file="message/errors.tpl"}]
    <div class="hidden">
        [{$oViewConf->getHiddenSid()}]
        <input type="hidden" name="fnc" value="updatePassword">
        <input type="hidden" name="uid" value="[{$oView->getUpdateId()}]">
        <input type="hidden" name="cl" value="admin_forgotpwd">
        <input type="hidden" id="passwordLength" value="[{$oViewConf->getPasswordLength()}]">
    </div>

    <div class="form-group[{if $aErrors.oxuser__oxpassword}] oxInValid[{/if}]">
        [{block name="user_account_password"}]
            <label for="pwd">[{oxmultilang ident="NEW_PASSWORD"}]</label>
        <input type="password" name="password_new" class="form-control js-oxValidate js-oxValidate_notEmpty js-oxValidate_length js-oxValidate_match textbox" autocomplete="new-password">
        <p class="mt-3 help-block text-danger"></p>
        [{/block}]
    </div>
    <div class="form-group[{if $aErrors.oxuser__oxpassword}] oxInValid[{/if}]">
        <label for="pwd">[{oxmultilang ident="CONFIRM_PASSWORD"}]</label>
        <input type="password" name="password_new_confirm" class="form-control js-oxValidate js-oxValidate_notEmpty js-oxValidate_length js-oxValidate_match textbox" autocomplete="new-password">
        <p class="help-block"></p>
    </div>

    <input type="submit" value="[{oxmultilang ident="CHANGE_PASSWORD"}]" class="btn"><br>

</form>

[{oxscript}]