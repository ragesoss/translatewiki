<?php

require_once __DIR__ . '/FallbackSettings.php';

$GROUPS = __DIR__ . '/groups';

// 2015-05-18 Really broken now. Disabled.
// $wgSpecialPages['Magic'] = 'SpecialMagic';
$wgTranslateNewsletterPreference = true;

$wgTranslateCacheDirectory = "/resources/caches/translatewiki.net";
$wgTranslateDocumentationLanguageCode = 'qqq';
$wgTranslatePHPlot = '/home/betawiki/software/phplot/phplot.php';
$wgTranslateGroupRoot = '/resources/projects';
$wgTranslateMessageIndex = [ 'CDBMessageIndex' ];
$wgTranslateDelayedMessageIndexRebuild = true;
$wgTranslateDisablePreSaveTransform = true;
$wgTranslateCheckBlacklist = "$GROUPS/check-blacklist.php";
$wgTranslateYamlLibrary = 'phpyaml';
$wgULSCompactLanguageLinksBetaFeature = false;
$wgPageTranslationLanguageList = 'sidebar-only';

$wgTranslatePermissionUrl = 'Special:MainPage';
$wgTranslateUseSandbox = true;
$wgTranslateSandboxPromotedGroup = 'translator';

$lqtParams = [
	'lqt_method' => 'talkpage_new_thread',
	'lqt_subject_field' => 'About [[%MESSAGE%]]',
];
$phabParams = [
	'title' => '[[%MESSAGE%]] translation issue',
	'description' => "\n\n----\n\n**URL**: [[https://translatewiki.net/wiki/%MESSAGE%]]",
];
$githubParams = [
	'title' => '[[%MESSAGE%]] i18n issue',
	'body' => "[**URL**](https://translatewiki.net/wiki/%MESSAGE%)",
];
$phabUrl = 'https://phabricator.wikimedia.org/maniphest/task/edit/form/1/';
$wgTranslateSupportUrl = [
	'page' => 'Support',
	'params' => $lqtParams,
];

$wgTranslateStaticTags = [
	"tp:mark" => 3,
	"tp:tag" => 4,
	"tp:transver" => 5
];

$wgTranslateTranslationServices['TTMServer'] = [
	'type' => 'ttmserver',
	'class' => 'ElasticSearchTTMServer',
	'cutoff' => 0.75,
	'public' => true,
];

$wgHooks['Translate:GettextFFS:headerFields'][] = 'efHT';
function efHT( $specs, $group, $code ) {
	global $wgSitename, $wgCanonicalServer;
	$specs['Project-Id-Version'] = $group->getLabel();
	$specs['Report-Msgid-Bugs-To'] = $wgSitename;
	$server = $wgCanonicalServer;
	$specs['X-Translation-Project'] = "$wgSitename <$server>";
	return true;
}

$wgTranslateExtensionDirectory = '/resources/projects/mediawiki-extensions/extensions';

$wgTranslateCC['wiki-betawiki'] = 'customMessageGroups';
function customMessageGroups( $id ) {
	$mg = new WikiMessageGroup( 'wiki-betawiki', 'betawiki-messages' );
	$mg->setLabel( 'Translatewiki.net' );
	$mg->setDescription( '{{int:bw-desc-translatewiki-messages}}' );
	return $mg;
}

# Add aggregate message groups for MediaWiki extensions.
$wgTranslateGroupFiles[] = "$GROUPS/MediaWiki/mwgerrit.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/MediaWiki/mwgithub.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/MediaWiki/MediaWiki.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/MediaWiki/WikimediaMainAgg.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/MediaWiki/WikimediaAdvancedAgg.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/MediaWiki/WikimediaFundraisingAgg.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/MediaWiki/WikimediaLegacyAgg.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/MediaWiki/WikimediaMediaAgg.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/MediaWiki/WikimediaTechnicalAgg.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/MediaWiki/WikimediaUpcomingAgg.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/MediaWiki/WikimediaWikivoyageAgg.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/MediaWiki/WikimediaAgg.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/MediaWiki/ExtensionsAgg.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/MediaWiki/SkinsAgg.yaml";
$wgTranslateGroupAliases['ext-installer'] = 'mediawiki-installer';

$wgTranslateGroupFiles[] = "$GROUPS/PageTranslationAgg.yaml";

