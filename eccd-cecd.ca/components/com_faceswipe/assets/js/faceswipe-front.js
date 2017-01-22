/**
 * @version		$Id: faceswipe-front.js 27 2011-10-02 01:51:00Z trung $
 * @copyright	Copyright (C) 2010 - 2011 Open Source Matters, Inc. All rights reserved.
 * @author		Nguyen Quang Trung
 * @link		http://joomavatar.com
 * @license		License GNU General Public License version 2 or later
 */
var FaceSwipeFront =
{
	gallery: function(randID)
	{
		var galleryID = 'fs-front-gallery-' + randID;
		var slideEffect = {};
		$(galleryID).getElements('img').each(function(slide , x)
		{
			slideEffect[x] = new Fx.Morph(slide, {duration: 300,wait: true});
			
			slide.addEvent('mouseenter', function(e)
			{
				new Event(e).stop();
				slideEffect[x].cancel().start({
				   'height': 300,
				});
			});

			slide.addEvent('mouseleave', function(e)
			{
				new Event(e).stop();
				slideEffect[x].cancel().start({
					'height': 600,
				});
			});
		});	
	}
}