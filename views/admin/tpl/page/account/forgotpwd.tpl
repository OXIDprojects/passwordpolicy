<link rel="stylesheet" href="[{$oViewConf->getResourceUrl()}]login.css">
<link rel="stylesheet" href="[{$oViewConf->getResourceUrl()}]colors_[{$oViewConf->getEdition()|lower}].css">
<div class="admin-login-box">
    <div id="shopLogo"><img src="[{$oViewConf->getImageUrl('logo_dark.svg')}]" /></div>


    [{if $oView->showUpdateScreen()}]
        [{assign var="template_title" value="NEW_PASSWORD"|oxmultilangassign}]
    [{elseif $oView->updateSuccess()}]
        [{assign var="template_title" value="CHANGE_PASSWORD"|oxmultilangassign}]
    [{else}]
        [{assign var="template_title" value="FORGOT_PASSWORD"|oxmultilangassign}]
    [{/if}]


    [{if $oView->isExpiredLink()}]
        <div class="alert alert-danger">[{oxmultilang ident="ERROR_MESSAGE_PASSWORD_LINK_EXPIRED"}]</div>
    [{elseif $oView->showUpdateScreen()}]
        [{include file="form/forgotpwd_change_pwd.tpl"}]
    [{elseif $oView->updateSuccess()}]
        <div class="alert alert-success">[{oxmultilang ident="PASSWORD_CHANGED"}]</div>

        <form action="[{$oViewConf->getSelfActionLink()}]" name="forgotpwd" method="post" role="form">
            <div>
                <input type="hidden" name="cl" value="start">
                <button id="backToShop" class="submitButton largeButton btn btn-primary" type="submit">
                    <i class="fa fa-caret-left"></i> [{oxmultilang ident="BACK_TO_SHOP"}]
                </button>
            </div>
        </form>
    [{else}]
        [{if $oView->getForgotEmail()}]
            [{block name="page_account_forgot_email_sent"}]
                <div class="alert alert-info">[{oxmultilang ident="PASSWORD_WAS_SEND_TO"}] [{$oView->getForgotEmail()}]</div>
                <div class="bar">
                    <form action="[{$oViewConf->getSelfLink()}]" name="forgotpwd" method="post">
                        <div>
                            [{$oViewConf->getHiddenSid()}]
                            <input type="hidden" name="cl" value="start">
                            <button id="backToShop" class="btn btn-primary submitButton largeButton" type="submit">
                                <i class="fa fa-caret-left"></i> [{oxmultilang ident="BACK_TO_SHOP"}]
                            </button>
                        </div>
                    </form>
                </div>
            [{/block}]
        [{/if}]
    [{/if}]

[{oxstyle include=$oViewConf->getModuleUrl('oxpspasswordpolicy','out/src/css/styles.css')}]
[{oxstyle}]


</div>
<style>
    body {
        background: #fafafa;
    }
</style>