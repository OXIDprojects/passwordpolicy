<link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
[{capture append="oxidBlock_pageBody"}]
[{$oViewConf->setFullWidth()}]
<div class="min-h-screen flex flex-col justify-center text-center">
    <div class="container h-100 border border-dark align-items-center" style="width: 500px; background-color:white">
            <div class="content mb-3" id="content">
                <br>
                [{include file="message/errors.tpl"}]
            </div>
    <h1 class="page-header text-center">[{oxmultilang ident="TWOFACTORAUTHLOGIN"}]</h1>
        <span class="help-block">[{oxmultilang ident="MESSAGE_TWOFACTOR_LOGIN"}]</span>
<form class="form-horizontal" action="[{$oViewConf->getSslSelfLink()}]" name="order" method="post" novalidate="novalidate">
    <div class="hidden">
        [{$oViewConf->getHiddenSid()}]
        [{$oViewConf->getNavFormParams()}]
        <input type="hidden" name="fnc" value="finalizeLogin">
        <input type="hidden" name="cl" value="twofactorlogin">
        <input type="hidden" name="setsessioncookie" value="[{$setsessioncookie}]">
    </div>
    <div class="mt-3 flex justify-center " id="OTPInput">
    </div>
    <input hidden id="otp" name="otp" value="">
    <div class="flex justify-center">
            <button id="accUserSaveTop" type="submit" name="save" class="mt-10 btn btn-primary">[{oxmultilang ident="LOGIN"}]</button>
</div>
</form>
    </div>
</div>
    [{oxscript include=$oViewConf->getModuleUrl('oxpspasswordpolicy','out/src/js/otpField.js')}]
[{/capture}]

[{include file="layout/base.tpl"}]
[{include file="layout/footer.tpl"}]

<style>
    body
    {
        background-color: #EEEEEE;
    }
</style>