require_once "$GROUPS/MediaWiki/MediaWikiTopMessageGroup.php";

$wgHooks['TranslatePostInitGroups'][] = function ( &$list, &$deps, &$autoload ) use ( $GROUPS ) {
	# TODO: rename when possible
	$id = 'core-0-mostused';
	$msgs = "$GROUPS/MediaWiki/wikimedia-mostused-2015.txt";
	$code = "$GROUPS/MediaWiki/MediaWikiTopMessageGroup.php";

	$list[$id] = new MediaWikiTopMessageGroup( $id, $msgs );
	$deps[] = new FileDependency( realpath( $msgs ) );
	$deps[] = new FileDependency( realpath( $code ) );
};

$wgHooks['TranslatePostInitGroups'][] = function ( &$list, &$deps, &$autoload ) use ( $GROUPS ) {
	$def = "$GROUPS/MediaWiki/mediawiki-extensions.txt";
	$path = '%GROUPROOT%/mediawiki-extensions/';

	$foo = new PremadeMediawikiExtensionGroups( $def, $path );
	$foo->register( $list, $deps, $autoload );
};

$wgHooks['TranslatePostInitGroups'][] = function ( &$list, &$deps, &$autoload ) use ( $GROUPS ) {
	$def = "$GROUPS/MediaWiki/mediawiki-skins.txt";
	$path = '%GROUPROOT%/mediawiki-skins/';

	$foo = new PremadeMediawikiExtensionGroups( $def, $path );
	$foo->setGroupPrefix( 'mediawiki-skin-' );
	$foo->setUseConfigure( false );
	$foo->register( $list, $deps, $autoload );
};

$wgHooks['TranslatePostInitGroups'][] = function ( &$list, &$deps, &$autoload ) use ( $GROUPS ) {
	$def = "$GROUPS/Intuition/intuition-textdomains.txt";
	$path = '%GROUPROOT%/intuition/language/messages/';

	$foo = new PremadeIntuitionTextdomains( $def, $path );
	$foo->register( $list, $deps, $autoload );
};

$wgTranslateAuthorBlacklist[] = [ 'black', '/^.*;.*;(Andre Engels|Gangleri|Jon Harald Søby|IAlex|M.M.S.|BotMultichill|Nike|Piivaat|Raymond|RobertL|SieBot|Siebrand|SPQRobin|Suradnik13|Verdy p)$/Ui' ];
$wgTranslateAuthorBlacklist[] = [ 'black', '/^.*;da;(Wegge|Morten)$/Ui' ]; # are both credited under other names
$wgTranslateAuthorBlacklist[] = [ 'black', '/^out-mantis.*;nl;Siebrand$/Ui' ]; # credited under other name

$wgTranslateAuthorBlacklist[] = [ 'white', '/^.*;(qqq|fr);IAlex$/Ui' ];
$wgTranslateAuthorBlacklist[] = [ 'white', '/^.*;(qqq|sma|sv);M.M.S.$/Ui' ];
$wgTranslateAuthorBlacklist[] = [ 'white', '/^.*;(qqq|fi);Nike$/Ui' ];
$wgTranslateAuthorBlacklist[] = [ 'white', '/^.*;.*;Paucabot$/Ui' ];
$wgTranslateAuthorBlacklist[] = [ 'white', '/^.*;qqq;Raymond$/Ui' ];
$wgTranslateAuthorBlacklist[] = [ 'white', '/^out-osm.*;(qqq|de);Raymond$/Ui' ];
$wgTranslateAuthorBlacklist[] = [ 'white', '/^.*;qqq;RobertL$/Ui' ];
$wgTranslateAuthorBlacklist[] = [ 'white', '/^.*;(qqq|nl|nl-informal);Siebrand$/Ui' ];
$wgTranslateAuthorBlacklist[] = [ 'white', '/^.*;(qqq|nl|nl-informal|af|la|grc);SPQRobin$/Ui' ];
$wgTranslateAuthorBlacklist[] = [ 'white', '/^.*;(qqq|nb|no|nn|da|sv|en-gb);Jon Harald Søby$/Ui' ];
$wgTranslateAuthorBlacklist[] = [ 'white', '/^.*;(qqq|fr);Verdy p$/Ui' ];

