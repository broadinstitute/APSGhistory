<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <title>Administration panel</title>
    <link rel="stylesheet" type="text/css" href="phpgen.css" />
    <link rel="stylesheet" type="text/css" href="grid.css" />
    <link rel="stylesheet" type="text/css" href="components/css/common_style.css" />
    <link rel="stylesheet" type="text/css" href="components/css/reset.css" />
    <link rel="stylesheet/less" type="text/css" href="components/css/admin_panel.less" />
    <link rel="stylesheet" type="text/css" href="libs/jquery/css/jquery-ui-1.8.10.custom.css" media="screen" />
    
    <script src="components/js/less-1.1.5.min.js" type="text/javascript"></script>

    <script type="text/javascript" src="libs/jquery/jquery-1.7.min.js"></script>
    <script type="text/javascript" src="components/js/mootools-core-1.4.1.js"></script>

    <script type="text/javascript" src="libs/jquery/development-bundle/ui/jquery.ui.core.js"></script>
    <script type="text/javascript" src="libs/jquery/development-bundle/ui/jquery.ui.widget.js"></script>
    <script type="text/javascript" src="libs/jquery/development-bundle/ui/jquery.ui.button.js"></script>
    <script type="text/javascript" src="libs/jquery/development-bundle/ui/jquery.ui.mouse.js"></script>
    <script type="text/javascript" src="libs/jquery/development-bundle/ui/jquery.ui.draggable.js"></script>
    <script type="text/javascript" src="libs/jquery/development-bundle/ui/jquery.ui.position.js"></script>
    <script type="text/javascript" src="libs/jquery/development-bundle/ui/jquery.ui.resizable.js"></script>
    <script type="text/javascript" src="libs/jquery/development-bundle/ui/jquery.ui.dialog.js"></script>
    <script type="text/javascript" src="libs/jquery/jquery.tabs.min.js"></script>
    <script type="text/javascript" src="libs/jquery/jquery.tmpl.js"></script>
    <script type="text/javascript" src="components/js/knockout-1.2.1.js"></script>
    <script type="text/javascript" src="components/js/jquery.tools.history.min.js"></script>

    <script type="text/javascript">
    {literal}
        PhpGenAdmin = {};
        PhpGenAdmin.CurrentUsers = {/literal}{$Users}{literal};
    {/literal}
    </script>
    <script type="text/javascript" src="components/js/pgui.admin_panel.js"></script>
</head>

<body>
{include file='common/site_header.tpl'}

<div id="pg-admin-create-user-dialog" class="pgui-form" title="Create user">
    <div class="comment">All form fields are required.</div>
    <form>
        <table class="fieldset-container">
            <tr class="field">
                <td><label for="newuser-id">Id:</label></td>
                <td><input id="newuser-id" name="id" data-bind="value: newUser.id" /></td>
            </tr>
            <tr class="field">
                <td><label for="newuser-username">Name:</label></td>
                <td><input id="newuser-username" name="username" data-bind="value: newUser.name" /></td>
            </tr>
            <tr class="field">
                <td><label for="newuser-password">Password:</label></td>
                <td><input id="newuser-password" type="password" name="password" data-bind="value: newUser.password" /></td>
            </tr>
        </table>
    </form>
</div>

<div id="pg-admin-change-user-password-dialog" class="pgui-form" title="Create user">
    <div class="comment">Change password for user '<span data-bind="text: changePasswordUser.name"></span>'.</div>
    <form>
        <table class="fieldset-container">
            <tr class="field">
                <td><label for="chpass-user-password">New password:</label></td>
                <td><input id="chpass-user-password" type="password" name="password" data-bind="value: changePasswordUser.password" /></td>
            </tr>
        </table>
    </form>
</div>

<div id="pg-admin-edit-user-dialog" class="pgui-form" title="Edit user">
    <div class="comment">All form fields are required.</div>
    <form>
        <table class="fieldset-container">
            <tr class="field">
                <td><label>Id:</label></td>
                <td><span data-bind="text: editUser.id"></span></td>
            </tr>
            <tr class="field">
                <td><label for="user-username">Name:</label></td>
                <td><input id="user-username" name="username" data-bind="value: editUser.name" /></td>
            </tr>
        </table>
    </form>
</div>

