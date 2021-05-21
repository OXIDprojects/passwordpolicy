[{$smarty.block.parent}]
[{if $oViewConf->isTOTP()}]
<div class="form-group row">
    <div class="col-lg-9 offset-lg-3">
        <div class="checkbox">
            <label>
                <input type="checkbox" name="2FA"> [{oxmultilang ident="TWOFACTORAUTHCHECKBOX"}]
            </label>
        </div>
        <span class="help-block">[{oxmultilang ident="MESSAGE_TWOFACTOR_HELP"}]</span>
    </div>
</div>
[{/if}]
