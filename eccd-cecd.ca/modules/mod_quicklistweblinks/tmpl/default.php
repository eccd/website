<?php
/**
* Joes Quicklist Weblinks
* @package	mod_quicklistweblinks
* @author	joel lipman
* @link		http://www.joellipman.com
* @license	GNU/GPL v3
* @modified 03/07/2011
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$document =& JFactory::getDocument();
$document->addCustomTag($jqw_params->inlinestylecode);
?>
<div id="joesquicklistweblinks"<?php echo $jqw_params->moduleclasssfx; ?>>
	<?php
		for ($i=0; $i<$jqw_params->linkcount; $i++) {

			# get values
			$this_id	=$jqw_params->weblinkentries->$i->linkid;
			$this_title	=$jqw_params->weblinkentries->$i->linktitle;
			$this_hits	=$jqw_params->weblinkentries->$i->linkhits;
			$this_desc	=$jqw_params->weblinkentries->$i->linkdesc;
			$this_img_path	=$jqw_params->weblinkentries->$i->linkimgs;
			$this_date	=$jqw_params->weblinkentries->$i->linkdate;

			# different widths for inline or popup images
			$this_img_str_inline= '<img src="'.JURI::base().$this_img_path.'" style="float:left;width:'.$jqw_params->previewwidth.'px;height:'.$jqw_params->previewheight.'px;margin-right:5px;border:'.$jqw_params->imgborderwidth.'px solid '.$jqw_params->imgbordercolor.';" alt="'.$this_title.'" />'."\n";

			# add text to values
			$this_link_ellipsis=(strlen($this_desc)>$jqw_params->desclength)?'&#133;':'';
			$this_desc_inline = '<span style="font-size:'.$jqw_params->descfontsize.'%;display:block;">'.substr($this_desc, 0, $jqw_params->desclength).$this_link_ellipsis.'</span>';
			$this_link_ellipsis=(strlen($this_title)>$jqw_params->titlelength)?'&#133;':'';
			$this_title_inline =substr($this_title, 0, $jqw_params->titlelength).$this_link_ellipsis;

			# draw the inline image cell - uses div for rounded corners with borders
			echo '<div style="margin-left:5px;margin-bottom:10px;margin-right:10px;float:left;width:'.($jqw_params->previewwidth+4).'px;">';
			if (($i<$jqw_params->previewcount)&&($jqw_params->linkdispimgs==1)) {
				echo '<a class="jqw_thumbnail" href="'.JURI::base().'index.php?task=weblink.go&amp;id='.$this_id.'&amp;option=com_weblinks"'.$jqw_params->opener_str." style=\"text-decoration:none;\">\n";
				if ($jqw_params->imgroundedcorners) {
					echo '<div class="jqw_thumb_preview" style="background: url(\''.JURI::base().$this_img_path.'\');" />&nbsp;</div>';
				} else {
					echo $this_img_str_inline;
				}
				echo '</a>';
			}
			echo '</div>';

			# write main column with users options and mouseover
			echo '<div>';
			echo '<a class="jqw_thumbnail" href="'.JURI::base().'index.php?task=weblink.go&amp;id='.$this_id.'&amp;option=com_weblinks"'.$jqw_params->opener_str.$jqw_params->forcenounderline.'>';
			if ($jqw_params->linkdisprank == 1) {
				echo ($i+1).'. ';
			} else if ($jqw_params->linkdisprank == 2) {
				echo $this_id.'. ';
			}
			echo $this_title_inline.'</a><br />';
			echo ($jqw_params->linkdispdesc==1)?$this_desc_inline:'';
			echo '</div>';

			# write remaining columns (date and hits)
			echo ($jqw_params->linkdispdate==1)?'<div class="jqw_date_inline">'.$jqw_params->dateprefix.$this_date.'</div>':'';
			echo ($jqw_params->linkdisphits==1)?'<div class="jqw_hits_inline">'.$jqw_params->hitsprefix.$this_hits.'</div>':'';
			echo '<div style="clear:both"></div>';
		}

		echo $jqw_params->morelinks;
		if ($jqw_params->poweredby) echo ' <a href="http://www.joellipman.com/" target="_blank" style="font-size:8px;text-decoration:none">JoelLipman.Com</a>';
		if (trim($jqw_params->debug)!="") echo $jqw_params->debug;
		echo '<div style="clear:both"></div>';

	?>
</div>
