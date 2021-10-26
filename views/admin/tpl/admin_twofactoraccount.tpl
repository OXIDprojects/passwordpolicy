[{oxscript include="js/libs/jquery.min.js"}]
[{assign var="template_title" value="OXPS_PASSWORDPOLICY_TWOFACTORAUTH_LOGIN"|oxmultilangassign}]
[{assign var="oConf" value=$oView->getConfig()}]
[{assign var="oViewConf" value=$oView->getViewConfig()}]
<div class="min-h-screen flex flex-col justify-center text-center">
<div class="container rounded h-100 align-items-center col-12 col-md-6 col-lg-6" style="width: 500px; background-color:white">
    [{if $success == '1'}]
    <div class="mt-3 alert alert-success">[{oxmultilang ident="OXPS_PASSWORDPOLICY_TWOFACTORAUTH_ACTIVATED"}]</div>
    [{elseif $success == '2'}]
    <div class="mt-3 alert alert-success">[{oxmultilang ident="OXPS_PASSWORDPOLICY_TWOFACTORAUTH_DEACTIVATED"}]</div>
    [{/if}]
<h1 id="twofactorheader" class="page-header align-self-center">[{oxmultilang ident="OXPS_PASSWORDPOLICY_TWOFACTORAUTH_LOGIN"}]</h1>
<form action="[{$oViewConf->getSelfLink()}]" name="newsletter" class="form-horizontal" method="post">
    <div class="hidden">
        [{$oViewConf->getHiddenSid()}]
        <input type="hidden" name="fnc" value="redirect">
        <input type="hidden" name="cl" value="admin_twofactoraccount">
    </div>

    <div class="form-group">
        <label class="control-label col-lg-3">[{oxmultilang ident="OXPS_PASSWORDPOLICY_TWOFACTORAUTH_LOGIN"}]</label>
        <div class="col-lg-4">
            <select name="status" id="status" class="form-control ">
                <option value="1"[{if $oView->isTOTP() && $oViewConf->isTOTP()}] selected[{/if}] >[{oxmultilang ident="OXPS_PASSWORDPOLICY_TWOFACTORAUTH_ACTIVE"}]</option>
                <option value="0"[{if !$oView->isTOTP() || !$oViewConf->isTOTP()}] selected[{/if}] >[{oxmultilang ident="OXPS_PASSWORDPOLICY_TWOFACTORAUTH_INACTIVE"}]</option>
            </select>
        </div>
    </div>

    <div class="form-group flex justify-center">
            <button [{if !$oViewConf->isTOTP()}] disabled [{/if}] id="twofactorsave" type="submit" class="btn btn-primary">[{oxmultilang ident="SAVE"}]</button>
    </div>
</form>
</div>
</div>

[{oxstyle include=$oViewConf->getModuleUrl('oxpspasswordpolicy','out/src/css/style.css')}]
[{oxstyle include=$oViewConf->getModuleUrl('oxpspasswordpolicy','out/src/css/styles.css')}]
[{oxstyle}]
[{oxscript}]
<style>
    body {
        background: #f6f6f6;
    }
</style>