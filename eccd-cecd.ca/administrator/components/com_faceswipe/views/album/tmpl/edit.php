<?php
/**
 * @version		$Id: edit.php 43 2011-12-21 18:38:05Z trung $
 * @copyright	JoomAvatar.com
 * @author		Nguyen Quang Trung
 * @link		http://joomavatar.com
 * @license		License GNU General Public License version 2 or later
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Include the HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'album.cancel' || document.formvalidator.isValid(document.id('album-form'))) {
			Joomla.submitform(task, document.getElementById('album-form'));
		} else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>

<link type="text/css" href="components/com_faceswipe/assets/css/faceswipe.css" rel="stylesheet">
<script type="text/javascript" src="components/com_faceswipe/assets/js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="components/com_faceswipe/assets/js/faceswipe.js"></script>

<div id="fb-root"></div>
<script src="http://connect.facebook.net/en_US/all.js"></script>
<script>
//call facebook api
FaceSwipe.fbconnect({appID: <?php echo comFaceswipeClassesFacebook::getAPIKey(); ?>});

FaceSwipe.showAccountInfo();

</script>
<form action="<?php echo JRoute::_('index.php?option=com_faceswipe&album_id='.(int) $this->item->album_id); ?>" method="post" name="adminForm" id="album-form" class="form-validate">
	
	<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend><?php echo empty($this->item->album_id) ? JText::_('COM_FACESWIPE_NEW_ALBUM') : JText::sprintf('COM_FACESWIPE_EDIT_ALBUM', $this->item->album_id); ?></legend>
			<ul class="adminformlist">
			<li><?php echo $this->form->getLabel('album_name'); ?>
			<?php echo $this->form->getInput('album_name'); ?></li>

			<li><?php echo $this->form->getLabel('published'); ?>
			<?php echo $this->form->getInput('published'); ?></li>

			<li><?php echo $this->form->getLabel('access'); ?>
			<?php echo $this->form->getInput('access'); ?></li>

			<li><?php echo $this->form->getLabel('ordering'); ?>
			<?php echo $this->form->getInput('ordering'); ?></li>
			
			<li><?php echo $this->form->getLabel('album_id'); ?>
			<?php echo $this->form->getInput('album_id'); ?></li>
			</ul>
		</fieldset>
	</div>
	
	<div class="width-40 fltrt">
		<fieldset class="panelform">
			<legend><?php echo JText::_('COM_FACESWIPE_PARAMS'); ?></legend>
			<ul id="fs-facebook-account">
				<li id="fs-facebook-info"></li>
				
				<li><?php echo $this->form->getLabel('album_comment'); ?>
				<?php echo $this->form->getInput('album_comment'); ?></li>
				<li><?php echo $this->form->getLabel('album_fullscreen_layout'); ?>
				<?php echo $this->form->getInput('album_fullscreen_layout'); ?></li>
				<?php foreach($this->form->getFieldset('style') as $field): ?>
				<li><?php echo $field->label; echo $field->input;?></li>
				<?php endforeach; ?>
			</ul>
		</fieldset>
		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
	
	<div class="clr"></div>
	
	<div id="fs-facebook-wrapper">
		<div id="fs-facebook-albums" >
			<div class="fs-header fs-facebook-header">
				<h3><?php echo JText::_('FACESWIPE_ALBUM_YOUR_ALBUMS'); ?></h3>
			</div>
			<ul id="fs-facebook-load-album">
				<li onclick="FaceSwipe.fbgetAlbums();" class="fs-facebook-button thumb"><?php echo JText::_('FACESWIPE_ALBUM_LOAD_ALBUMS')?></li>
				<li class="fs-loading" id="fs-album-loading"><img src="components/com_faceswipe/assets/images/loading.gif"/></li>
			</ul>
			<div class="clearbreak"></div>
			<div id="fs-facebook-albums-list">
			</div>
		</div>
		<div id="fs-facebook-photos">
			<div class="fs-header fs-facebook-header">
				<h3><?php echo JText::_('FACESWIPE_ALBUM_YOUR_PHOTOS'); ?><span id="photos_header"></span></h3>
			</div>
			<ul id="fs-facebook-load-photos-button">
				<li id="fs-photo-next-page" class="fs-facebook-button fs-facebook-photo-next-page" onClick="FaceSwipe.photoLoadNextPage()">
					<?php echo JText::_('FACESWIPE_ALBUM_NEXT_PAGE'); ?>
				</li>
				<li id="fs-photo-back-page" class="fs-facebook-button fs-facebook-photo-previous-page" onClick="FaceSwipe.photoLoadBackPage()">
					<?php echo JText::_('FACESWIPE_ALBUM_PREVIOUS_PAGE'); ?>
				</li>
				<li class="fs-loading" id="fs-photo-loading"><img src="components/com_faceswipe/assets/images/loading.gif"/></li>
			</ul>
			<div class="clearbreak"></div>
			<div id="album_photos" class="<?php echo $this->item->album_id; ?>"></div>
		</div>
		<div id="fs-facebook-slides" class="fs-facebook-layout-detail">
			<div class="fs-header fs-facebook-header">
				<h3><?php echo JText::_('FACESWIPE_ALBUM_YOUR_SLIDES'); ?></h3>
			</div>
			<ul id="fs-facebook-control">
					<li onclick="FaceSwipe.changeLayout(this, 'thumb');" class="fs-facebook-button thumb"><?php echo JText::_('FACESWIPE_ALBUM_THUMBNAIL');?></li>
					<li onclick="FaceSwipe.changeLayout(this, 'detail');" class="fs-facebook-button detail"><?php echo JText::_('FACESWIPE_ALBUM_DETAILS')?></li>
			</ul>
			<div class="clearbreak"></div>
			<div class="gallery">
			<?php 
				if ($this->images)
				{
					foreach ($this->images as $image)
					{?>
						<script>
							FaceSwipe.addAvailablePhoto(<?php echo $image->image_fb_id; ?>);
						</script>
						<div class="fs-facebook-photo-block">
							<?php $data = json_decode(json_decode($image->image_data));?>
							<span style="background-image: url(<?php echo $image->image_thumbs; ?>);" onclick="FaceSwipe.onClickPhoto(this, <?php echo $image->image_fb_id; ?>, <?php echo $image->image_fb_album_id;?>);" class="fs-facebook-photo-thumb"></span>
							<div class="fs-facebook-photo-details">
							
								<ul class="photo-thumbs">
									<?php foreach ($data as $thumbs): ?>
										<li><input type="radio" value="<?php echo $thumbs->source;?>" 
										name="image_source[<?php echo $image->image_fb_id; ?>]" <?php echo ($thumbs->source == $image->image_source) ? ' checked="checked" ' : ''; ?> class="fs-photo-input-disabled"><?php echo $thumbs->width.'x'.$thumbs->height;?></li>
									<?php endforeach;?>
								</ul>
								
								<div class="photo-details">
									<input type="hidden" value="<?php echo $image->image_id; ?>" name="image_id[<?php echo $image->image_fb_id; ?>]" class="fs-photo-input-disabled">
									
									<input class="fs-photo-input-disabled" type="hidden" name="image_data[<?php echo $image->image_fb_id; ?>]" value='<?php echo json_decode($image->image_data); ?>'/>
									
									<input type="hidden" value="<?php echo $image->image_fb_id; ?>" name="image_fb_id[]" class="fs-photo-input-disabled">
									
									<input type="hidden" value="<?php echo $image->image_fb_album_id; ?>" name="image_fb_album_id[<?php echo $image->image_fb_id; ?>]" class="fs-photo-input-disabled">
									
									<input type="hidden" value="<?php echo $image->image_link; ?>" 
										name="image_link[<?php echo $image->image_fb_id; ?>]" class="fs-photo-input-disabled">
									
									<input type="hidden" value="<?php echo $image->image_thumbs; ?>"
										name="image_thumb[<?php echo $image->image_fb_id; ?>]" class="fs-photo-input-disabled">
									
									<span><?php echo JText::_('FACESWIPE_ALBUM_PHOTO_TITLE');?></span><br><input type="text" name="image_title[<?php echo $image->image_fb_id; ?>]" value="<?php echo $this->escape($image->image_title);?>" style="width: 90%;" class="fs-photo-input-disabled">
									<br/>
									<br/>
									<span><?php echo JText::_('FACESWIPE_ALBUM_PHOTO_DESCRIPTION');?></span><br><textarea style="width:90%; height: 50px;" name="image_description[<?php echo $image->image_fb_id; ?>]" class="fs-photo-input-disabled"><?php echo $this->escape($image->image_description); ?></textarea>
								</div>
									
								<div class="clearbreak"></div>
								
							</div>
							
							<div class="clearbreak"></div>
						</div>	
						
					<?php }
				}?>
			</div>
		</div>
		<div class="clearbreak"></div>
	</div>
</form>