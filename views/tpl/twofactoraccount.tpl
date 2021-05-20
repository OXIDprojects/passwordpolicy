[{capture append="oxidBlock_content"}]
    [{assign var="template_title" value="TWOFACTORLOGIN"|oxmultilangassign}]

    [{/capture}]
[{capture append="oxidBlock_sidebar"}]
    [{include file="page/account/inc/account_menu.tpl" active_link="twofactor"}]
    [{/capture}]
[{include file="layout/page.tpl" sidebar="Left"}]