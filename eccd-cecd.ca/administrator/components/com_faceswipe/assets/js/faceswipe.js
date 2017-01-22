/**
 * @version		$Id: faceswipe.js 43 2011-12-21 18:38:05Z trung $
 * @copyright	Copyright (C) 2010 - 2011 Open Source Matters, Inc. All rights reserved.
 * @author		Nguyen Quang Trung
 * @link		http://joomavatar.com
 * @license		License GNU General Public License version 2 or later
 */
var FaceSwipe = {
	fbconnect : function(options)
	{
		FB.init({
			appId  : options.appID,
			status : true, // check login status
			cookie : true, // enable cookies to allow the server to access the session
			xfbml  : true, // parse XFBML
		//	channelUrl : 'http://localhost/login.php', // channel.html file
			oauth  : true // enable OAuth 2.0
		});
	},
	
	fbgetAlbums : function()
	{
		document.getElementById('fs-album-loading').style.display = 'block';
		FaceSwipe.showAccountInfo();
		var albumHTML = '';
		FB.api("me?fields=albums,accounts.limit(100)", function(response)
		{
			
			if (response.error) {
				alert(response.error.message);
				document.getElementById('fs-album-loading').style.display = 'none';
				return;
			}
			
			var albums = response["albums"]["data"];
				
			albumHTML = '<h1>Albums</h1><ul class="fs-facebook-albums">';
			
			for (var x = 0; x < albums.length; x++)
			{
				albumHTML += '<li id="'+ albums[x]['id'] +'" onclick="FaceSwipe.fbgetPhotos(this, '+ albums[x]['id'] +');">'+ albums[x]['name'] +'</li>'; 
			}
			
			albumHTML += '</ul>';
			
			pageHTML = '<h1>Fan Page</h1><ul class="fs-facebook-albums">';
			
			if (response["accounts"] != undefined) 
			{
				var pages = response["accounts"]["data"];
				for (var x = 0; x < pages.length; x++)
				{
					if (pages[x]['perms']) {
						pageHTML += '<li id="'+ pages[x]['id'] +'" onclick="FaceSwipe.fbgetAlbumsPage(this, '+ pages[x]['id'] +');">'+ pages[x]['name'] +'</li>';
					} 
				}
			}
			pageHTML += '</ul>';
			
			document.getElementById('fs-album-loading').style.display = 'none';
			document.getElementById('fs-facebook-albums-list').innerHTML = albumHTML + pageHTML;
			
			var headings = document.getElementById('fs-facebook-albums-list').getChildren('h1');
			var sliders = document.getElementById('fs-facebook-albums-list').getChildren('[class*="fs-facebook-albums"]');
			
			headings.each(function(el, index)
			{
				el.addEvent('click', function() {
					
					if (sliders[index].style.display == 'none') {
						sliders[index].style.display = '';
					} else {
						sliders[index].style.display = 'none';
					}
				});
			});
			
			sliders.each(function(el){
				el.style.display = 'none';
			});

		});
	},
	
	fbgetAlbumsPage: function (el, pageName, e) 
	{
		document.getElementById('fs-album-loading').style.display = 'block';
		FaceSwipe.showAccountInfo();
		
		var pageHTML = '';
		
		FB.api(pageName + "?fields=albums.limit(100)", function(response)
		{
			
			if (response.error) {
				alert(response.error.message);
				document.getElementById('fs-album-loading').style.display = 'none';
				return;
			}
			
			var albums = response["albums"]["data"];
			
			pageHTML = '<ul class="fs-facebook-albums">';
			
			for (var x = 0; x < albums.length; x++)
			{
				pageHTML += '<li id="'+ albums[x]['id'] +'" onclick="FaceSwipe.fbgetPhotos(this, '+ albums[x]['id'] +');">'+ albums[x]['name'] +'</li>'; 
			}
			
			pageHTML += '</ul>';
			
			document.getElementById('fs-album-loading').style.display = 'none';
			$(el)[0].innerHTML = $(el)[0].innerHTML + pageHTML; 
			$(el).attr('onclick', '');
		});	
	},
	
	fbgetPhotos : function(el, albumID)
	{
		FaceSwipe.showAccountInfo();
		
		$(el).attr('class','fs-facebook-album-active');
		$(el).siblings().attr('class','');
		document.getElementById('fs-photo-next-page').style.display = 'none';
		document.getElementById('fs-photo-back-page').style.display = 'none';
		
		this._loadPhotos("/"+albumID+"?fields=photos.limit(20)", albumID);
	},
	
	_loadPhotos: function(params, albumID)
	{
		document.getElementById('fs-photo-loading').style.display = 'block';
		if (this.albumID != albumID) {
			this.nextPhotoOffset = 0;
			this.previousPhotoOffset = 0;
		}
		
		this.albumID = albumID;
		
		FB.api(params,function(response)
		{
			if (response.error) {
				alert(response.error.message);
				return;
			}
			
			var photos = response["photos"]["data"];
			
			document.getElementById("photos_header").innerHTML = "("+photos.length+")";
			
			if (photos.length >= 20) {
				document.getElementById('fs-photo-next-page').style.display = 'inline-block';
			} else {
				document.getElementById('fs-photo-next-page').style.display = 'none';
			}
			
			if (photos.length > 0 && FaceSwipe.nextPhotoOffset >= 20) {
				document.getElementById('fs-photo-back-page').style.display = 'inline-block';
			} else if (FaceSwipe.nextPhotoOffset == 0) {
				document.getElementById('fs-photo-back-page').style.display = 'none';
			}
			
			var image_obj = '';
			
			for(var v=0; v < photos.length; v++) 
			{
				if (!FaceSwipe.availablePhotos[photos[v].id])
				{
					var image_arr = photos[v]["images"];
	
					image_obj += '<div class="fs-facebook-photo-block">';
					image_obj += '<span class="fs-facebook-photo-thumb" onclick="FaceSwipe.onClickPhoto(this, '+ photos[v].id +', '+ albumID +')" style="background-image: url('+image_arr[(image_arr.length-3)]["source"]+');"></span>';
					image_obj += '<div class="fs-facebook-photo-details">';
					image_obj += 	'<ul class="photo-thumbs">';
	
					//gets all the different sizes available for a given image
					for(var j = 0 ;j<image_arr.length;j++) {
						image_obj += '<li><input class="fs-photo-input-disabled" disabled="disabled"   type="radio" '+ ((j == 0) ? ' checked="checked" ' : '') +' name="image_source['+photos[v].id+']" value="'+image_arr[j]["source"]+'"/>'+image_arr[j]["width"]+"X"+image_arr[j]["height"]+'</a></li>';
					}
					
					image_obj += 	'</ul>';
					image_obj += 	'<div class="photo-details">';
					image_obj +=		'<input class="fs-photo-input-disabled" disabled="disabled" type="hidden" name="image_id['+photos[v].id+']" value="0"/>';
					image_obj +=		'<input class="fs-photo-input-disabled" disabled="disabled" type="hidden" name="image_data['+photos[v].id+']" value=\''+JSON.encode(image_arr)+'\'/>';
					image_obj += 		'<input class="fs-photo-input-disabled" disabled="disabled"   type="hidden" name="image_fb_id[]" disabled="disapbled" value="'+photos[v].id+'"/>';
					image_obj +=		'<input class="fs-photo-input-disabled" disabled="disabled"   type="hidden" name="image_fb_album_id['+photos[v].id+']" value="'+albumID+'"/>';
					image_obj +=		'<input class="fs-photo-input-disabled" disabled="disabled"   type="hidden" name="image_link['+photos[v].id+']" value="'+photos[v].link+'"/>';
					image_obj +=		'<input class="fs-photo-input-disabled" disabled="disabled"   type="hidden" name="image_thumb['+photos[v].id+']" value="'+image_arr[(image_arr.length-3)]["source"]+'"/>';
					image_obj +=		'<span>Title</span><br/><input  class="fs-photo-input-disabled" disabled="disabled"   style="width: 90%;" type="text" name="image_title['+photos[v].id+']"/><br/><br/>';
					image_obj +=		'<span>Description</span><br/><textarea  class="fs-photo-input-disabled" disabled="disabled"   name="image_description['+photos[v].id+']" style="width:90%; height: 50px;"></textarea>';			
					image_obj += 	'</div><div class="clearbreak"></div>';
					image_obj += '</div><div class="clearbreak"></div>';
					
					image_obj += '</div>'; 
					image_obj += '</div>';
				}
			}
			document.getElementById('fs-photo-loading').style.display = 'none';
			//inserts a new row into the table
			var table = document.getElementById("album_photos");
			table.innerHTML = image_obj;
			$('#album_photos').attr('class', albumID);
		});	
	},
	
	nextPhotoOffset: 0,
	
	previousPhotoOffset: 0,
	
	photoLoadNextPage: function()
	{
		this.nextPhotoOffset = this.nextPhotoOffset + 20;
		var nextPhotoParam = "/"+this.albumID+"?fields=photos.limit(20).offset(" + this.nextPhotoOffset+")";
		FaceSwipe._loadPhotos(nextPhotoParam , this.albumID);
	},
	
	photoLoadBackPage: function()
	{
		this.nextPhotoOffset = (this.nextPhotoOffset >= 20) ? this.nextPhotoOffset - 20 : 0;
		var previousPhotoParam = "/"+this.albumID+"?fields=photos.limit(20).offset(" + this.nextPhotoOffset+")";
		FaceSwipe._loadPhotos(previousPhotoParam, this.albumID);
	},
	
	onClickPhoto: function(item, imageFBID, albumID)
	{
		var block =  $(item).parent();
		var parent = block.parent();
		
		var albumSide = (parent.attr('id') == 'album_photos');
		
		//set available photo
		FaceSwipe.availablePhotos[imageFBID] = albumSide ? true : false;
		
		if (!albumSide)
		{
			if (!$('#album_photos').hasClass(albumID))
			{
				block.remove();
				return false;
			}
		} 
		
		// set target
		var target = albumSide ? $('#fs-facebook-slides .gallery') : $('#album_photos');
		
		if (albumSide) {
			block.find('.fs-photo-input-disabled').attr('disabled', false);
		} else {
			block.find('.fs-photo-input-disabled').attr('disabled', true);
		}
		
		block.appendTo(target);
	},

	fbgetLoginStatus : function()
	{
		FB.getLoginStatus(function(response) 
		{
		  if (response.authResponse) {
			  FaceSwipe.fbgetAccountInfo();
			  return true;
		  } else {
			  FaceSwipe.fbgetLoginButton();
			  return false;
		  }
		});
	},
	
	fbgetLogin : function ()
	{
		FB.login(function(response) 
		{
		   if (response.authResponse) 
		   {
				FaceSwipe.fbgetAccountInfo();
				return true;
		   } else {
			   alert('User cancelled login or did not fully authorize.');
			   return false;
		   }
		}, {scope: 'email, user_photos, manage_pages'});
	},
	
	fbgetLogOut : function ()
	{
		FB.logout();
		FaceSwipe.fbgetLoginButton();
	},
	
	fbgetAccountInfo : function()
	{
		document.getElementById('fs-facebook-info').innerHTML = (
				' <img onclick="FaceSwipe.fbgetLogOut();" style="cursor: pointer;"' +
					'src="components/com_faceswipe/assets/images/logout.jpg">'
		);
	},
	
	fbgetLoginButton: function()
	{
		document.getElementById('fs-facebook-info').innerHTML = (
			'<img onclick="FaceSwipe.fbgetLogin();" style="cursor: pointer;"' +
				 'src="components/com_faceswipe/assets/images/login.jpg">'
		);
	},
	
	availablePhotos: {},
	
	addAvailablePhoto: function(imageFbID)
	{
		if (!FaceSwipe.availablePhotos[imageFbID]){
			FaceSwipe.availablePhotos[imageFbID] = imageFbID;
		}
	},
	
	changeLayout: function (el, layout)
	{
		$(el).parent().parent().attr('class', 'fs-facebook-layout-'+ layout);
	},
	
	showAccountInfo: function()
	{
		FaceSwipe.fbgetLoginStatus();
	}
}