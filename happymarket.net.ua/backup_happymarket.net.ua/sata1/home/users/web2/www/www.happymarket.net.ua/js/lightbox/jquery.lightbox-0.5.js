/**
 * jQuery lightBox plugin
 * This jQuery plugin was inspired and based on Lightbox 2 by Lokesh Dhakar (http://www.huddletogether.com/projects/lightbox2/)
 * and adapted to me for use like a plugin from jQuery.
 * @name jquery-lightbox-0.5.js
 * @author Leandro Vieira Pinho - http://leandrovieira.com
 * @version 0.5
 * @date April 11, 2008
 * @category jQuery plugin
 * @copyright (c) 2008 Leandro Vieira Pinho (leandrovieira.com)
 * @license CC Attribution-No Derivative Works 2.5 Brazil - http://creativecommons.org/licenses/by-nd/2.5/br/deed.en_US
 * @example Visit http://leandrovieira.com/projects/jquery/lightbox/ for more informations about this jQuery plugin
 */

// Offering a Custom Alias suport - More info: http://docs.jquery.com/Plugins/Authoring#Custom_Alias
(function($) {
	/**
	 * $ is an alias to jQuery object
	 *
	 */
	$.fn.lightBox = function(settings) {
		// Settings to configure the jQuery lightBox plugin how you like
		settings = jQuery.extend({
			// Configuration related to overlay
			overlayBgColor: 		'#000',		// (string) Background color to overlay; inform a hexadecimal value like: #RRGGBB. Where RR, GG, and BB are the hexadecimal values for the red, green, and blue values of the color.
			overlayOpacity:			0.8,		// (integer) Opacity value to overlay; inform: 0.X. Where X are number from 0 to 9
			// Configuration related to navigation
			fixedNavigation:		true,		// (boolean) Boolean that informs if the navigation (next and prev button) will be fixed or not in the interface.
			// Configuration related to images
			imageLoading:			'../images/classic/lightbox/loadingCirc.gif',		// (string) Path and the name of the loading icon
			imageBtnPrev:			'../images/classic/lightbox/prevoutside.png',			// (string) Path and the name of the prev button image
			imageBtnPrevHov:		'../images/classic/lightbox/prevoutside_h.png',			// (string) Path and the name of the prev button image
			imageBtnNext:			'../images/classic/lightbox/nextoutside.png',			// (string) Path and the name of the next button image
			imageBtnNextHov:		'../images/classic/lightbox/nextoutside_h.png',			// (string) Path and the name of the next button image
			imageBtnClose:			'../images/classic/lightbox/lightbox-btn-close.gif',		// (string) Path and the name of the close btn
			imageBlank:				'../images/classic/lightbox/lightbox-blank.gif',			// (string) Path and the name of a blank image (one pixel)
			// Configuration related to container image box
			containerBorderSize:	10,			// (integer) If you adjust the padding in the CSS for the container, #lightbox-container-image-box, you will need to update this value
			containerResizeSpeed:	200,		// (integer) Specify the resize duration of container image. These number are miliseconds. 400 is default.
			//dr3w.mod image properties
			maxImageWidth: 			500,
			minImageWidth:			200,
			//dr3w.mod display 
			displayRel:             false,	//gallery title
			// Configuration related to texts in caption. For example: Image 2 of 8. You can alter either "Image" and "of" texts.
			txtImage:				'Фото',	// (string) Specify text "Image"
			txtOf:					'из',		// (string) Specify text "of"
			// Configuration related to keyboard navigation
			keyToClose:				'c',		// (string) (c = close) Letter to close the jQuery lightBox interface. Beyond this letter, the letter X and the SCAPE key is used to.
			keyToPrev:				'p',		// (string) (p = previous) Letter to show the previous image
			keyToNext:				'n',		// (string) (n = next) Letter to show the next image.
			// Donґt alter these variables in any way
			imageArray:				[],
			activeImage:			0
		},settings);
/*dr3w.mod ie is too slow*/		
		if ( $.browser.msie ) {
			settings.containerResizeSpeed = settings.containerResizeSpeed/2
		}
		// Caching the jQuery object with all elements matched
		var jQueryMatchedObj = this; // This, in this context, refer to jQuery object
		/**
		 * Initializing the plugin calling the start function
		 *
		 * @return boolean false
		 */
		function _initialize() {
			_start(this,jQueryMatchedObj); // This, in this context, refer to object (link) which the user have clicked
			return false; // Avoid the browser following the link
		}
		/**
		 * Start the jQuery lightBox plugin
		 *
		 * @param object objClicked The object (link) whick the user have clicked
		 * @param object jQueryMatchedObj The jQuery object with all elements matched
		 */
		function _start(objClicked,jQueryMatchedObj) {
			// Hime some elements to avoid conflict with overlay in IE. These elements appear above the overlay.
			$('embed, object, select').css({ 'visibility' : 'hidden' });
			// Call the function to create the markup structure; style some elements; assign events in some elements.
			_set_interface();
			// Unset total images in imageArray
			settings.imageArray.length = 0;
			// Unset image active information
			settings.activeImage = 0;
			// We have an image set? Or just an image? Letґs see it.
			if ( jQueryMatchedObj.length == 1 ) {
				settings.imageArray.push(new Array(objClicked.getAttribute('href'),objClicked.getAttribute('title'),objClicked.getAttribute('author'),objClicked.getAttribute('rel')));
			} else {
				if(objClicked.getAttribute('rel')){
/*dr3w.mod for sep galleries*/ 
					var imgSet = objClicked.getAttribute('rel')
					// Check if rel attr is set for a certain set of images Add an Array (as many as we have), with href and title atributes, inside the Array that storage the images references		
					for ( var i = 0; i < jQueryMatchedObj.length; i++ ) {
						if(jQueryMatchedObj[i].getAttribute('rel') == imgSet)
							settings.imageArray.push(new Array(jQueryMatchedObj[i].getAttribute('href'),jQueryMatchedObj[i].getAttribute('title'),objClicked.getAttribute('author'),objClicked.getAttribute('rel')));
					}
				} else {
					// Add an Array (as many as we have), with href and title atributes, inside the Array that storage the images references		
					for ( var i = 0; i < jQueryMatchedObj.length; i++ ) {
						settings.imageArray.push(new Array(jQueryMatchedObj[i].getAttribute('href'),jQueryMatchedObj[i].getAttribute('title'),objClicked.getAttribute('author'),objClicked.getAttribute('rel')));
					}
				}
			}
			while ( settings.imageArray[settings.activeImage][0] != objClicked.getAttribute('href') ) {
				settings.activeImage++;
			}
			// Call the function that prepares image exibition
			_set_image_to_view();
		}
		/**
		 * Create the jQuery lightBox plugin interface
		 *
		 * The HTML markup will be like that:
			
			<div id="jquery-overlay"></div>
			<div id="jquery-lightbox">
				<table id="lightbox-table-main">
					<tr>
						<td id="lightbox-table-cell-left">
							<a href="#" id="lightbox-nav-btnPrev"></a>
						</td>
						<td id="lightbox-table-cell-center">
						<div id="lightbox-container-image-box">
							<div id="lightbox-container-image">
								<img id="lightbox-image">
								<div id="lightbox-loading">
									<a href="#" id="lightbox-loading-link">
										<img src="' + settings.imageLoading + '">
									</a>
								</div>
							</div>
						</div>
						<div id="lightbox-container-image-data-box">
							<div id="lightbox-container-image-data">
								<div id="lightbox-image-details">
									<span id="lightbox-image-details-caption"></span>
									<span id="lightbox-image-details-currentNumber"></span>
								</div>
								<div id="lightbox-secNav">
									<a href="#" id="lightbox-secNav-btnClose">
										<img src="' + settings.imageBtnClose + '">
									</a>
								</div>
							</div>
						</div>
						</td>
						<td id="lightbox-table-cell-right">
							<a href="#" id="lightbox-nav-btnNext"></a>
						</td>
					</tr>
				</table>
			</div>
		 *
		 */
		function _set_interface() {

			// Apply the HTML markup into body tag
			//$('body').append('<div id="jquery-overlay"></div><div id="jquery-lightbox"><div id="lightbox-container-image-box"><div id="lightbox-container-image"><img id="lightbox-image"><div style="" id="lightbox-nav"><a href="#" id="lightbox-nav-btnPrev"></a><a href="#" id="lightbox-nav-btnNext"></a></div><div id="lightbox-loading"><a href="#" id="lightbox-loading-link"><img src="' + settings.imageLoading + '"></a></div></div></div><div id="lightbox-container-image-data-box"><div id="lightbox-container-image-data"><div id="lightbox-image-details"><span id="lightbox-image-details-caption"></span><span id="lightbox-image-details-currentNumber"></span></div><div id="lightbox-secNav"><a href="#" id="lightbox-secNav-btnClose"><img src="' + settings.imageBtnClose + '"></a></div></div></div></div>');	
/*dr3w.mod centered layout*/
			$('body').append('<div id="jquery-overlay"></div><div id="jquery-lightbox"><div align="center"><table id="lightbox-table-main" align="center"><tr><td id="lightbox-table-cell-left"><div href="#" id="lightbox-nav-btnPrev"></div></td><td id="lightbox-table-cell-center"><div id="lightbox-container-image-box"><div id="lightbox-container-image"><img id="lightbox-image"><div id="lightbox-loading"><a href="#" id="lightbox-loading-link"><img src="' + settings.imageLoading + '"></a></div></div></div><div id="lightbox-container-image-data-contour"><div id="lightbox-container-image-data-box"><div id="lightbox-container-image-data"><div id="lightbox-image-details"><span id="lightbox-image-details-caption"></span><span id="lightbox-image-details-currentNumber"></span></div><div id="lightbox-secNav"><a href="#" id="lightbox-secNav-btnClose"><img src="' + settings.imageBtnClose + '"></a></div></div></div></div></td><td id="lightbox-table-cell-right"><div href="#" id="lightbox-nav-btnNext"></div></td></tr></table></div></div>');	
			
			// Get page sizes
			var arrPageSizes = ___getPageSize();
			// Style overlay and show it
			if($.browser.opera) {
				$.support.opacity = true; //workaround for Opera 9.2x opacity issue
			}
			$('#jquery-overlay').css({
				backgroundColor:	settings.overlayBgColor,
				opacity:			settings.overlayOpacity,
				width:				arrPageSizes[0],
				height:				arrPageSizes[1]
			}).fadeIn();
			// Get page scroll
			var arrPageScroll = ___getPageScroll();
			// set table width and height
			$('#lightbox-table-main').css({height:(arrPageSizes[3]-40)})
			$('#lightbox-table-cell-center').css({width:settings.maxImageWidth+40})
			
			// Calculate top and left offset for the jquery-lightbox div object and show it
			$('#jquery-lightbox').css({
				top:	arrPageScroll[1]+20,//(arrPageSizes[3] / 10),
				left:	arrPageScroll[0]
			}).show();
			// Assigning click events in elements to close overlay
			$('#jquery-overlay,#jquery-lightbox').click(function() {
				_finish();									
			});
			// Assign the _finish function to lightbox-loading-link and lightbox-secNav-btnClose objects
			$('#lightbox-loading-link,#lightbox-secNav-btnClose').click(function() {
				_finish();
				return false;
			});
			// If window was resized, calculate the new overlay dimensions
			$(window).resize(function() {
				// Get page sizes
				var arrPageSizes = ___getPageSize();
				// Style overlay and show it
				$('#jquery-overlay').css({
					width:		arrPageSizes[0],
					height:		arrPageSizes[1]
				});
				// Get page scroll
				var arrPageScroll = ___getPageScroll();
				// Calculate top and left offset for the jquery-lightbox div object and show it
				$('#jquery-lightbox').css({
					top:	arrPageScroll[1]+20,//(arrPageSizes[3] / 10),
					left:	arrPageScroll[0]
				});
			});
/*dr3w.mod*/// If dude scrolls and scrolls, calculate the new dimensions
			$(window).scroll(function () { 
				// Get page scroll
				var arrPageScroll = ___getPageScroll();
				// Calculate top and left offset for the jquery-lightbox div object and show it
				$('#jquery-lightbox').css({
					top:	arrPageScroll[1]+20,//(arrPageSizes[3] / 10),
					left:	arrPageScroll[0]
				});
			})
		}
		/**
		 * Prepares image exibition; doing a imageґs preloader to calculate itґs size
		 *
		 */
		function _set_image_to_view() { // show the loading
			// Show the loading
			$('#lightbox-loading').show();
			if ( settings.fixedNavigation ) {
				$('#lightbox-image,#lightbox-container-image-data-box,#lightbox-image-details-currentNumber').hide();
			} else {
				// Hide some elements
				$('#lightbox-image,#lightbox-nav,#lightbox-nav-btnPrev,#lightbox-nav-btnNext,#lightbox-container-image-data-box,#lightbox-image-details-currentNumber').hide();
			}
			// Image preload process
			var objImagePreloader = new Image();
			objImagePreloader.onload = function() {
			
				// Resizing large images - orginal by Christian Montoya. Stolen from thickbox
				var pagesize = ___getPageSize();
				var x = settings.maxImageWidth; //pagesize[2] - 40;
				var y = pagesize[3] - 120;
				var imageWidth = objImagePreloader.width;
				var imageHeight = objImagePreloader.height;
				if (imageWidth > x) {
					imageHeight = imageHeight * (x / imageWidth); 
					imageWidth = x; 
					if (imageHeight > y) { 
						imageWidth = imageWidth * (y / imageHeight); 
						imageHeight = y; 
					}
				} else if (imageHeight > y) { 
					imageWidth = imageWidth * (y / imageHeight); 
					imageHeight = y; 
					if (imageWidth > x) { 
						imageHeight = imageHeight * (x / imageWidth); 
						imageWidth = x;
					}
				}
				// End Resizing
				
				//if image is too small - resize container
				imageContWidth = imageWidth;
				imageContHeight = imageHeight;
				if(imageContWidth<settings.minImageWidth){
					imageContWidth = settings.minImageWidth;
				}
				
				$('#lightbox-nav-btnPrev,#lightbox-nav-btnNext').css({ top: ((pagesize[3] - 250)/2) });
				$('#lightbox-image').attr('src',settings.imageArray[settings.activeImage][0]);
				$('#lightbox-image').css({'width':imageWidth,'height':imageHeight});
				

				// Perfomance an effect in the image container resizing it
				_resize_container_image_box(imageContWidth,imageContHeight);
				//	clear onLoad, IE behaves irratically with animated gifs otherwise
				objImagePreloader.onload=function(){};
			};
			objImagePreloader.src = settings.imageArray[settings.activeImage][0];
		};
		/**
		 * Perfomance an effect in the image container resizing it
		 *
		 * @param integer intImageWidth The imageґs width that will be showed
		 * @param integer intImageHeight The imageґs height that will be showed
		 */
		function _resize_container_image_box(intImageWidth,intImageHeight) {
			// Get current width and height
			var intCurrentWidth = $('#lightbox-container-image-box').width();
			var intCurrentHeight = $('#lightbox-container-image-box').height();
			// Get the width and height of the selected image plus the padding
			var intWidth = (intImageWidth + (settings.containerBorderSize * 2)); // Plus the imageґs width and the left and right padding value
			var intHeight = (intImageHeight + (settings.containerBorderSize * 2)); // Plus the imageґs height and the left and right padding value
			// Diferences
			var intDiffW = intCurrentWidth - intWidth;
			var intDiffH = intCurrentHeight - intHeight;
			// Perfomance the effect
			if ( ( intDiffW == 0 ) && ( intDiffH == 0 ) ) {
				curResizeSpeed = 0;
			} else {
				curResizeSpeed = settings.containerResizeSpeed;
			}
			$('#lightbox-container-image-box').animate({height: intHeight },curResizeSpeed,function() { 
				$('#lightbox-container-image-box').animate({width: intWidth},curResizeSpeed,function() {
					_show_image();
				});
			});
			if ( ( intDiffW == 0 ) && ( intDiffH == 0 ) ) {
				if ( $.browser.msie ) {
					___pause(250);
				} else {
					___pause(100);	
				}
			} 
			if ( $.browser.msie ) {
				$('#lightbox-container-image-data-box').css({ width: intWidth });
			} else {
				$('#lightbox-container-image-data-box').css({ width: intImageWidth });
			}
			
		};
		/**
		 * Show the prepared image
		 *
		 */
		function _show_image() {
			$('#lightbox-loading').hide();
			$('#lightbox-image').fadeIn(function() {
				_show_image_data();
				_set_navigation();
			});
			_preload_neighbor_images();
		};
		/**
		 * Show the image information
		 *
		 */
		function _show_image_data() {
			$('#lightbox-image-details-caption').hide();
			$('#lightbox-image-details-caption').html('');
			
			$('#lightbox-container-image-data-box').animate({
			"height": "toggle"
			}, "fast", function() {
				if ( settings.imageArray[settings.activeImage][1] ) {
					if (settings.displayRel && settings.imageArray[settings.activeImage][3] ) {
						$('#lightbox-image-details-caption').append('<u>'+settings.imageArray[settings.activeImage][3]+'</u>:&nbsp;&nbsp;'+settings.imageArray[settings.activeImage][1]).show();
					} else {
						$('#lightbox-image-details-caption').append(settings.imageArray[settings.activeImage][1]).show();
					}
				}
				if ( settings.imageArray[settings.activeImage][2] ) {
					$('#lightbox-image-details-caption').append('<br>Автор: &nbsp;<span style="font-weight:normal">'+settings.imageArray[settings.activeImage][2]+'</span>').show();
				}
				// If we have a image set, display 'Image X of X'
				if ( settings.imageArray.length > 1 ) {
					$('#lightbox-image-details-currentNumber').html(settings.txtImage + ' ' + ( settings.activeImage + 1 ) + ' ' + settings.txtOf + ' ' + settings.imageArray.length).show();
				}
			});

			
		}
		/**
		 * Display the button navigations
		 *
		 */
		function _set_navigation() {
			$('#lightbox-nav').show();

			// Instead to define this configuration in CSS file, we define here. And itґs need to IE. Just.
			$('#lightbox-nav-btnPrev,#lightbox-nav-btnNext').css({ 'background' : 'transparent url(' + settings.imageBlank + ') no-repeat' });
			
			// Show the prev button, if not the first image in set
			if ( settings.activeImage != 0 ) {
				if ( settings.fixedNavigation ) {
					$('#lightbox-nav-btnPrev').unbind().show().css({ 'background' : 'url(' + settings.imageBtnPrev + ') left top no-repeat' })
					$('#lightbox-nav-btnPrev').hover(function() {
						$(this).css({ 'background' : 'url(' + settings.imageBtnPrevHov + ') left top no-repeat' });
					},function() {
						$(this).css({ 'background' : 'url(' + settings.imageBtnPrev + ') left top no-repeat' });
					}).bind('click',function() {
						settings.activeImage = settings.activeImage - 1;
						_set_image_to_view();
						return false;
					});
					/*
					$('#lightbox-nav-btnPrev').css({ 'background' : 'url(' + settings.imageBtnPrev + ') left top no-repeat' })
						.unbind()
						.bind('click',function() {
							settings.activeImage = settings.activeImage - 1;
							_set_image_to_view();
							return false;
						});
					*/
				} else {
					// Show the images button for Next buttons
					$('#lightbox-nav-btnPrev').unbind().hover(function() {
						$(this).css({ 'background' : 'url(' + settings.imageBtnPrev + ') left top no-repeat' });
					},function() {
						$(this).css({ 'background' : 'transparent url(' + settings.imageBlank + ') no-repeat' });
					}).show().bind('click',function() {
						settings.activeImage = settings.activeImage - 1;
						_set_image_to_view();
						return false;
					});
				}
			}
			else
				$('#lightbox-nav-btnPrev').hide();

				// Show the next button, if not the last image in set
			if ( settings.activeImage != ( settings.imageArray.length -1 ) ) {
				if ( settings.fixedNavigation ) {
					
					$('#lightbox-nav-btnNext').unbind().show().css({ 'background' : 'url(' + settings.imageBtnNext + ') right top no-repeat' })
					$('#lightbox-nav-btnNext').hover(function() {
						$(this).css({ 'background' : 'url(' + settings.imageBtnNextHov + ') right top no-repeat' });
					},function() {
						$(this).css({ 'background' : 'url(' + settings.imageBtnNext + ') right top no-repeat' });
					}).bind('click',function() {
						settings.activeImage = settings.activeImage + 1;
						_set_image_to_view();
						return false;
					});
					/*
					$('#lightbox-nav-btnNext').css({ 'background' : 'url(' + settings.imageBtnNext + ') right top no-repeat' })
						.unbind()
						.bind('click',function() {
							settings.activeImage = settings.activeImage + 1;
							_set_image_to_view();
							return false;
						});
					*/
				} else {
					// Show the images button for Next buttons
					$('#lightbox-nav-btnNext').unbind().hover(function() {
						$(this).css({ 'background' : 'url(' + settings.imageBtnNext + ') right top no-repeat' });
					},function() {
						$(this).css({ 'background' : 'transparent url(' + settings.imageBlank + ') no-repeat' });
					}).show().bind('click',function() {
						settings.activeImage = settings.activeImage + 1;
						_set_image_to_view();
						return false;
					});
				}
			}
			else
				$('#lightbox-nav-btnNext').hide();
			
			// Enable keyboard navigation
			_enable_keyboard_navigation();
		}
		/**
		 * Enable a support to keyboard navigation
		 *
		 */
		function _enable_keyboard_navigation() {
			$(document).keydown(function(objEvent) {
				_keyboard_action(objEvent);
			});
		}
		/**
		 * Disable the support to keyboard navigation
		 *
		 */
		function _disable_keyboard_navigation() {
			$(document).unbind();
		}
		/**
		 * Perform the keyboard actions
		 *
		 */
		function _keyboard_action(objEvent) {
			// To ie
			if ( objEvent == null ) {
				keycode = event.keyCode;
				escapeKey = 27;
			// To Mozilla
			} else {
				keycode = objEvent.keyCode;
				escapeKey = objEvent.DOM_VK_ESCAPE;
			}
			// Get the key in lower case form
			key = String.fromCharCode(keycode).toLowerCase();
			// Verify the keys to close the ligthBox
			if ( ( key == settings.keyToClose ) || ( key == 'x' ) || ( keycode == escapeKey ) ) {
				_finish();
			}
			// Verify the key to show the previous image
			if ( ( key == settings.keyToPrev ) || ( keycode == 37 ) ) {
				// If weґre not showing the first image, call the previous
				if ( settings.activeImage != 0 ) {
					settings.activeImage = settings.activeImage - 1;
					_set_image_to_view();
					_disable_keyboard_navigation();
				}
			}
			// Verify the key to show the next image
			if ( ( key == settings.keyToNext ) || ( keycode == 39 ) ) {
				// If weґre not showing the last image, call the next
				if ( settings.activeImage != ( settings.imageArray.length - 1 ) ) {
					settings.activeImage = settings.activeImage + 1;
					_set_image_to_view();
					_disable_keyboard_navigation();
				}
			}
		}
		/**
		 * Preload prev and next images being showed
		 *
		 */
		function _preload_neighbor_images() {
			if ( (settings.imageArray.length -1) > settings.activeImage ) {
				objNext = new Image();
				objNext.src = settings.imageArray[settings.activeImage + 1][0];

			}
			if ( settings.activeImage > 0 ) {
				objPrev = new Image();
				objPrev.src = settings.imageArray[settings.activeImage -1][0];
			}
		}
		/**
		 * Remove jQuery lightBox plugin HTML markup
		 *
		 */
		function _finish() {
			$('#jquery-lightbox').remove();
			$('#jquery-overlay').fadeOut(function() { $('#jquery-overlay').remove(); });
			// Show some elements to avoid conflict with overlay in IE. These elements appear above the overlay.
			$('embed, object, select').css({ 'visibility' : 'visible' });
		}
		/**
		 / THIRD FUNCTION
		 * getPageSize() by quirksmode.com
		 *
		 * @return Array Return an array with page width, height and window width, height
		 */
		function ___getPageSize() {
			var xScroll, yScroll;
			if (window.innerHeight && window.scrollMaxY) {	
				xScroll = window.innerWidth + window.scrollMaxX;
				yScroll = window.innerHeight + window.scrollMaxY;
			} else if (document.body.scrollHeight > document.body.offsetHeight){ // all but Explorer Mac
				xScroll = document.body.scrollWidth;
				yScroll = document.body.scrollHeight;
			} else { // Explorer Mac...would also work in Explorer 6 Strict, Mozilla and Safari
				xScroll = document.body.offsetWidth;
				yScroll = document.body.offsetHeight;
			}
			var windowWidth, windowHeight;
			if (self.innerHeight) {	// all except Explorer
				if(document.documentElement.clientWidth){
					windowWidth = document.documentElement.clientWidth; 
				} else {
					windowWidth = self.innerWidth;
				}
				windowHeight = self.innerHeight;
			} else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
				windowWidth = document.documentElement.clientWidth;
				windowHeight = document.documentElement.clientHeight;
			} else if (document.body) { // other Explorers
				windowWidth = document.body.clientWidth;
				windowHeight = document.body.clientHeight;
			}	
			// for small pages with total height less then height of the viewport
			if(yScroll < windowHeight){
				pageHeight = windowHeight;
			} else { 
				pageHeight = yScroll;
			}
			// for small pages with total width less then width of the viewport
			if(xScroll < windowWidth){	
				pageWidth = xScroll;		
			} else {
				pageWidth = windowWidth;
			}
			arrayPageSize = new Array(pageWidth,pageHeight,windowWidth,windowHeight);
			return arrayPageSize;
		};
		/**
		 / THIRD FUNCTION
		 * getPageScroll() by quirksmode.com
		 *
		 * @return Array Return an array with x,y page scroll values.
		 */

		function ___getPageScroll() {
			var xScroll, yScroll;
			if (self.pageYOffset) {
				yScroll = self.pageYOffset;
				xScroll = self.pageXOffset;
			} else if (document.documentElement && document.documentElement.scrollTop) {	 // Explorer 6 Strict
				yScroll = document.documentElement.scrollTop;
				xScroll = document.documentElement.scrollLeft;
			} else if (document.body) {// all other Explorers
				yScroll = document.body.scrollTop;
				xScroll = document.body.scrollLeft;	
			}
			arrayPageScroll = new Array(xScroll,yScroll);
			return arrayPageScroll;
		};
		 /**
		  * Stop the code execution from a escified time in milisecond
		  *
		  */
		 function ___pause(ms) {
			var date = new Date(); 
			curDate = null;
			do { var curDate = new Date(); }
			while ( curDate - date < ms);
		 };
		// Return the jQuery object for chaining. The unbind method is used to avoid click conflict when the plugin is called more than once
		return this.unbind('click').click(_initialize);
	};
})(jQuery); // Call and execute the function immediately passing the jQuery object