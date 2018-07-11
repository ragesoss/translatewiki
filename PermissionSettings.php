<?php

$wgGroupPermissions['*'            ]['edit'] = false;
$wgGroupPermissions['*'            ]['createaccount'] = false;

$wgGroupPermissions['user'         ]['skipcaptcha'] = false;
$wgGroupPermissions['autoconfirmed']['skipcaptcha'] = true;
$wgGroupPermissions['bot'          ]['skipcaptcha'] = true; // registered bots
$wgGroupPermissions['sysop'        ]['skipcaptcha'] = true;
$wgGroupPermissions['translator'   ]['skipcaptcha'] = true;

$wgGroupPermissions['user'         ]['move']                    = false;
$wgGroupPermissions['user'         ]['move-subpages']           = false;
$wgGroupPermissions['user'         ]['move-rootuserpages']      = false;
$wgGroupPermissions['user'         ]['movefile']                = false;
$wgGroupPermissions['user'         ]['move-categorypages']      = false;
$wgGroupPermissions['autoconfirmed']['move']                    = false;
$wgGroupPermissions['autoconfirmed']['move-subpages']           = false;
$wgGroupPermissions['sysop'        ]['move']                    = true;
$wgGroupPermissions['sysop'        ]['move-subpages']           = true;
$wgGroupPermissions['sysop'        ]['move-rootuserpages']      = true;
$wgGroupPermissions['translator'   ]['translate-messagereview'] = true;
$wgGroupPermissions['bot'          ]['move']                    = true;
$wgGroupPermissions['bot'          ]['move-subpages']           = true;
$wgGroupPermissions['bot'          ]['move-rootuserpages']      = true;

// nike 2009-08-03, 2011-03-11
$wgGroupPermissions['*'            ]['createtalk']              = false;
$wgGroupPermissions['user'         ]['createtalk']              = true;
$wgGroupPermissions['*'            ]['createpage']              = false;
$wgGroupPermissions['user'         ]['createpage']              = true;

// Siebrand 2009-09-27: preventing spam send from new accounts
$wgGroupPermissions['user'         ]['sendemail']               = false;
$wgGroupPermissions['autoconfirmed']['sendemail']               = true;

$wgGroupPermissions['*'            ]['minoredit']               = true;
$wgGroupPermissions['*'            ]['webchat']                 = true;

$wgGroupPermissions['translator'   ]['editinterface']           = true;
$wgGroupPermissions['translator'   ]['translate']               = true;
$wgGroupPermissions['sysop'        ]['delete']                  = true;
$wgGroupPermissions['translator'   ]['deletedhistory']          = true;

$wgGroupPermissions['sysop'        ]['import']                  = false;
$wgGroupPermissions['sysop'        ]['importupload']            = false;
$wgGroupPermissions['sysop'        ]['suppressredirect']        = true;
# Temporary until core extends it, bug 9360
$wgGroupPermissions['sysop'        ]['pagelang'] = true;

$wgGroupPermissions['bureaucrat'   ]['deletelogentry']          = true;
$wgGroupPermissions['bureaucrat'   ]['deleterevision']          = true;
$wgGroupPermissions['bureaucrat'   ]['interwiki']               = true;
$wgGroupPermissions['bureaucrat'   ]['nuke']                    = true;
$wgGroupPermissions['bureaucrat'   ]['pagetranslation']         = true;
$wgGroupPermissions['bureaucrat'   ]['renameuser']              = false;
$wgGroupPermissions['bureaucrat'   ]['suppressionlog']          = true;
$wgGroupPermissions['bureaucrat'   ]['translate-sandboxmanage'] = true;
$wgGroupPermissions['bureaucrat'   ]['userrights']              = false;
$wgGroupPermissions['bureaucrat'   ]['invitesignup']            = true;

$wgGroupPermissions['staff'        ]['nuke']                    = true;
$wgGroupPermissions['staff'        ]['renameuser']              = true;
$wgGroupPermissions['staff'        ]['reset-passwords']         = true;
$wgGroupPermissions['staff'        ]['suppressrevision']        = true;
$wgGroupPermissions['staff'        ]['translate-import']        = true;
$wgGroupPermissions['staff'        ]['translate-manage']        = true;
$wgGroupPermissions['staff'        ]['usermerge']               = true;
$wgGroupPermissions['staff'        ]['checkuser']               = true;
$wgGroupPermissions['staff'        ]['checkuser-log']           = true;
$wgGroupPermissions['staff'        ]['replacetext']             = true;
$wgGroupPermissions['sysop'        ]['replacetext']             = false;

$wgGroupPermissions['offline'      ]['translate-import'] = true;

$wgGroupPermissions['transadmin'   ]['translate-manage'] = true;

$wgAddGroups['staff'] = $wgRemoveGroups['staff'] = true;
$wgRemoveGroups['bureaucrat'] = $wgAddGroups['bureaucrat'   ] = [ 'sysop', 'translator', 'bot', 'offline' ];
$wgGroupsRemoveFromSelf['translator'] = [ 'translator' ];

$wgSysopUserBans  = true;
$wgSysopRangeBans = true;

$wgNamespaceProtection[NS_FILE] = [ 'translate' ];
$wgNamespaceProtection[NS_TEMPLATE] = [ 'translate' ];

# Patrolling
$wgGroupPermissions['translator']['autopatrol'] = true;
$wgUseRCPatrol = true;
