

<link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
[{capture append="oxidBlock_pageBody"}]
<div class="min-h-screen flex flex-col justify-center text-center border border-dark">

<form class="form-horizontal" action="[{$oViewConf->getSslSelfLink()}]" name="order" method="post" novalidate="novalidate">
    <div class="hidden">
        [{$oViewConf->getHiddenSid()}]
        [{$oViewConf->getNavFormParams()}]
        <input type="hidden" name="fnc" value="finalizeRegistration">
        <input type="hidden" name="cl" value="twofactorregister">
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
            <button id="accUserSaveTop" type="submit" name="save" class="mt-10 button button-primary font-bold text-lg px-6 pt-3 pb-3 rounded bg-black text-white">[{oxmultilang ident="SAVE"}]</button>

</div>
</form>
</div>
    <style>
        body {
        background: white;
        }
    </style>
    [{oxscript include=$oViewConf->getModuleUrl('oxpspasswordpolicy','src/js/otpField.js')}]
[{/capture}]

[{include file="layout/base.tpl"}]

[{include file="layout/footer.tpl"}]
