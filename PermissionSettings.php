<?php

$wgGroupPermissions[ '*'             ][ 'edit'                    ] = false;
$wgGroupPermissions[ '*'             ][ 'createaccount'           ] = false;

$wgGroupPermissions[ 'user'          ][ 'move'                    ] = false;
$wgGroupPermissions[ 'user'          ][ 'move-subpages'           ] = false;
$wgGroupPermissions[ 'user'          ][ 'move-rootuserpages'      ] = false;
$wgGroupPermissions[ 'user'          ][ 'movefile'                ] = false;
$wgGroupPermissions[ 'user'          ][ 'move-categorypages'      ] = false;
$wgGroupPermissions[ 'user'          ][ 'createclass'             ] = false;

$wgGroupPermissions[ 'autoconfirmed' ][ 'sendemail'               ] = true;

$wgGroupPermissions[ 'translator'    ][ 'editinterface'           ] = true;
$wgGroupPermissions[ 'translator'    ][ 'translate'               ] = true;
$wgGroupPermissions[ 'translator'    ][ 'translate-messagereview' ] = true;
$wgGroupPermissions[ 'translator'    ][ 'skipcaptcha'             ] = true;
$wgGroupsRemoveFromSelf[ 'translator' ] =
	[ 'translator' ];

$wgGroupPermissions[ 'offline'       ][ 'translate-import'        ] = true;

$wgGroupPermissions[ 'bot'           ][ 'skipcaptcha'             ] = true;
$wgGroupPermissions[ 'bot'           ][ 'move'                    ] = true;
$wgGroupPermissions[ 'bot'           ][ 'move-subpages'           ] = true;
$wgGroupPermissions[ 'bot'           ][ 'move-rootuserpages'      ] = true;

$wgGroupPermissions[ 'sysop'         ][ 'import'                  ] = false;
$wgGroupPermissions[ 'sysop'         ][ 'importupload'            ] = false;
$wgGroupPermissions[ 'sysop'         ][ 'replacetext'             ] = false;
$wgGroupPermissions[ 'sysop'         ][ 'smw-admin'               ] = false;
$wgGroupPermissions[ 'sysop'         ][ 'delete'                  ] = true;
$wgGroupPermissions[ 'sysop'         ][ 'suppressredirect'        ] = true;
$wgGroupPermissions[ 'sysop'         ][ 'skipcaptcha'             ] = true;

$wgGroupPermissions[ 'bureaucrat'    ][ 'deletelogentry'          ] = true;
$wgGroupPermissions[ 'bureaucrat'    ][ 'deleterevision'          ] = true;
$wgGroupPermissions[ 'bureaucrat'    ][ 'interwiki'               ] = true;
$wgGroupPermissions[ 'bureaucrat'    ][ 'nuke'                    ] = true;
$wgGroupPermissions[ 'bureaucrat'    ][ 'pagetranslation'         ] = true;
$wgGroupPermissions[ 'bureaucrat'    ][ 'userrights'              ] = false;
$wgGroupPermissions[ 'bureaucrat'    ][ 'suppressionlog'          ] = true;
$wgGroupPermissions[ 'bureaucrat'    ][ 'translate-sandboxmanage' ] = true;
$wgGroupPermissions[ 'bureaucrat'    ][ 'invitesignup'            ] = true;
$wgGroupPermissions[ 'bureaucrat'    ][ 'suppressrevision'        ] = true;
$wgRemoveGroups[ 'bureaucrat' ] = $wgAddGroups[ 'bureaucrat' ] =
	[ 'sysop', 'translator', 'bot', 'offline' ];

$wgGroupPermissions[ 'transadmin'    ][ 'translate-manage'        ] = true;
$wgGroupPermissions[ 'transadmin'    ][ 'replacetext'             ] = true;
$wgGroupPermissions[ 'transadmin'    ][ 'translate-import'        ] = true;
$wgGroupPermissions[ 'transadmin'    ][ 'nuke'                    ] = true;

$wgGroupPermissions[ 'staff'         ][ 'reset-passwords'         ] = true;
$wgGroupPermissions[ 'staff'         ][ 'usermerge'               ] = true;

$wgAddGroups[ 'staff' ] = $wgRemoveGroups[ 'staff' ] = true;

// Remove preset smw and other extension groups
$wgExtensionFunctions[] = function () use ( &$wgGroupPermissions ) {
	$wgGroupPermissions[ 'staff' ] = array_merge(
		$wgGroupPermissions[ 'smwadministrator' ],
		$wgGroupPermissions[ 'smwcurator' ],
		$wgGroupPermissions[ 'checkuser' ],
		$wgGroupPermissions[ 'staff' ]
	);
	unset(
		$wgGroupPermissions[ 'smwadministrator' ],
		$wgGroupPermissions[ 'smwcurator' ],
		$wgGroupPermissions[ 'checkuser' ]
	);
};
