<?

function build_database($dbname, $dbhost, $dbuser, $dbpassword) 
{
	$database_sql = "
	CREATE TABLE IF NOT EXISTS `article` (
	  `aid` int(11) NOT NULL,
	  `title` varchar(255) DEFAULT NULL,
	  `content` blob,
	  `uid` int(11) DEFAULT NULL,
	  `public` tinyint(1) DEFAULT '0',
	  `last_update` datetime DEFAULT NULL,
	  `parent_aid` int(11) DEFAULT '-1',
	  `weight` int(11) DEFAULT '0',
	  `link` text
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	CREATE TABLE IF NOT EXISTS `article_file` (
	  `afid` int(11) NOT NULL,
	  `aid` int(11) DEFAULT NULL,
	  `mimetype` varchar(255) DEFAULT NULL,
	  `filename` varchar(255) DEFAULT NULL,
	  `show_in_gallery` tinyint(1) DEFAULT '1'
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	CREATE TABLE IF NOT EXISTS `banner` (
	  `bid` int(11) NOT NULL,
	  `image` blob,
	  `startdate` date DEFAULT NULL,
	  `enddate` date DEFAULT NULL,
	  `position` int(11) DEFAULT NULL,
	  `mimetype` text,
	  `title` varchar(255) DEFAULT NULL,
	  `link` varchar(255) DEFAULT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	CREATE TABLE IF NOT EXISTS `banner_click` (
	  `bid` int(11) DEFAULT NULL,
	  `clicktime` datetime DEFAULT NULL,
	  `ipn` int(10) unsigned DEFAULT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	CREATE TABLE IF NOT EXISTS `club` (
	  `cid` int(10) unsigned NOT NULL,
	  `name` varchar(32) DEFAULT '',
	  `description` varchar(255) DEFAULT '',
	  `meeting_place` varchar(255) DEFAULT '',
	  `meeting_time` varchar(255) DEFAULT '',
	  `webpage` varchar(255) DEFAULT '',
	  `charter_date` date DEFAULT NULL,
	  `charter_club_cid` int(11) DEFAULT NULL,
	  `district_did` int(11) DEFAULT NULL,
	  `mummy_password` varchar(255) NOT NULL DEFAULT 'password123',
	  `webmail_password` varchar(255) DEFAULT ' '
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	CREATE TABLE IF NOT EXISTS `cronjob` (
	  `id` int(11) NOT NULL,
	  `ts` datetime DEFAULT NULL,
	  `log` text
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	CREATE TABLE IF NOT EXISTS `district` (
	  `did` int(10) unsigned NOT NULL,
	  `name` varchar(32) DEFAULT '',
	  `description` varchar(255) DEFAULT ''
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	CREATE TABLE IF NOT EXISTS `geolocation` (
	  `gid` int(11) NOT NULL,
	  `lat` double DEFAULT NULL,
	  `lng` double DEFAULT NULL,
	  `refid` int(11) DEFAULT NULL,
	  `reftype` varchar(10) DEFAULT NULL,
	  `expiry_date` datetime DEFAULT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	CREATE TABLE IF NOT EXISTS `log` (
	  `lid` int(11) NOT NULL,
	  `remote_addr` varchar(128) DEFAULT NULL,
	  `section` varchar(128) DEFAULT NULL,
	  `logtext` text,
	  `ts` datetime DEFAULT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	CREATE TABLE IF NOT EXISTS `mass_mail` (
	  `id` int(11) NOT NULL,
	  `processed` tinyint(1) DEFAULT '0',
	  `mail_subject` text,
	  `mail_content` text,
	  `mail_receiver` text,
	  `submit_time` datetime DEFAULT NULL,
	  `processed_time` datetime DEFAULT NULL,
	  `aid` int(11) NOT NULL DEFAULT '0',
	  `uid` int(11) DEFAULT '0'
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	CREATE TABLE IF NOT EXISTS `mass_mail_attachment` (
	  `aid` int(11) NOT NULL,
	  `filename` varchar(255) DEFAULT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	CREATE TABLE IF NOT EXISTS `meeting` (
	  `mid` int(10) unsigned NOT NULL,
	  `cid` int(10) unsigned DEFAULT NULL,
	  `start_time` datetime DEFAULT NULL,
	  `end_time` datetime DEFAULT NULL,
	  `title` varchar(255) DEFAULT NULL,
	  `description` text,
	  `location` varchar(255) DEFAULT NULL,
	  `duty_3min_uid` int(11) DEFAULT NULL,
	  `duty_letters1_uid` int(11) DEFAULT NULL,
	  `duty_letters2_uid` int(11) DEFAULT NULL,
	  `duty_meeting_responsible_uid` int(11) DEFAULT NULL,
	  `duty_ext1_text` varchar(32) DEFAULT '',
	  `duty_ext1_uid` int(11) DEFAULT NULL,
	  `duty_ext2_text` varchar(32) DEFAULT '',
	  `duty_ext2_uid` int(11) DEFAULT NULL,
	  `duty_ext3_text` varchar(32) DEFAULT '',
	  `duty_ext3_uid` int(11) DEFAULT NULL,
	  `duty_ext4_text` varchar(32) DEFAULT '',
	  `duty_ext4_uid` int(11) DEFAULT NULL,
	  `duty_ext5_text` varchar(32) DEFAULT '',
	  `duty_ext5_uid` int(11) DEFAULT NULL,
	  `minutes` blob,
	  `minutes_3min` blob,
	  `minutes_letters` blob,
	  `minutes_date` date DEFAULT NULL,
	  `minutes_number_of_participants` int(11) DEFAULT NULL,
	  `minutes_number_of_rejections` int(11) DEFAULT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	CREATE TABLE IF NOT EXISTS `meeting_attendance` (
	  `maid` int(11) NOT NULL,
	  `mid` int(11) DEFAULT NULL,
	  `uid` int(11) DEFAULT NULL,
	  `accepted` tinyint(1) DEFAULT '1',
	  `comment` text,
	  `response_date` datetime DEFAULT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	CREATE TABLE IF NOT EXISTS `meeting_file` (
	  `mfid` int(11) NOT NULL,
	  `filename` varchar(255) DEFAULT NULL,
	  `filepath` varchar(255) DEFAULT NULL,
	  `mid` int(11) DEFAULT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	CREATE TABLE IF NOT EXISTS `meeting_image` (
	  `miid` int(10) unsigned NOT NULL,
	  `mid` int(10) unsigned DEFAULT NULL,
	  `filename` varchar(255) DEFAULT NULL,
	  `filepath` varchar(255) DEFAULT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	CREATE TABLE IF NOT EXISTS `meeting_letters` (
	  `collid` varchar(128) DEFAULT NULL,
	  `letter_mid` int(11) DEFAULT NULL,
	  `cid` int(11) DEFAULT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	CREATE TABLE IF NOT EXISTS `meeting_link` (
	  `mlid` int(11) NOT NULL,
	  `mid` int(11) NOT NULL,
	  `media_source` varchar(8) NOT NULL,
	  `media_link` text NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	CREATE TABLE IF NOT EXISTS `meeting_rating` (
	  `mid` int(11) DEFAULT NULL,
	  `uid` int(11) DEFAULT NULL,
	  `rating` int(11) DEFAULT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	CREATE TABLE IF NOT EXISTS `news` (
	  `nid` int(11) NOT NULL,
	  `did` int(11) DEFAULT NULL,
	  `posted` datetime DEFAULT NULL,
	  `title` varchar(255) DEFAULT NULL,
	  `content` text
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	CREATE TABLE IF NOT EXISTS `news_comment` (
	  `ncid` int(11) NOT NULL,
	  `nid` int(11) DEFAULT NULL,
	  `posted` datetime DEFAULT NULL,
	  `content` text,
	  `uid` int(11) DEFAULT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	CREATE TABLE IF NOT EXISTS `nomination` (
	  `nid` int(10) unsigned NOT NULL,
	  `uid` int(11) DEFAULT NULL,
	  `rid` int(11) DEFAULT NULL,
	  `date_start` date DEFAULT NULL,
	  `date_end` date DEFAULT NULL,
	  `nomination_date` date DEFAULT NULL,
	  `nominator_uid` int(11) DEFAULT NULL,
	  `nominator_comment` text,
	  `approved` tinyint(2) DEFAULT '0'
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	CREATE TABLE IF NOT EXISTS `other_meeting` (
	  `title` text,
	  `description` text,
	  `location` text,
	  `cid` int(11) DEFAULT NULL,
	  `start_time` datetime DEFAULT NULL,
	  `end_time` datetime DEFAULT NULL,
	  `omid` int(11) NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	CREATE TABLE IF NOT EXISTS `role` (
	  `riid` int(11) NOT NULL,
	  `uid` int(10) unsigned DEFAULT NULL,
	  `rid` int(11) DEFAULT NULL,
	  `start_date` date DEFAULT NULL,
	  `end_date` date DEFAULT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	CREATE TABLE IF NOT EXISTS `role_definition` (
	  `rid` int(10) unsigned NOT NULL,
	  `shortname` varchar(16) DEFAULT NULL,
	  `description` varchar(255) DEFAULT NULL,
	  `weight` tinyint(4) DEFAULT '0'
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	CREATE TABLE IF NOT EXISTS `search` (
	  `count` int(11) DEFAULT '0',
	  `q` varchar(128) NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	CREATE TABLE IF NOT EXISTS `sms_account` (
	  `cid` int(11) DEFAULT NULL,
	  `balance` int(11) DEFAULT '0'
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	CREATE TABLE IF NOT EXISTS `sms_history` (
	  `smsid` int(11) NOT NULL,
	  `sender_uid` int(11) DEFAULT NULL,
	  `receiver_cid` int(11) DEFAULT NULL,
	  `message` varchar(255) DEFAULT NULL,
	  `ts` datetime DEFAULT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	CREATE TABLE IF NOT EXISTS `tabler_service` (
	  `tsid` int(11) NOT NULL,
	  `headline` varchar(255) DEFAULT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	CREATE TABLE IF NOT EXISTS `tabler_service_item` (
	  `tid` int(11) NOT NULL,
	  `tsid` int(11) DEFAULT NULL,
	  `headline` varchar(128) DEFAULT NULL,
	  `description` text,
	  `location` varchar(255) DEFAULT NULL,
	  `price` varchar(32) DEFAULT NULL,
	  `duration` varchar(32) DEFAULT NULL,
	  `contact` text,
	  `posted` datetime DEFAULT NULL,
	  `uid` int(11) DEFAULT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	CREATE TABLE IF NOT EXISTS `terms` (
	  `version` int(11) NOT NULL,
	  `ts` datetime DEFAULT NULL,
	  `data` blob
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	CREATE TABLE IF NOT EXISTS `tracker` (
	  `current` varchar(255) DEFAULT NULL,
	  `counter` int(11) DEFAULT '1',
	  `previous` varchar(255) NOT NULL,
	  `title` varchar(255) DEFAULT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	CREATE TABLE IF NOT EXISTS `user` (
	  `uid` int(10) unsigned NOT NULL,
	  `cid` int(11) DEFAULT NULL,
	  `password` varchar(255) NOT NULL,
	  `username` varchar(64) DEFAULT NULL,
	  `profile_firstname` varchar(64) DEFAULT '',
	  `profile_lastname` varchar(64) DEFAULT '',
	  `profile_birthdate` date DEFAULT NULL,
	  `profile_started` date DEFAULT NULL,
	  `profile_ended` date DEFAULT NULL,
	  `private_profile` blob,
	  `private_address` varchar(128) DEFAULT '',
	  `private_houseno` varchar(16) DEFAULT '',
	  `private_houseletter` varchar(16) DEFAULT '',
	  `private_housefloor` varchar(16) DEFAULT '',
	  `private_houseplacement` varchar(16) DEFAULT '',
	  `private_zipno` varchar(8) DEFAULT '',
	  `private_city` varchar(64) DEFAULT '',
	  `private_country` varchar(64) DEFAULT '',
	  `private_phone` varchar(32) DEFAULT '',
	  `private_mobile` varchar(16) DEFAULT '',
	  `private_email` varchar(64) DEFAULT NULL,
	  `private_skype` varchar(32) DEFAULT '',
	  `private_msn` varchar(32) DEFAULT '',
	  `company_profile` blob,
	  `company_name` varchar(64) DEFAULT '',
	  `company_position` varchar(32) DEFAULT '',
	  `company_business` varchar(64) DEFAULT '',
	  `company_address` varchar(64) DEFAULT '',
	  `company_zipno` varchar(8) DEFAULT '',
	  `company_city` varchar(64) DEFAULT '',
	  `company_country` varchar(64) DEFAULT '',
	  `company_phone` varchar(32) DEFAULT '',
	  `company_email` varchar(32) DEFAULT '',
	  `company_web` varchar(128) DEFAULT '',
	  `profile_image` varchar(255) DEFAULT NULL,
	  `last_page_view` datetime DEFAULT NULL,
	  `xtable_transfer` int(11) NOT NULL DEFAULT '1',
	  `view_tracker` tinyint(1) DEFAULT '1',
	  `last_page_title` tinytext,
	  `last_page_url` tinytext
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	CREATE TABLE IF NOT EXISTS `user_path_tracker` (
	  `uid` int(11) DEFAULT NULL,
	  `uri` tinytext,
	  `ts` datetime DEFAULT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	CREATE TABLE IF NOT EXISTS `user_view_tracker` (
	  `uid` int(11) DEFAULT NULL,
	  `viewer_uid` int(11) DEFAULT NULL,
	  `ts` datetime DEFAULT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;


	ALTER TABLE `article`
	  ADD PRIMARY KEY (`aid`);

	ALTER TABLE `article_file`
	  ADD PRIMARY KEY (`afid`);

	ALTER TABLE `banner`
	  ADD PRIMARY KEY (`bid`);

	ALTER TABLE `club`
	  ADD PRIMARY KEY (`cid`);

	ALTER TABLE `cronjob`
	  ADD PRIMARY KEY (`id`);

	ALTER TABLE `district`
	  ADD PRIMARY KEY (`did`);

	ALTER TABLE `geolocation`
	  ADD PRIMARY KEY (`gid`);

	ALTER TABLE `log`
	  ADD PRIMARY KEY (`lid`);

	ALTER TABLE `mass_mail`
	  ADD PRIMARY KEY (`id`);

	ALTER TABLE `mass_mail_attachment`
	  ADD PRIMARY KEY (`aid`);

	ALTER TABLE `meeting`
	  ADD PRIMARY KEY (`mid`);

	ALTER TABLE `meeting_attendance`
	  ADD PRIMARY KEY (`maid`);

	ALTER TABLE `meeting_file`
	  ADD PRIMARY KEY (`mfid`);

	ALTER TABLE `meeting_image`
	  ADD PRIMARY KEY (`miid`);

	ALTER TABLE `meeting_link`
	  ADD PRIMARY KEY (`mlid`);

	ALTER TABLE `news`
	  ADD PRIMARY KEY (`nid`);

	ALTER TABLE `news_comment`
	  ADD PRIMARY KEY (`ncid`);

	ALTER TABLE `nomination`
	  ADD PRIMARY KEY (`nid`);

	ALTER TABLE `other_meeting`
	  ADD PRIMARY KEY (`omid`);

	ALTER TABLE `role`
	  ADD PRIMARY KEY (`riid`),
	  ADD KEY `uid` (`uid`),
	  ADD KEY `rid` (`rid`);

	ALTER TABLE `role_definition`
	  ADD PRIMARY KEY (`rid`);

	ALTER TABLE `search`
	  ADD PRIMARY KEY (`q`);

	ALTER TABLE `sms_history`
	  ADD PRIMARY KEY (`smsid`);

	ALTER TABLE `tabler_service`
	  ADD PRIMARY KEY (`tsid`);

	ALTER TABLE `tabler_service_item`
	  ADD PRIMARY KEY (`tid`);

	ALTER TABLE `terms`
	  ADD PRIMARY KEY (`version`);

	ALTER TABLE `tracker`
	  ADD PRIMARY KEY (`previous`);

	ALTER TABLE `user`
	  ADD PRIMARY KEY (`uid`);


	ALTER TABLE `article`
	  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT;
	ALTER TABLE `article_file`
	  MODIFY `afid` int(11) NOT NULL AUTO_INCREMENT;
	ALTER TABLE `banner`
	  MODIFY `bid` int(11) NOT NULL AUTO_INCREMENT;
	ALTER TABLE `club`
	  MODIFY `cid` int(10) unsigned NOT NULL AUTO_INCREMENT;
	ALTER TABLE `cronjob`
	  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
	ALTER TABLE `district`
	  MODIFY `did` int(10) unsigned NOT NULL AUTO_INCREMENT;
	ALTER TABLE `geolocation`
	  MODIFY `gid` int(11) NOT NULL AUTO_INCREMENT;
	ALTER TABLE `log`
	  MODIFY `lid` int(11) NOT NULL AUTO_INCREMENT;
	ALTER TABLE `mass_mail`
	  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
	ALTER TABLE `mass_mail_attachment`
	  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT;
	ALTER TABLE `meeting`
	  MODIFY `mid` int(10) unsigned NOT NULL AUTO_INCREMENT;
	ALTER TABLE `meeting_attendance`
	  MODIFY `maid` int(11) NOT NULL AUTO_INCREMENT;
	ALTER TABLE `meeting_file`
	  MODIFY `mfid` int(11) NOT NULL AUTO_INCREMENT;
	ALTER TABLE `meeting_image`
	  MODIFY `miid` int(10) unsigned NOT NULL AUTO_INCREMENT;
	ALTER TABLE `meeting_link`
	  MODIFY `mlid` int(11) NOT NULL AUTO_INCREMENT;
	ALTER TABLE `news`
	  MODIFY `nid` int(11) NOT NULL AUTO_INCREMENT;
	ALTER TABLE `news_comment`
	  MODIFY `ncid` int(11) NOT NULL AUTO_INCREMENT;
	ALTER TABLE `nomination`
	  MODIFY `nid` int(10) unsigned NOT NULL AUTO_INCREMENT;
	ALTER TABLE `other_meeting`
	  MODIFY `omid` int(11) NOT NULL AUTO_INCREMENT;
	ALTER TABLE `role`
	  MODIFY `riid` int(11) NOT NULL AUTO_INCREMENT;
	ALTER TABLE `role_definition`
	  MODIFY `rid` int(10) unsigned NOT NULL AUTO_INCREMENT;
	ALTER TABLE `sms_history`
	  MODIFY `smsid` int(11) NOT NULL AUTO_INCREMENT;
	ALTER TABLE `tabler_service`
	  MODIFY `tsid` int(11) NOT NULL AUTO_INCREMENT;
	ALTER TABLE `tabler_service_item`
	  MODIFY `tid` int(11) NOT NULL AUTO_INCREMENT;
	ALTER TABLE `terms`
	  MODIFY `version` int(11) NOT NULL AUTO_INCREMENT;
	ALTER TABLE `user`
	  MODIFY `uid` int(10) unsigned NOT NULL AUTO_INCREMENT;
	  ";
	mysql_connect($dbhost, $dbuser, $dbpassword) or die("Error connecting to database");
	mysql_select_db($dbname) or die("Error selecting database {$dbname}");
	mysql_query($database_sql) or die('Invalid query: ' . mysql_error());
}

if (!isset($_REQUEST['step']))
{
	echo "
		<h1>Welcome to the installer for RT Websystem</h1>
		<p>First step is to prepare the database and the table structure. Please enter the details below to contunie.</p>
		<form action=install.php method=post>
			<input type=hidden name=step value=createdb>
			
			<label for=dbname>Database name</label>
			<input type=text name=dbname placeholder='rtwebsystem' id=dbname>

			<label for=dbhost>Database host</label>
			<input type=text name=dbhost placeholder='localhost' id=dbhost>
			
			<label for=dbuser>Database user</label>
			<input type=text name=dbuser placeholder='rtwebuser' id=dbuser>

			<label for=dbpassword>Database password</label>
			<input type=text name=dbpassword placeholder='asdJSADJ2231!' id=dbpassword>
			
			<input type=submit value='Create database tables'>
		</form>
	";
}
else if ($_REQUEST['step']=='createdb')
{
	echo "<h1>RT Websystem - creating database and table structure</h1>";
	build_database($_REQUEST['dbname'], $_REQUEST['dbhost'], $_REQUEST['dbuser'], $_REQUEST['dbpassword']);
	echo "<p>Completed with out errors</p>";
}

?>