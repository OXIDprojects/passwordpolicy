[{$smarty.block.parent}]
[{if $oViewConf->isTOTP()}]
<div class="form-group row">
    <div class="col-lg-9 offset-lg-3">
        <div class="checkbox">
            <label>
                <input type="checkbox" name="2FA"> [{oxmultilang ident="OXPS_PASSWORDPOLICY_TWOFACTORAUTH_ACTIVATE"}]
            </label>
        </div>
        <span class="help-block">[{oxmultilang ident="OXPS_PASSWORDPOLICY_TWOFACTORAUTH_HELP_INFO"}]</span>
    </div>
</div>
[{/if}]