$wgTranslateBlacklist = [
'*' => [
	'en' => 'English is the source language. Suggest improvements at [[Support]].',
	'ady' => 'This language code should remain unused. Localise in ady-cyrl please.',
	'aeb' => 'This language code should remain unused. Localise in aeb-arab please.',
	'als' => 'This language code should remain unused. Localise in gsw please.',
	'bat-smg' => 'This code is for compatibility purposes only. Localise in \'sgs\'',
	'bbc' => 'This language code should remain unused. Localise in bbc-latn please.',
	'bh' => 'This code is for compatibility purposes only. Localise in \'bho\'',
	'be-x-old' => 'This code is for compatibility purposes only. Localise in \'be-tarask\'',
	'cjy' => 'This language code should remain unused. Localise in cjy-hant please.',
	'crh' => 'This language code should remain unused. Localise in crh-latn or crh-cyrl please.',
	'dk' => 'This language code should remain unused. Localise in da please.',
	'es-419' => 'This language code should remain unused.',
	'fiu-vro' => 'This language code should remain unused. Localise in vro please.',
	'gan' => 'This language code should remain unused. Localise in gan-hant or gan-hans please.',
	'gom' => 'This language code should remain unused. Localise in gom-deva please.',
	# 'got' => 'This is an [http://www.sil.org/iso639-3/documentation.asp?id=got ancient language] without enough information to create a localisation. It cannot be localised in translatewiki.net.',
	'hif' => 'This language code should remain unused. Localise in hif-latn please.',
	'ike' => 'This language code should remain unused. Localise in ike-cans or ike-latn please.',
	'iu' => 'This language code should remain unused. Localise in ike-cans or ike-latn please.',
	'kbd' => 'This language code should remain unused. Localise in kbd-cyrl please.',
	'kk' => 'This language code should remain unused. Localise in kk-cyrl please.',
	'kk-cn' => 'This language code should remain unused. Localise in kk-arab please.',
	'kk-kz' => 'This language code should remain unused. Localise in kk-cyrl please.',
	'kk-tr' => 'This language code should remain unused. Localise in kk-latn please.',
	'ks' => 'This language code should remain unused. Localise in ks-arab (Arabic script) or ks-deva (Devanagari script) please.',
	'ku' => 'This code is for compatibility purposes only. Localise in \'ku-latn\'',
	'no' => 'This language code should remain unused. Use \'nb\'',
	'oge' => 'This is a [http://www.sil.org/iso639-3/documentation.asp?id=oge historical language]. It cannot be localised in translatewiki.net.',
	'roa-rup' => 'This language code should remain unused. Localise in rup nplease.',
	'ruq' => 'This language code should remain unused. Localise in ruq-latn please.',
	'simple' => 'This language code should remain unused.',
	'sr' => 'This language code should remain unused. Localise in sr-ec please.',
	'tg' => 'This language code should remain unused. Localise in tg-cyrl please.',
	'tp' => 'This language cannot be localised in translatewiki.net. It is not a valid language code.',
	'tokipona' => 'This language cannot be localised in translatewiki.net. It is not a valid language code.',
	'tt' => 'This language code should remain unused. Localise in tt-cyrl please.',
	'ug' => 'This language code should remain unused. Localise in ug-arab please.',
	'zh' => 'This language code should remain unused. Localise in zh-hans or zh-hant please.',
	'zh-classical' => 'This language code should remain unused. Localise in lzh please.',
	'zh-cn' => 'This language code should remain unused. Localise in zh-hans please.',
	'zh-tw' => 'This language code should remain unused. Localise in zh-hant please.',
	'zh-min-nan' => 'This language code should remain unused. Localise in nan please.',
	'zh-mo' => 'This language code should remain unused. Localise in zh-hk please.',
	'zh-my' => 'This language code should remain unused. Localise in zh-sg please.',
	'zh-sg' => 'This language code should remain unused. Localise in zh-hans please.',
	'zh-yue' => 'This language code should remain unused. Localise in yue please.',
],
'core' => [
	'es-mx' => 'This code is not used in MediaWiki. Use \'es\'.',
],
'ext' => [
	'es-mx' => 'This code is not used in MediaWiki. Use \'es\'.',
],
'out' => [
	'roa-tara' => 'This code is not available for this software.',
],
];

