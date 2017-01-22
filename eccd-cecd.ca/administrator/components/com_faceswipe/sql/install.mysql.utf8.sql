CREATE TABLE IF NOT EXISTS `#__faceswipe_albums` (
  `album_id` int(10) unsigned NOT NULL auto_increment,
  `style_id` int(10) NOT NULL,
  `album_name` varchar(100) NOT NULL default '',
  `published` tinyint(1) NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `album_comment` tinyint(1) NOT NULL default '0',
  `album_fullscreen_layout` varchar(15) NOT NULL,
  PRIMARY KEY  (`album_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__faceswipe_images` (
  `image_id` int(11) unsigned NOT NULL auto_increment,
  `image_fb_id` bigint(18) NOT NULL,
  `image_title` varchar(255) default '',
  `image_description` text,
  `image_link` varchar(255) default '',
  `image_thumbs` varchar(255) default '',
  `image_source` varchar(255) default '',
  `album_id` int(11) NOT NULL default '0',
  `image_data` text,
  `image_fb_album_id` bigint(18) NOT NULL,
  PRIMARY KEY  (`image_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__faceswipe_styles` (
  `style_id` int(11) unsigned NOT NULL auto_increment,
  `style_name` char(30) NOT NULL,
  `style_showcase` char(30) NOT NULL default '.Kenburns',
  `style_transition` char(30) NOT NULL default 'sine:in:out',
  `style_duration` char(30) NOT NULL default '2000',
  `style_height` char(30) NOT NULL default '450px',
  `style_width` char(30) NOT NULL default '300px',
  `style_thumbnail` tinyint(1) NOT NULL default '1',
  `style_thumbnail_image_width` char(30) NOT NULL default '50px',
  `style_thumbnail_image_height` char(30) NOT NULL default '50px',
  `style_caption` tinyint(1) NOT NULL default '1',
  `style_random` tinyint(1) NOT NULL default '0',
  `style_paused` tinyint(1) NOT NULL default '0',
  `style_title` tinyint(1) NOT NULL default '1',
  `style_loop` tinyint(1) NOT NULL default '1',
  `style_controller` tinyint(1) NOT NULL default '1',
  `style_zoom` char(30) NOT NULL default '50',
  `style_pan` char(30) NOT NULL default '25',
  PRIMARY KEY  (`style_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
