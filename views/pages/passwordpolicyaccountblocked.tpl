[{assign var="template_title" value="OXPS_PASSWORDPOLICY_ACCOUNTBLOCKED_TITLE"|oxmultilangassign }]
[{capture append="oxidBlock_content"}]
<h1 id="loginAccount" class="pageHead">[{ oxmultilang ident="OXPS_PASSWORDPOLICY_ACCOUNTBLOCKED_TITLE" }]</h1>
<p>[{ oxmultilang ident="OXPS_PASSWORDPOLICY_ACCOUNTBLOCKED_INFO" }]</p>
<p>[{ oxmultilang ident="OXPS_PASSWORDPOLICY_ACCOUNTBLOCKED_HINT" }]</p>
[{if $blAllowUnblock }]
    <p>
        [{ oxmultilang ident="OXPS_PASSWORDPOLICY_ACCOUNTBLOCKED_ACTION" }]:
        <a href="[{ $sShopUrl }]?cl=forgotpwd" class="link">
            <strong>[{ oxmultilang ident="OXPS_PASSWORDPOLICY_ACCOUNTBLOCKED_RESETPASS"}]</strong>
        </a>.
    </p>
[{/if}]
<p>[{ oxmultilang ident="OXPS_PASSWORDPOLICY_ACCOUNTBLOCKED_CONTACT" }]</p>
[{insert name="oxid_tracker" title=$template_title }]
[{/capture}]

[{include file="layout/page.tpl"}]