/*-----------------------------------------------------------------------------------

 	Custom JS - All front-end jQuery
 
-----------------------------------------------------------------------------------*/
 


jQuery(document).ready(function() {
								
								
 if (jQuery().superfish) {	
 
  jQuery('ul.nav').superfish({ 
            delay:       200,                            // one second delay on mouseout 
            animation:   {height:'show'},  // fade-in and slide-down animation 
			disableHI: true,
            speed:       'fast',                          // faster animation speed 
            autoArrows:  false,                           // disable generation of arrow mark-up 
            autoArrows:  true,                           // disable generation of arrow mark-up 			
            dropShadows: false                            // disable drop shadows 
        }); 
}

 if (jQuery().nivoSlider) {	
 
        jQuery('#slider').nivoSlider({
			effect: 'sliceDown',
			pauseTime: 3000, // How long each slide will show
			controlNav: false
		});

}

});