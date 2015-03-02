//-------------  Mega menu -------------//
    megaMenu = $('.mega-menu');
    megaLink = megaMenu.find('a');
    subMenu = megaMenu.find('ul.submenu');
    subMenu.prev('a').addClass('hasSub').append('<span class="hasDrop icon16 icomoon-icon-arrow-down-2"></span>');

    //show all links if mega menu has class showsub 
    megaMenu.each(function( index ) {
		if($(this).hasClass('showsub')) {
	    	$(this).find('ul.submenu').addClass('open');
	    	$(this).find('ul.submenu').closest('li').addClass('open');
	    }
	    if($(this).hasClass('hidesub')) {
	    	hidesub = $(this).find('ul.dropdown-menu>li.menu');
	    	hidesub.addClass('shrink');
	    	hidesub.hover(
			  function () {
			  	$(this).removeClass('shrink');
			  }, 
			  function () {
			  	$(this).addClass('shrink');
			  }
			);
	    }
	});
    megaLink.hover(
	  function () {
	    $(this).find('span.icon16').addClass('blue');
	  }, 
	  function () {
	    $(this).find('span.icon16').removeClass('blue');
	  }
	);
	function megaMenuHover (expr) {
		if(expr == true) {
			megaMenu.hover(function() {
			  $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn();
			  $(this).find('.dropdown-carret').stop(true, true).delay(200).fadeIn();
			}, function() {
			  $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut();
			  $(this).find('.dropdown-carret').stop(true, true).delay(200).fadeOut();
			});
		} else {
			return false;
		}
	}
    subMenu.closest('li').hover(
	  function () {
	  	if(!$(this).hasClass('open')) {
	  		$(this).addClass('open');
	    	$(this).find('ul.submenu').stop(true, true).first().delay(200).slideDown();
	  	}
	  }, 
	  function () {
	  	$(this).removeClass('open');
	    $(this).find('ul.submenu').stop(true, true).delay(200).slideUp();
	  }
	);

	//------------- Jrespond -------------//
	var jRes = jRespond([
        {
            label: 'small',
            enter: 0,
            exit: 1000
        },{
            label: 'desktop',
            enter: 1001,
            exit: 10000
        }
    ]);

	jRes.addFunc({
        breakpoint: 'desktop',
        enter: function() {
        	megaMenuHover(true);
        },
        exit: function() {
            megaMenuHover(false);
        }
    });
    jRes.addFunc({
        breakpoint: 'small',
        enter: function() {
           $('#sidebarbg,#sidebar,#content').removeClass('hided');
           megaMenuHover(false)
        },
        exit: function() {
           $('.collapseBtn.top.hide').removeClass('top hide');
     		megaMenuHover(true);
        }
    });