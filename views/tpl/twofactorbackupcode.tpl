[{capture append="oxidBlock_pageBody"}]
    [{$oViewConf->setFullWidth()}]
    <div class="min-h-screen flex flex-col justify-center text-center">
        <div class="container rounded h-100 align-items-center col-12 col-md-6 col-lg-6" style="width: 500px; background-color:white">
            <h1 class="mt-3 page-header text-center">[{oxmultilang ident="OXPS_PASSWORDPOLICY_TWOFACTORAUTH_BACKUPCODE"}]</h1>
            <span class="help-block">[{oxmultilang ident="OXPS_PASSWORDPOLICY_TWOFACTORAUTH_HELP_BACKUPCODE"}]</span>
            <h1 style="font-family: 'HelveticaNeue-Light',serif" class="mt-3">[{$oView->generateBackupCode()}]</h1>
            <form class="form-horizontal" action="[{$oViewConf->getSslSelfLink()}]" name="order" method="post" novalidate="novalidate">
                <div class="hidden">
                    [{$oViewConf->getHiddenSid()}]
                    [{$oViewConf->getNavFormParams()}]
                    <input type="hidden" name="fnc" value="getRedirectLink">
                    <input type="hidden" name="cl" value="twofactorbackup">
                    <input type="hidden" name="step" value="[{$step}]">
                    <input type="hidden" name="paymentActionLink" value="[{$paymentActionLink}]">
                </div>
                <div class="flex justify-center">
                    <button id="accUserSaveTop" type="submit" name="save" class="mt-3 mb-3 btn btn-primary">[{oxmultilang ident="OXPS_PASSWORDPOLICY_TWOFACTORAUTH_CONFIRM"}]</button>
                </div>
            </form>
        </div>
    </div>
    [{oxstyle include=$oViewConf->getModuleUrl('oxpspasswordpolicy','out/src/css/style.css')}]
    [{/capture}]

[{include file="layout/base.tpl"}]
[{include file="layout/footer.tpl"}]
