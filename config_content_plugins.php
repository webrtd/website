<?
	require_once './plugins/content_plugins/article.php';
	require_once './plugins/content_plugins/article_admin.php';
	require_once './plugins/content_plugins/org_country.php';
	require_once './plugins/content_plugins/meeting.php';
	require_once './plugins/content_plugins/club.php';
	require_once './plugins/content_plugins/takeover.php';
	require_once './plugins/content_plugins/terms.php';
	require_once './plugins/content_plugins/user.php';
	require_once './plugins/content_plugins/search.php';
	require_once './plugins/content_plugins/nominations.php';
	require_once './plugins/content_plugins/banner.php';
	require_once './plugins/content_plugins/admin_download.php';
	require_once './plugins/content_plugins/newclubboard.php';
	require_once './plugins/content_plugins/biz.php';
	require_once './plugins/content_plugins/dashboard.php';
	require_once './plugins/content_plugins/tablerservice.php';
	require_once './plugins/content_plugins/nationalboard.php';
	require_once './plugins/content_plugins/mummy.php';
	require_once './plugins/content_plugins/stats.php';
	require_once './plugins/content_plugins/news.php';
	require_once './plugins/content_plugins/calendar.php';
	require_once './plugins/content_plugins/reports.php';
	require_once './plugins/content_plugins/other_meeting.php';


	// if no other content plugins matches - call the plugin associated with the following request	
	$content_plugin_default = 'aid';
?>