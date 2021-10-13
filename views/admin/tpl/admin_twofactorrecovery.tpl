<div class="min-h-screen flex flex-col justify-center text-center">
        <div class="container rounded h-100 align-items-center col-12 col-md-6 col-lg-6" style="width: 500px; background-color:white">
            <div class="content mt-3" id="content">
                [{include file="message/errors.tpl"}]
            </div>
            <h1 class="mt-3 page-header text-center">[{oxmultilang ident="OXPS_PASSWORDPOLICY_TWOFACTORAUTH_RECOVERY"}]</h1>
            <span class="help-block">[{oxmultilang ident="OXPS_PASSWORDPOLICY_TWOFACTORAUTH_HELP_RECOVERY"}]</span>
            <form class="form-horizontal" action="[{$oViewConf->getSelfLink()}]" name="order" method="post" novalidate="novalidate">
                <div class="hidden">
                    [{$oViewConf->getHiddenSid()}]
                    <input type="hidden" name="fnc" value="redirect">
                    <input type="hidden" name="cl" value="admin_twofactorrecovery">
                </div>
                <div class="mt-3 mb-3 flex justify-center ">
                    <input class="border border-dark w-100 h-12 bg-gray-100 border-gray-50 font-light outline-none focus:bg-gray-200 m-2 text-center rounded focus:border-blue-200 focus:shadow-outline" name="recoveryCode"  maxlength="20" style="font-family: HelveticaNeue-Light,sans-serif; font-size: large">
                </div>
                <div class="flex justify-center">
                    <button id="accUserSaveTop" type="submit" name="save" class="mt-1 mb-1 btn btn-primary">[{oxmultilang ident="OXPS_PASSWORDPOLICY_TWOFACTORAUTH_RESET"}]</button>
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