# Namespace 8
$wgTranslateMessageNamespaces[] = NS_MEDIAWIKI;
$wgMessagesDirs['MediawikiInstaller'] = "$IP/includes/installer/i18n";
$wgTranslateSupportUrlNamespace[NS_MEDIAWIKI] = [
	'url' => "$phabUrl?projects=i18n",
	'params' => $phabParams,
];

# No longer in use.
wfAddNamespace( 1200, 'Voctrain' );

wfAddNamespace( 1202, 'FreeCol' );
$wgTranslateGroupFiles[] = "$GROUPS/FreeCol/FreeCol.yaml";
$wgTranslateSupportUrlNamespace[NS_FREECOL] = [
	'page' => 'Translating_talk:FreeCol',
	'params' => $lqtParams,
];

wfAddNamespace( 1204, 'Nocc' );
$wgTranslateGroupFiles[] = "$GROUPS/Nocc/Nocc.yaml";

wfAddNamespace( 1206, 'Wikimedia' );
$wgTranslateGroupFiles[] = "$GROUPS/wikidata/wikidata.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/Wikimedia/CitationHunt.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/Wikimedia/CommonsAndroid.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/Wikimedia/CopyPatrol.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/Wikimedia/crosswatch.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/Wikimedia/GapFinder.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/Wikimedia/GrantMetrics.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/Wikimedia/jquery.uls.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/Wikimedia/ia-upload.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/Wikimedia/InteractionTimeline.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/Wikimedia/InternetArchiveBot.yaml";
$wgTranslateGroupAliases['out-jquery-uls'] = 'jquery-uls';
$wgTranslateGroupFiles[] = "$GROUPS/Wikimedia/Pageviews.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/Wikimedia/ProveIt.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/Wikimedia/video2commons.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/Wikimedia/wiki-ai.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/Wikimedia/WikiBlame.yaml";
$wgTranslateGroupAliases['out-wikiblame'] = 'wikiblame';
$wgTranslateGroupFiles[] = "$GROUPS/Wikimedia/WikiEduDashboard.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/Wikimedia/Wikimania.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/Wikimedia/WikimediaMobile-android.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/Wikimedia/WikimediaMobile-ios.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/Wikimedia/WikimediaMobile.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/Wikimedia/WikimediaPortals.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/Wikimedia/Wikinity.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/Wikimedia/WikipediaLibrary.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/Wikimedia/XTools.yaml";
$wgTranslateGroupAliases['out-pageviews'] = 'pageviews';

$wgTranslateSupportUrlNamespace[NS_WIKIMEDIA] = [
	'url' => "$phabUrl?projects=i18n,Wikimedia-General-or-Unknown",
	'params' => $phabParams,
];

# No longer in use.
wfAddNamespace( 1208, 'StatusNet' );

wfAddNamespace( 1210, 'Mantis' );
$wgTranslateGroupFiles[] = "$GROUPS/MantisBT/MantisBT.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/MantisBT/CodevTT.yaml";
$wgTranslateSupportUrlNamespace[NS_MANTIS] = [
	'page' => 'Translating_talk:MantisBT',
	'params' => $lqtParams,
];

# No longer in use.
wfAddNamespace( 1212, 'Mwlib' );

# No longer in use.
wfAddNamespace( 1214, 'Commonist' );

# No longer in use.
wfAddNamespace( 1216, 'OpenLayers' );

wfAddNamespace( 1218, 'FUDforum' );
$wgTranslateGroupFiles[] = "$GROUPS/FUDforum/FUDforum.yaml";

# No longer in use.
wfAddNamespace( 1220, 'Okawix' );

wfAddNamespace( 1222, 'Osm' );
$wgTranslateGroupFiles[] = "$GROUPS/OpenStreetMap/OpenStreetMap.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/OpenStreetMap/Potlatch2.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/OpenStreetMap/WaymarkedTrails.yaml";
$wgTranslateGroupAliases['out-osm-potlatch2-main'] = 'osm-potlatch2-main';
$wgTranslateGroupAliases['out-osm-potlatch2-help'] = 'osm-potlatch2-help';
$wgTranslateSupportUrlNamespace[NS_OSM] = [
	'page' => 'Translating_talk:OpenStreetMap',
	'params' => $lqtParams,
];

# No longer in use.
wfAddNamespace( 1224, 'WikiReader' );

# No longer in use.
wfAddNamespace( 1226, 'Shapado' );

