<div class="min-h-screen flex flex-col justify-center text-center">
    <div class="container rounded h-100 align-items-center col-12 col-md-6 col-lg-6" style="width: 500px; background-color:white">
        <div class="content mt-3" id="content">
            [{include file="message/errors.tpl"}]
        </div>
    <h1 class="mt-1 page-header text-center">[{oxmultilang ident="OXPS_PASSWORDPOLICY_TWOFACTORAUTH_REGISTER"}]</h1>
    <span class="help-block">[{oxmultilang ident="OXPS_PASSWORDPOLICY_TWOFACTORAUTH_HELP_REGISTER"}]</span>
    <form class="form-horizontal" action="[{$oViewConf->getSelfLink()}]" name="order" method="post" novalidate="novalidate">
    <div class="hidden">
        [{$oViewConf->getHiddenSid()}]
        <input type="hidden" name="fnc" value="finalizeRegistration">
        <input type="hidden" name="cl" value="admin_twofactorregister">
        <input type="hidden" name="step" value="[{$step}]">
        <input type="hidden" name="paymentActionLink" value="[{$paymentActionLink}]">
    </div>
    <div class="mt-3 flex justify-center">
            [{$oView->getTOTPQrCode()}]
    </div>
    <div class="mt-3 flex justify-center " id="OTPInput">
    </div>
    <input hidden id="otp" name="otp" value="">
    <div class="flex justify-center">
            <button id="accUserSaveTop" type="submit" name="save" class="mt-4 mb-3 btn btn-primary">[{oxmultilang ident="OXPS_PASSWORDPOLICY_TWOFACTORAUTH_CONTINUE"}]</button>
</div>
</form>
</div>
</div>

[{assign var="oViewConf" value=$oView->getViewConfig()}]
[{assign var="oConf" value=$oView->getConfig()}]
[{oxstyle include=$oViewConf->getModuleUrl('oxpspasswordpolicy','out/src/css/style.css')}]
[{oxscript include=$oViewConf->getModuleUrl('oxpspasswordpolicy','out/src/js/otpField.js')}]
[{oxstyle include=$oViewConf->getModuleUrl('oxpspasswordpolicy','out/src/css/styles.css')}]
[{oxstyle}]
[{oxscript}]
<style>
    body {
        background: #f6f6f6;
    }
</style>