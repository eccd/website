<?php
/**
 * Helper class for Joes Word Cloud module
 *
 * @package    Joes Joomla
 * @subpackage Modules
 * @link www.joellipman.com
 * @license        GNU GPL v3
 * Displays a cluster of the words from your Joomla! articles (core content not meta data... less manual setup).
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class modJoesQuicklistWeblinksHelper
{

	/**
     * Displays a module
     *
     * @param array $params An object containing the module parameters
     * @access public
     */
    function getModuleContent( $params )
    {

		# declare
		global $mainframe;
		$jqw = new stdClass();  # for variables we will be carrying across to the template
		$jqw_urllist=$jqw_imagelist=$more_debug_info_1=$save_to_path=""; # version 1.3
		$count_processed_thumbs=0;

		# get parameters
		$jqw->moduleclasssfx	= (trim($params->get('moduleclass_sfx'))!="") ? ' class="'.$params->get('moduleclass_sfx').'"' : ''; # version 1.1
		$jqw->forcenounderline = (($params->get('JQW_FORCENOUNDERLINES')*1)==1) ? ' style="text-decoration:none"' : ''; # version 1.3
		$jqw->imgborderwidth = ($params->get('JQW_IMGBORDERWIDTH')*1); # version 1.4.3
		$jqw->imgbordercolor = trim($params->get('JQW_IMGBORDERCOLOR')); # version 1.4.3
		$jqw_imgbordercolorhover = trim($params->get('JQW_IMGBORDERCOLORHOVER')); # version 1.4.3
		$jqw_imgborderradius = ($params->get('JQW_IMGROUNDEDCORNERRADIUS')*1); # version 1.4.3
		$jqw->imgroundedcorners=($jqw_imgborderradius>0)?true:false;
		$jqw->linkcount = $params->get('JQW_LINKCOUNT')*1; # version 1.1
		$jqw->desccount = $params->get('JQW_LINKDESCCOUNT')*1; # version 1.3
		$jqw->previewcount = $params->get('JQW_PREVIEWIMAGECOUNT')*1; # version 1.3
		$jqw_orderby_array=array("w.hits", "w.created", "w.modified", "w.title", "w.url", "w.random", "w.id");
		$jqw_orderby = $jqw_orderby_array[($params->get('JQW_LINKORDERBY')*1)]; # version 1.1
		$jqw_orderaz = (($params->get('JQW_LINKORDERAZ')*1)==0)?"ASC":"DESC"; # version 1.1
		$jqw_opener_array = array("_blank", "_parent", "rokbox"); # version 1.1
		$jqw_opener = $jqw_opener_array[($params->get('JQW_LINKOPENER')*1)]; # version 1.1
		$jqw->opener_str=($jqw_opener=="rokbox")?' rel="rokbox[90% 90%]"':' target="'.$jqw_opener.'"'; # version 1.4.2
		$jqw_category = $params->get('JQW_LINKCATEGORYID')*1; # version 1.3
		$jqw_linkdispglobal_array = array("no", "yes"); # version 1.4.3
		$jqw->linkdispdesc = $params->get('JQW_LINKDISPLAYDESC')*1; # version 1.4.3
		$jqw->linkdispimgs = $params->get('JQW_LINKDISPLAYIMGS')*1; # version 1.4.3
		$jqw->linkdispdate = $params->get('JQW_LINKDISPLAYDATE')*1; # version 1.4.3
		$jqw->linkdisphits = $params->get('JQW_LINKDISPLAYHITS')*1; # version 1.4.3
		$jqw->linkdisprank = ($params->get('JQW_LINKDISPLAYRANKID')*1); # version 2.1.1
		$jqw_morelinks = (($params->get('JQW_DISPLAYMORELINKS')*1)==1) ? true : false; # version 1.4.2
		$jqw_dateformat = trim($params->get('JQW_LINKDATEFORMAT')); # version 1.1

		$jqw->hitsprefix = htmlentities($params->get('JQW_LINKHITTEXT')); # version 1.1
		$jqw->dateprefix = htmlentities($params->get('JQW_LINKDATETEXT')); # version 1.1
		$jqw_morelinkstxt = htmlentities($params->get('JQW_LINKMORELINKSTEXT')); # version 1.1

		$jqw->desclength = ($params->get('JQW_LINKDESCLENGTH')*1); # version 1.4.3
		$jqw->titlelength = ($params->get('JQW_LINKTITLELENGTH')*1); # version 1.4.3
		$jqw_thumbnailservice_key= trim($params->get('JQW_THUMBNAILKEY')); # version 2.2
		$jqw_thumbservice_stopped = (($params->get('JQW_THUMBNAILSERVICESTOP')*1)==1) ? true : false; # version 1.4.1
		$jqw_thumbservice_array=array(); # version 1.4.3
		$jqw_thumbservice_array[]="http://wimg.ca/"; # version 1.4.3
		$jqw_thumbservice_array[]="http://img.bitpixels.com/getthumbnail?code=".$jqw_thumbnailservice_key."&url="; # version 2.2
		$jqw_thumbservice_array[]="http://open.thumbshots.org/image.pxf?url="; # version 1.4.3
		$jqw_thumbservice_array[]="http://www.shrinktheweb.com/xino.php?embed=1&STWAccessKeyId=".$jqw_thumbnailservice_key."&stwsize=sm&stwUrl="; # version 2.2
		$jqw_thumbservice_array[]="http://api.thumbalizr.com/?width=1280&api_key=".$jqw_thumbnailservice_key."&url="; # version 2.2
		$jqw_thumbservice_array[]="http://free.pagepeeker.com/v2/thumbs.php?size=x&url="; # version 2.2
		$jqw_thumbservice = $jqw_thumbservice_array[($params->get('JQW_THUMBNAILSERVICE')*1)]; # version 1.4.3
		$jqw_thumbgroup_gid = $params->get('JQW_THUMBNAILGROUPGENERATORS')*1; # version 1.5.0
		$jqw_thumbgroup_array = $params->get('JQW_THUMBNAILGROUPGENERATORS'); # version 1.4.3
		if (count($jqw_thumbgroup_array)<1) { $jqw_thumbgroup_array=array(900); } # version 1.5.3 - to catch bug of no groups selected - default super users
		$jqw_imagefolder = trim($params->get('JQW_PREVIEWIMAGESFOLDER')); # version 1.3
		$jqw->previewwidth = $params->get('JQW_PREVIEWIMAGEWIDTH')*1; # version 1.3
		$jqw->previewheight = $params->get('JQW_PREVIEWIMAGEHEIGHT')*1; # version 1.3
		$jqw_imagetype_array=array("bmp", "gif", "jpg", "png", "tif");
		$jqw_imagetype = $jqw_imagetype_array[($params->get('JQW_PREVIEWIMAGETYPES')*1)]; # version 1.1
		$jqw_debugmode = (($params->get('JQW_DEBUGMODE')*1)==1) ? true: false; # version 1.3
		$jqw->poweredby = (($params->get('JQW_POWEREDBY')*1)==1) ? true: false; # version 1.3
		$jqw_imageeffect = $params->get('JQW_IMGSEMITRANSPARENTHOVER')*1; # version 1.4.3
		$jqw_customorder = trim($params->get('JQW_LINKCUSTOMORDER')); # version 1.5.4
		$jqw_customorder	= (trim($jqw_customorder)!="") ? explode( ",", $jqw_customorder ) : array(); # version 1.5
		for($i=0; $i<count($jqw_customorder); $i++) { $jqw_customorder[$i] = trim($jqw_customorder[$i])*1; } # version 1.6.5
		$jqw->prefixhittxt = trim($params->get('JQW_LINKHITTEXT')); # version 1.5.3
		$jqw->prefixdatetxt = trim($params->get('JQW_LINKDATETEXT')); # version 1.5.3
		$jqw->descfontsize = ($params->get('JQW_LINKDESCSIZE')*1); # version 1.5.3
		$jqw_useaccesslevels = (($params->get('JQW_USEACCESSLEVELS')*1)==1) ? true : false; # version 2.3

		# other validations
		if ($jqw->previewwidth<=0) $jqw->previewwidth=128;
		if ($jqw->previewheight<=0) $jqw->previewheight=96;


		# rounded corners CSS3 style
		$jqw->inlinestylecode='<style>
.jqw_thumb_preview {
width: '.$jqw->previewwidth.'px;
height: '.$jqw->previewheight.'px;
border: '.$jqw->imgborderwidth.'px solid '.$jqw->imgbordercolor.';';
		if ($jqw_imageeffect<1) {
		$jqw->inlinestylecode.='opacity: '.$jqw_imageeffect.';';
		}
		if ($jqw->imgroundedcorners) {
			$jqw->inlinestylecode.='border-radius: '.$jqw_imgborderradius.'px;
-moz-border-radius: '.$jqw_imgborderradius.'px;
-khtml-border-radius: '.$jqw_imgborderradius.'px;
-webkit-border-radius: '.$jqw_imgborderradius.'px;
overflow:visible;
			';
		}
		$jqw->inlinestylecode.='
}
.jqw_thumb_preview:hover {
border: '.$jqw->imgborderwidth.'px solid '.$jqw_imgbordercolorhover.';
opacity: 1;
}
		';

		$jqw->inlinestylecode.='
		</style>';

		# connect to the database
		$db =& JFactory::getDBO();
		$user =& JFactory::getUser();
		$userGroups = $user->get('groups');
		$subrowcount=$usergrpref=0;
		$sql_accessconditions="";


		# modify sql query if using access levels
		if ($jqw_useaccesslevels) {

			# generate accesslevel array
			$accesslevels=array();
			$accesslevels[]=1;
			while(list($key, $value) = each($userGroups)) {
				$thislevel = $value;

				$db2 =& JFactory::getDBO();
				$db2->setQuery( "SELECT id, rules FROM `#__viewlevels` WHERE rules LIKE '%".$value."%'" );
				$rows2 = $db2->loadAssocList();

				for($j=0;$j<count($rows2);$j++) {
					$rule_id=$rows2[$j]['id'];
					$rules_array=explode(",", substr($rows2[$j]['rules'], 1, -1));
					if (in_array($rule_id, $rules_array))
						$accesslevels[] = $rows2[$j]['id'];
				}
				$subrowcount=count($rows2);
				$usergrpref++;
			}
			$sql_accessconditions = " AND w.`access` IN (" . implode(",", $accesslevels) . ")";
		}


		# modify sql query if changing order
		$jqw_orderby = ($jqw_orderby=="w.random") ? " ORDER BY RAND()" : " ORDER BY ".$jqw_orderby." ".$jqw_orderaz; # version 1.4.3
		$jqw_orderby = (count($jqw_customorder)>0) ? " AND w.id IN (".implode(", ", $jqw_customorder).") ORDER BY FIELD(w.id, ".implode(", ", $jqw_customorder)."), id" : $jqw_orderby; # version 1.5.4


		# modify sql query if specifying category
		$item_category_str=$sql_categoryconditions="";
		if ($jqw_category>0) {
			$jqw_category*=1;
			$item_category_str="&amp;catid=".$jqw_category;
			$jqw_sql='
SELECT DISTINCT
	w.id, w.title, w.url, w.description, w.created, w.modified, w.hits, w.access
FROM
	#__weblinks w
INNER JOIN #__categories j ON j.id=w.catid
LEFT OUTER JOIN #__categories k ON k.id=j.parent_id
WHERE w.state=1
AND (
	w.catid='.$jqw_category.'
	OR
	j.parent_id='.$jqw_category.'
	OR
	k.parent_id='.$jqw_category.'
)'.$sql_accessconditions.$jqw_orderby;

		} else {
			$jqw_sql = '
SELECT
	w.id, w.title, w.url, w.description, w.created, w.modified, w.hits
FROM
	#__weblinks w
WHERE
	w.state=1'.$sql_accessconditions.$jqw_orderby;
		}




		# execute the SQL query
		$db->setQuery( $jqw_sql, 0, $jqw->linkcount );
		$rows = $db->loadAssocList();
		$jqw->weblinkentries = new stdClass(); // v2.4 SimonB

		# populate weblinks entries
		for ($i=0; $i<count($rows); $i++) {

			$this_index=$i+1;
			$this_link_id=$rows[$i]['id']*1;
			$this_link_title=trim($rows[$i]['title']);
			$this_link_url=trim($rows[$i]['url']);
			$this_link_desc=strip_tags(trim($rows[$i]['description']));
			$this_link_date=$rows[$i]['created'];
			$this_link_hits=$rows[$i]['hits']*1;
			$this_link_access=trim($rows[$i]['access']);   // v2.3 Eric G.

			# get the website thumbnail previews
			$this_link_noimg_path='images/'.$jqw_imagefolder.'/no_thumbnail_yet.'.$jqw_imagetype;
			$new_img_path='images/'.$jqw_imagefolder.'/'.$this_link_id.'.'.$jqw_imagetype;
			if (in_array($jqw_thumbgroup_gid, $userGroups)) {
				if (!$jqw_thumbservice_stopped) {
					$ch = curl_init($jqw_thumbservice.$rows[$i]['url']);
					$fp = fopen($new_img_path, 'wb');
					curl_setopt($ch, CURLOPT_FILE, $fp);
					curl_setopt($ch, CURLOPT_HEADER, 0);
					curl_exec($ch);
					curl_close($ch);
					fclose($fp);
					$count_processed_thumbs++;
				}
			}
			$this_link_img_path=(file_exists($new_img_path))?$new_img_path:$this_link_noimg_path;

			$jqw->weblinkentries->$i = new stdClass(); // v2.4 SimonB
			$jqw->weblinkentries->$i->linkid=$this_link_id;
			$jqw->weblinkentries->$i->linktitle=$this_link_title;
			$jqw->weblinkentries->$i->linkhits=$this_link_hits;
			$jqw->weblinkentries->$i->linkdesc=$this_link_desc;
			$jqw->weblinkentries->$i->linkimgs=$this_link_img_path;
			$jqw->weblinkentries->$i->linkdate=date($jqw_dateformat, strtotime($this_link_date));
			$jqw->weblinkentries->$i->linkaccess=$this_link_access;   // v2.3 Eric G.


			# for testing
			$jqw_urllist.= ($jqw_debugmode) ? $rows[$i]['url']."|".$rows[$i]['id']."\n" : "";
			$jqw_imagelist.= ($jqw_debugmode) ? JURI::base().'images'.$jqw_imagefolder.'/'.$rows[$i]['id'].".".$jqw_imagetype."\n" : "";
		}



		$jqw->morelinks="";
		if ($jqw_morelinks) {
			$jqw_thisstyle = (($params->get('JQW_FORCENOUNDERLINES')*1)==1) ? ' style="text-decoration:none;float:right"' : ''; # version 1.3
			$jqw->morelinks.=($jqw_morelinks)?'<a'.$jqw_thisstyle.' style="float:right;" href="'.JURI::base().'index.php?option=com_weblinks':'';
			$jqw->morelinks.=($jqw_category>0)?'&view=category&id='.$jqw_category:'';
			$jqw->morelinks.=($jqw_morelinks)?'">'.$jqw_morelinkstxt.' &#187;</a>':'';
		}

		$more_debug_info_1=(trim($more_debug_info_1)=="")?"Generated ".$count_processed_thumbs." of ".count($rows)." thumbnails:<br />Last: ".$save_to_path:$more_debug_info_1;

		# further module options
		$jqw->debug = ($jqw_debugmode) ? "<p><b>SQL Query:</b><br />".$jqw_sql."</p><br /><b>JWT List:</b><pre>".$jqw_urllist."\n\n// Module Parameters\n".var_export($params, true)."\n"."</pre><br /><p><b>Thumbnail Process:</b><br />".$more_debug_info_1."</p><br />" : "";

		return $jqw;
    }
}
?>
