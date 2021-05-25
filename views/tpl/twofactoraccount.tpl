[{capture append="oxidBlock_content"}]
    [{assign var="template_title" value="TWOFACTORAUTHLOGIN"|oxmultilangassign}]
    [{if $success == '1'}]
    <div class="alert alert-success">[{oxmultilang ident="MESSAGE_TWOFACTOR_SUCCESS"}]</div>
    [{elseif $success == '2'}]
    <div class="alert alert-success">[{oxmultilang ident="MESSAGE_TWOFACTOR_DEACTIVATED"}]</div>
    [{/if}]
    <h1 id="twofactorheader" class="page-header">[{oxmultilang ident="TWOFACTORAUTHLOGIN"}]</h1>
    <form action="[{$oViewConf->getSelfActionLink()}]" name="newsletter" class="form-horizontal" method="post">
        <div class="hidden">
            [{$oViewConf->getHiddenSid()}]
            [{$oViewConf->getNavFormParams()}]
            <input type="hidden" name="fnc" value="redirect">
            <input type="hidden" name="cl" value="twofactoraccount">
        </div>

        <div class="form-group">
            <label class="control-label col-lg-3">[{oxmultilang ident="TWOFACTORAUTHCHECKBOX"}]</label>
            <div class="col-lg-4">
                <select name="status" id="status" class="form-control ">
                    <option value="1"[{if $oView->isTOTP()}] selected[{/if}] >[{oxmultilang ident="YES"}]</option>
                    <option value="0"[{if !$oView->isTOTP()}] selected[{/if}] >[{oxmultilang ident="NO"}]</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="offset-lg-3 col-lg-7">
                <button id="twofactorsave" type="submit" class="btn btn-primary">[{oxmultilang ident="SAVE"}]</button>
            </div>
        </div>
    </form>
    [{/capture}]
[{capture append="oxidBlock_sidebar"}]
    [{include file="page/account/inc/account_menu.tpl" active_link="twofactor"}]
    [{/capture}]
[{include file="layout/page.tpl" sidebar="Left"}]