<table class="pgui-admin-content"><tbody><tr>
<td class="page-list-column" valign="top">
    <div id="page_section" class="page_list">
        <h3><span>{$Captions->GetMessageString('PageList')}</span></h3>
        <ul>
            {foreach item=PageLink from=$PageLinks}
                <li>
                    <a href="{$PageLink.Link}"
                       title="{$PageLink.Hint}">
                        <span title="{$PageLink.Hint}">{$PageLink.Caption}</span>
                    </a>
                </li>
            {/foreach}
        </ul>
    </div>
</td>
<td class="pg-admin-container-column" valign="top">

    <div class="pg-admin-container">
        
        <h2 class="page_header">Administration panel</h2>

    <div class="admin-tabs">
        <ul class="tabs">
            <li class="users"><a href="#users"><span>Users</span></a></li>
        </ul>
        <div class="panes">

            <div class="admin-users">
                <div class="actions">
                    <button class="add-user" data-bind="click: invokeAddUserDialog"><span>Add user...</span></button>
                </div>
                <table class="top-level-table users">
                    <thead>
                        <tr>
                            <th colspan="2">Actions</th>
                            <th>User name</th>
                        </tr>
                    </thead>
                    {literal}
                    <tbody data-bind="template: { name: 'usersRowTemplate', foreach: usersOnCurrentPage }">
                        <script type="text/html" id="usersRowTemplate">
                        <tr class="users-row">
                            <td class="show-user-grants">
                                <div class="show-user-grants"
                                    data-bind="css: { expanded: grantsExpanded() == true }">
                                <button class="show-user-grants" title="Show user grants"
                                    data-bind="click: toggleGrantsExpanded, css: { expanded: grantsExpanded() == true }">
                                    <span>Permissions</span>
                                </button>
                                </div>
                            </td>

                            <td class="actions">
                                <button
                                    class="edit-user"
                                    title="Edit user"
                                    data-bind="click: function() { PhpGenAdmin.adminPanelViewModel.invokeEditUserDialog($data); }, visible: editable">
                                    <span>Rename</span>
                                </button>

                                <button
                                    class="change-user-password"
                                    title="Edit user"
                                    data-bind="click: function() { PhpGenAdmin.adminPanelViewModel.invokeChangeUserPasswordDialog($data); }, visible: editable">
                                    <span>Change password</span>
                                </button>

                                <button
                                    class="delete-user"
                                    title="Delete user"
                                    data-bind="click: function() { PhpGenAdmin.adminPanelViewModel.invokeRemoveUserDialog($data); }, visible: editable">
                                    <span>Delete</span>
                                </button>

                            </td>

                            <td class="user-name"><span data-bind="text: name"></span></td>
                        </tr>

                        <tr class="grants-row">
                            <td class="grants-row" colspan="3" data-bind="visible: grantsExpanded">
                                <div class="grants-container">
                                    <div class="loading-panel" data-bind="visible: !grantsLoaded()">
                                        <div>Loading...</div>
                                    </div>
                                    <table data-bind="visible: grantsLoaded()">
                                        <thead>
                                            <tr>
                                                <th>Page name</th>
                                                <th>Admin</th>
                                                <th>Select</th>
                                                <th>Update</th>
                                                <th>Insert</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody data-bind="template: { name: 'userGrantsTemplate', foreach: grants }"></tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <tr class="delimiter">
                            <td colspan="3"></td>
                        </tr>

                        </script>

                        <script type="text/html" id="userGrantsTemplate">
                            <tr>
                                <td class="page-caption"><span data-bind="text: caption"></span></td>
                                <td class="page-grant"><input type="checkbox" data-bind="checked: adminGrant" /></td>
                                <td class="page-grant"><input type="checkbox" data-bind="checked: selectGrant" /></td>
                                <td class="page-grant"><input type="checkbox" data-bind="checked: updateGrant" /></td>
                                <td class="page-grant"><input type="checkbox" data-bind="checked: insertGrant" /></td>
                                <td class="page-grant"><input type="checkbox" data-bind="checked: deleteGrant" /></td>
                            </tr>
                        </script>

                    </tbody>
                    {/literal}
                </table>
                <div class="actions">
                    <button class="add-user" data-bind="click: invokeAddUserDialog"><span>Add user...</span></button>
                </div>
            </div>
            
        </div>
    </div>
</div>
    
</td>
</tr></tbody></table>

</body>
</html>