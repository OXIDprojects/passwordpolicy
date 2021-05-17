

<link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
[{capture append="oxidBlock_content"}]
<h1 class="page-header text-center">[{oxmultilang ident="TWOFACTORAUTH"}]</h1>
<form class="form-horizontal" action="[{$oViewConf->getSslSelfLink()}]" name="order" method="post" novalidate="novalidate">
    <div class="hidden">
        [{$oViewConf->getHiddenSid()}]
        [{$oViewConf->getNavFormParams()}]
        <input type="hidden" name="fnc" value="finalizeRegistration">
        <input type="hidden" name="cl" value="twofactor">
        <input type="hidden" name="step" value="[{$step}]">
        <input type="hidden" name="paymentActionLink" value="[{$paymentActionLink}]">
    </div>
    <div class="mt-10 flex justify-center">
            [{$oView->getTOTPQrCode()}]
    </div>
    <div class="mt-3 flex justify-center " id="OTPInput">
    </div>
    <input hidden id="otp" name="otp" value="">
    <div class="flex justify-center">
            <button id="accUserSaveTop" type="submit" name="save" class="mt-10 btn btn-primary">[{oxmultilang ident="SAVE"}]</button>
</div>
</form>
    [{oxscript include=$oViewConf->getModuleUrl('oxpspasswordpolicy','src/js/otpField.js')}]
[{/capture}]


[{include file="layout/page.tpl"}]

