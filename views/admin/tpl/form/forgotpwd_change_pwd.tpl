[{oxscript add="$('input,select,textarea').not('[type=submit]').jqBootstrapValidation();"}]

<form action="[{$oViewConf->getSelfActionLink()}]" name="forgotpwd" method="post" role="form"  novalidate="novalidate">
    <div class="hidden">
        [{$oViewConf->getHiddenSid()}]
        <input type="hidden" name="fnc" value="updatePassword">
        <input type="hidden" name="uid" value="[{$oView->getUpdateId()}]">
        <input type="hidden" name="cl" value="admin_forgotpwd">
        <input type="hidden" id="passwordLength" value="[{$oViewConf->getPasswordLength()}]">
    </div>

    <div class="form-group[{if $aErrors.oxuser__oxpassword}] oxInValid[{/if}]">
            <label for="pwd">[{oxmultilang ident="NEW_PASSWORD"}]</label>
        <input type="password" name="password_new" class="form-control js-oxValidate js-oxValidate_notEmpty js-oxValidate_length js-oxValidate_match textbox" autocomplete="new-password">
    </div>
    <div class="form-group[{if $aErrors.oxuser__oxpassword}] oxInValid[{/if}]">
        <label for="pwd">[{oxmultilang ident="CONFIRM_PASSWORD"}]</label>
        <input type="password" name="password_new_confirm" class="form-control js-oxValidate js-oxValidate_notEmpty js-oxValidate_length js-oxValidate_match textbox" autocomplete="new-password">

    </div>

    <input type="submit" value="[{oxmultilang ident="CHANGE_PASSWORD"}]" class="btn"><br>

</form>