# No longer in use.
wfAddNamespace( 1228, 'iHRIS' );

wfAddNamespace( 1230, 'Mifos' );
$wgTranslateGroupFiles[] = "$GROUPS/Mifos/Mifos.yaml";
$wgTranslateSupportUrlNamespace[NS_MIFOS] = [
	'page' => 'Translating_talk:Mifos',
	'params' => $lqtParams,
];

# No longer in use.
wfAddNamespace( 1232, 'Wikia' );

# No longer in use.
wfAddNamespace( 1234, 'OpenImages' );

# No longer in use.
wfAddNamespace( 1236, 'Europeana' );

wfAddNamespace( 1238, 'Pywikibot' );
$wgTranslateGroupFiles[] = "$GROUPS/Pywikibot/Pywikibot.yaml";
$wgNamespaceAliases['Pywikipedia'] = 1238;
$wgNamespaceAliases['Pywikipedia_talk'] = 1238;
$wgTranslateSupportUrlNamespace[NS_PYWIKIBOT] = [
	'page' => 'Translating_talk:Pywikibot',
	'params' => $lqtParams,
];

wfAddNamespace( 1240, 'Intuition' );
$wgTranslateGroupFiles[] = "$GROUPS/Intuition/IntuitionAgg.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/Intuition/dcatap.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/Intuition/heritage.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/Intuition/orphantalk.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/Intuition/raun.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/Intuition/refill.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/Intuition/web.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/Intuition/guc.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/Intuition/commtech-commons.yaml";
$wgNamespaceAliases['Toolserver'] = 1240;
$wgNamespaceAliases['Toolserver_talk'] = 1240;
$wgTranslateSupportUrlNamespace[NS_INTUITION] = [
	'url' => "$phabUrl?projects=i18n,Tool-Labs-tools-Other",
	'params' => $phabParams,
];

wfAddNamespace( 1242, 'EOL' );
$wgTranslateGroupFiles[] = "$GROUPS/EOL/EOL.yaml";
$wgTranslateSupportUrlNamespace[NS_EOL] = [
	'page' => 'Translating_talk:Encyclopedia_of_Life',
	'params' => $lqtParams,
];

wfAddNamespace( 1244, 'Kiwix' );
$wgTranslateGroupFiles[] = "$GROUPS/Kiwix/Kiwix.yaml";
$wgTranslateGroupAliases['out-kiwix'] = 'kiwix';
$wgTranslateSupportUrlNamespace[NS_KIWIX] = [
	'page' => 'Translating_talk:Kiwix',
	'params' => $lqtParams,
];

# No longer in use.
wfAddNamespace( 1246, 'Mozilla' );

wfAddNamespace( 1248, 'Huggle' );
$wgTranslateGroupFiles[] = "$GROUPS/Huggle/Huggle.yaml";
$wgTranslateGroupAliases['out-huggle'] = 'huggle';
$wgTranslateSupportUrlNamespace[NS_HUGGLE] = [
	'url' => "$phabUrl?projects=i18n,Huggle",
	'params' => $phabParams,
];

wfAddNamespace( 1250, 'EtherpadLite' );
$wgTranslateGroupFiles[] = "$GROUPS/EtherpadLite/EtherpadLite.yaml";
$wgTranslateGroupAliases['out-etherpad-lite'] = 'etherpad-lite';

wfAddNamespace( 1252, 'Vicuna' );
$wgTranslateGroupFiles[] = "$GROUPS/Vicuna/Vicuna.yaml";
$wgTranslateSupportUrlNamespace[NS_VICUNA] = [
	'page' => 'Translating_talk:Vicuña_Uploader',
	'params' => $lqtParams,
];

# No longer in use.
wfAddNamespace( 1254, 'FUEL' );

wfAddNamespace( 1256, 'Blockly' );
$wgTranslateGroupFiles[] = "$GROUPS/Blockly/Blockly.yaml";

wfAddNamespace( 1258, 'MathJax' );
$wgTranslateGroupFiles[] = "$GROUPS/MathJax/MathJax.yaml";
$wgTranslateSupportUrlNamespace[NS_MATHJAX] = [
	'page' => 'Translating_talk:MathJax',
	'params' => $lqtParams,
];

