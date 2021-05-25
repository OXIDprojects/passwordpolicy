<link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
[{capture append="oxidBlock_pageBody"}]
[{$oViewConf->setFullWidth()}]
<div class="min-h-screen flex flex-col justify-center text-center">
<div class="container rounded h-100 align-items-center col-12 col-md-6 col-lg-6" style="width: 500px; background-color:white">
    [{if $success}]
    <div class="content mt-3 alert alert-success">[{oxmultilang ident="MESSAGE_TWOFACTOR_REGISTER_SUCCESS"}]</div>
    [{/if}]
    <div class="content mt-3" id="content">
        [{include file="message/errors.tpl"}]
    </div>
    <h1 class="mt-1 page-header text-center">[{oxmultilang ident="TWOFACTORAUTHREGISTER"}]</h1>
    <span class="help-block">[{oxmultilang ident="MESSAGE_TWOFACTOR_REGISTER"}]</span>
    <form class="form-horizontal" action="[{$oViewConf->getSslSelfLink()}]" name="order" method="post" novalidate="novalidate">
    <div class="hidden">
        [{$oViewConf->getHiddenSid()}]
        [{$oViewConf->getNavFormParams()}]
        <input type="hidden" name="fnc" value="finalizeRegistration">
        <input type="hidden" name="cl" value="twofactorregister">
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
            <button id="accUserSaveTop" type="submit" name="save" class="mt-8 mb-3 btn btn-primary">[{oxmultilang ident="TWOFACTORCONTINUE"}]</button>
</div>
</form>
</div>
</div>
    [{oxscript include=$oViewConf->getModuleUrl('oxpspasswordpolicy','out/src/js/otpField.js')}]
[{/capture}]

[{include file="layout/base.tpl"}]
[{include file="layout/footer.tpl"}]
