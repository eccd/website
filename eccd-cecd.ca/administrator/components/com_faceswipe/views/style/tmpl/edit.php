<?php
/**
 * @version		$Id: edit.php 13 2011-09-28 15:04:48Z trung $
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
		if (task == 'style.cancel' || document.formvalidator.isValid(document.id('style-form'))) {
			Joomla.submitform(task, document.getElementById('style-form'));
		} else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_faceswipe&style_id='.(int) $this->item->style_id); ?>" method="post" name="adminForm" id="style-form" class="form-validate">
	
	<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend><?php echo empty($this->item->style_id) ? JText::_('COM_FACESWIPE_NEW_STYLE') : JText::sprintf('COM_FACESWIPE_EDIT_STYLE', $this->item->style_id); ?></legend>
			<ul class="adminformlist">
				<li><?php echo $this->form->getLabel('style_name'); ?>
				<?php echo $this->form->getInput('style_name'); ?></li>
	
				<li><?php echo $this->form->getLabel('style_showcase'); ?>
				<?php echo $this->form->getInput('style_showcase'); ?></li>
				
				<li><?php echo $this->form->getLabel('style_transition'); ?>
				<?php echo $this->form->getInput('style_transition'); ?></li>
	
				<li><?php echo $this->form->getLabel('style_duration'); ?>
				<?php echo $this->form->getInput('style_duration'); ?></li>
	
				<li><?php echo $this->form->getLabel('style_height'); ?>
				<?php echo $this->form->getInput('style_height'); ?></li>
	
				<li><?php echo $this->form->getLabel('style_width'); ?>
				<?php echo $this->form->getInput('style_width'); ?></li>
				
				<li><?php echo $this->form->getLabel('style_thumbnail'); ?>
				<?php echo $this->form->getInput('style_thumbnail'); ?></li>
				
				<li><?php echo $this->form->getLabel('style_thumbnail_image_width'); ?>
				<?php echo $this->form->getInput('style_thumbnail_image_width'); ?></li>
				
				<li><?php echo $this->form->getLabel('style_thumbnail_image_height'); ?>
				<?php echo $this->form->getInput('style_thumbnail_image_height'); ?></li>
				
				<!--<li></?php echo $this->form->getLabel('style_thumbnail_position'); ?>
				</?php echo $this->form->getInput('style_thumbnail_position'); ?></li>-->
				
				<li><?php echo $this->form->getLabel('style_caption'); ?>
				<?php echo $this->form->getInput('style_caption'); ?></li>
				
				<li><?php echo $this->form->getLabel('style_random'); ?>
				<?php echo $this->form->getInput('style_random'); ?></li>
				
				<li><?php echo $this->form->getLabel('style_paused'); ?>
				<?php echo $this->form->getInput('style_paused'); ?></li>
				
				<li><?php echo $this->form->getLabel('style_title'); ?>
				<?php echo $this->form->getInput('style_title'); ?></li>
				
				<li><?php echo $this->form->getLabel('style_loop'); ?>
				<?php echo $this->form->getInput('style_loop'); ?></li>
				
				<li><?php echo $this->form->getLabel('style_controller'); ?>
				<?php echo $this->form->getInput('style_controller'); ?></li>
				
				<li><?php echo $this->form->getLabel('style_zoom'); ?>
				<?php echo $this->form->getInput('style_zoom'); ?></li>
				
				<li><?php echo $this->form->getLabel('style_pan'); ?>
				<?php echo $this->form->getInput('style_pan'); ?></li>
			</ul>
		</fieldset>
		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>