wfAddNamespace( 1260, 'NFCRingControl' );
$wgTranslateGroupFiles[] = "$GROUPS/NFCRingControl/NFCRingControl.yaml";
$wgTranslateGroupAliases['out-nfcring-control'] = 'nfcring-control';

wfAddNamespace( 1262, 'iNaturalist' );
$wgTranslateGroupFiles[] = "$GROUPS/iNaturalist/iNaturalist.yaml";
$wgTranslateSupportUrlNamespace[NS_INATURALIST] = [
	'page' => 'Translating_talk:iNaturalist',
	'params' => $lqtParams,
];

# No longer un use
wfAddNamespace( 1264, 'EntryScape' );
$wgCapitalLinkOverrides[NS_ENTRYSCAPE] = false;
$wgCapitalLinkOverrides[NS_ENTRYSCAPE_TALK] = false;

wfAddNamespace( 1266, 'Hivejs' );
$wgCapitalLinkOverrides[NS_HIVEJS] = false;
$wgCapitalLinkOverrides[NS_HIVEJS_TALK] = false;
$wgTranslateGroupFiles[] = "$GROUPS/hivejs/hivejs.yaml";
$wgTranslateSupportUrlNamespace[NS_HIVEJS] = [
	'page' => 'Translating_talk:Hive.js',
	'params' => $lqtParams,
];

wfAddNamespace( 1268, 'lib.reviews', 'NS_LIBREVIEWS' );
$wgCapitalLinkOverrides[NS_LIBREVIEWS] = false;
$wgCapitalLinkOverrides[NS_LIBREVIEWS_TALK] = false;
$wgTranslateGroupFiles[] = "$GROUPS/lib.reviews/lib.reviews.yaml";
$wgTranslateSupportUrlNamespace[NS_LIBREVIEWS] = [
	'page' => 'Translating_talk:lib.reviews',
	'params' => $lqtParams,
];

wfAddNamespace( 1270, 'Oppia' );
$wgCapitalLinkOverrides[NS_OPPIA] = false;
$wgCapitalLinkOverrides[NS_OPPIA_TALK] = false;
$wgTranslateGroupFiles[] = "$GROUPS/Oppia/Oppia.yaml";
$wgTranslateSupportUrlNamespace[NS_OPPIA] = [
	'page' => 'Translating_talk:Oppia',
	'params' => $lqtParams,
];

wfAddNamespace( 1272, 'Dissemin' );
$wgCapitalLinkOverrides[NS_DISSEMIN] = false;
$wgCapitalLinkOverrides[NS_DISSEMIN_TALK] = false;
$wgTranslateGroupFiles[] = "$GROUPS/Dissemin/Dissemin.yaml";
$wgTranslateSupportUrlNamespace[NS_DISSEMIN] = [
	'url' => 'https://github.com/dissemin/dissemin/issues/new',
	'params' => $githubParams,
];

wfAddNamespace( 1274, 'Phabricator' );
$wgCapitalLinkOverrides[NS_PHABRICATOR] = false;
$wgCapitalLinkOverrides[NS_PHABRICATOR_TALK] = false;
$wgTranslateGroupFiles[] = "$GROUPS/Phabricator/PhabricatorAgg.yaml";
$wgTranslateGroupFiles[] = "$GROUPS/Phabricator/Phabricator.yaml";

wfAddNamespace( 1276, 'Ajapaik' );
$wgCapitalLinkOverrides[NS_AJAPAIK] = false;
$wgCapitalLinkOverrides[NS_AJAPAIK] = false;
$wgTranslateGroupFiles[] = "$GROUPS/Ajapaik/Ajapaik.yaml";

wfAddNamespace( 1278, 'LibreMesh' );
$wgCapitalLinkOverrides[NS_LIBREMESH] = false;
$wgCapitalLinkOverrides[NS_LIBREMESH_TALK] = false;
$wgTranslateGroupFiles[] = "$GROUPS/LibreMesh/LibreMesh.yaml";

wfAddNamespace( 1280, 'MAZI' );
$wgCapitalLinkOverrides[NS_MAZI] = false;
$wgCapitalLinkOverrides[NS_MAZI_TALK] = false;
$wgTranslateGroupFiles[] = "$GROUPS/MAZI/MAZI.yaml";
$wgTranslateSupportUrlNamespace[NS_MAZI] = [
	'page' => 'Translating_talk:MAZI_Toolkit',
	'params' => $lqtParams,
];
