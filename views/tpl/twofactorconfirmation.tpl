[{capture append="oxidBlock_pageBody"}]
[{$oViewConf->setFullWidth()}]
<div class="min-h-screen flex flex-col justify-center text-center">
<div class="container rounded h-100 align-items-center col-12 col-md-6 col-lg-6" style="width: 500px; background-color:white">
    <div class="content mt-3" id="content">
        [{include file="message/errors.tpl"}]
    </div>
    <h1 class="mt-1 page-header text-center">[{oxmultilang ident="OXPS_PASSWORDPOLICY_TWOFACTORAUTH_LOGIN"}]</h1>
    <span class="help-block">[{oxmultilang ident="OXPS_PASSWORDPOLICY_TWOFACTORAUTH_HELP_LOGIN"}]</span>
    <form class="form-horizontal" action="[{$oViewConf->getSslSelfLink()}]" name="order" method="post" novalidate="novalidate">
    <div class="hidden">
        [{$oViewConf->getHiddenSid()}]
        [{$oViewConf->getNavFormParams()}]
        <input type="hidden" name="fnc" value="confirm">
        <input type="hidden" name="cl" value="twofactorconfirmation">
    </div>
    <div class="mt-3 flex justify-center " id="OTPInput">
    </div>
    <input hidden id="otp" name="otp" value="">
        <a href="?cl=twofactorrecovery">[{oxmultilang ident="OXPS_PASSWORDPOLICY_TWOFACTORAUTH_HELP_LOST"}]</a>
    <div class="flex justify-center">
            <button id="accUserSaveTop" type="submit" name="save" class="mt-4 mb-3 btn btn-primary">[{oxmultilang ident="OXPS_PASSWORDPOLICY_TWOFACTORAUTH_DEACTIVATE"}]</button>
</div>
</form>
</div>
</div>
    [{oxscript include=$oViewConf->getModuleUrl('oxpspasswordpolicy','out/src/js/otpField.js')}]
    [{oxstyle include=$oViewConf->getModuleUrl('oxpspasswordpolicy','out/src/css/style.css')}]
[{/capture}]


[{include file="layout/page.tpl"}]