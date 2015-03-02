//Function to convert hex format to a rgb color
function rgb2hex(rgb){
    rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
    return "#" +
    ("0" + parseInt(rgb[1],10).toString(16)).slice(-2) +
    ("0" + parseInt(rgb[2],10).toString(16)).slice(-2) +
    ("0" + parseInt(rgb[3],10).toString(16)).slice(-2);
}

(function($) {

    $.fn.portal = function(id, options) {
        var conf = {
            title: "",
            content: "",
            closer: true,
            hider: true,
            min: false,
            settings: true,
            detachable: true,
            floating: true,
            width: 300,
            modal: true
        };
        $.extend(conf, options);
   
        var prtlt = $('<div>').attr("id", id).addClass("portlet ui-widget ui-widget-content ui-helper-clearfix sortable").append(
            $('<div>').addClass("portlet-header ui-state-default").append(
                $('<span>').addClass("title").text(conf.title)      
                )
            ).append(
            $('<fieldset>').addClass("portlet-content").html(conf.content)
            ).mouseup(function() { 
            //$(this).offset().left+'--'+$(this).offset().top+'--'+$(this).height()+'--'+$(this).width();
            }
            ).data("container", $(this));
            /*//Add the detach button
            if (conf.detachable) {
             prtlt.find(".portlet-header").prepend(
                $('<input/>').addClass("ui-icon ui-icon-circle-arrow-n portlet-detach").attr({
                   "type": "button",
                   "title": "Detach"
                })
             );
            }*/
        //Add the settings button
        if (conf.settings) {
            prtlt.find(".portlet-header").prepend(
                $('<input/>').addClass("ui-icon ui-icon-circle-triangle-s portlet-config").attr({
                    "type": "button",
                    "title": "Settings"//conf.settings.title
                }).dialog(id+"_menu", {
                    menu:conf.settings.menu
                })
                );
        }
      
        //Add the hider button
        /*if (conf.hider) {
         prtlt.find(".portlet-header").prepend(
            $('<input/>').addClass("ui-icon ui-icon-circle-minus portlet-min-max").attr({
               "type": "button",
               "title": "Minimize"
            })
         );
         if(conf.min) {
            prtlt.data("filler", conf.min)
         }
      }*/
        //Add the closer button
        if (conf.closer) {
            prtlt.find(".portlet-header").prepend(
                $('<input/>').addClass("ui-icon ui-icon-circle-close portlet-closer").attr({
                    "type": "button",
                    "title": "Close"
                })
                );
        }
         
        return this.each(function() {
            prtlt.hide();

            if(conf.floating) {
                if(conf.detachable) {
                    prtlt.find(".portlet-header input.portlet-detach").attr("title", "Attach").removeClass("ui-icon-circle-arrow-n").addClass("ui-icon-circle-arrow-s").data("detached", 1);
                } 
                prtlt.css("z-index", "1001").find(".portlet-content").html(
                    $("<div>").html(
                        prtlt.find(".portlet-content").html()
                        ).addClass("content")
                    );
                $.portal.detach(prtlt, conf);
            }
            else {
                $(this).append(prtlt);
            }
            if(conf.min) {
                prtlt.find("input.portlet-min-max").data("go", false).click(); 
                prtlt.find(".portlet-content").hide(); 
            }
            else {
                prtlt.find("input.portlet-min-max").data("go", true);
            }
            prtlt.show();
        });
    };
   
    $.portal = function(id, conf) {
        conf = conf || {};
        conf.floating = true;
        $(document.body).portal(id, conf);
    };
  
    $.portal.detach = function(prtlt, conf) {
        var conf = conf || {};
        conf.width = conf.width || $(prtlt).width();
        conf.modal = conf.modal || false;
        prtlt.appendTo(document.body).removeClass("sortable").addClass("popup").draggable({
            handle:prtlt.find(".portlet-header")
        }).resizable({  
            minWidth:150,
            minHeight:70,
            alsoResize:prtlt.find(".portlet-content")
        }).css({  
            "width": conf.width + "px",
            "position": "absolute",
            "z-index": "101"
        }).data("popHeight", "");
        if (conf.modal) {
            prtlt.css("z-index", "1001");
            $.portal.modal();
        }
		
        var top = document.body.scrollTop + (document.body.clientHeight/2 - prtlt.outerHeight()/2),
        lft = document.body.scrollLeft + (document.body.clientWidth/2 - prtlt.outerWidth()/2); 
        if(prtlt.outerHeight() > document.body.clientHeight) top = 0;   
        if(prtlt.outerWidth() > document.body.clientWidth) lft = 0;   
      
        prtlt.css({   
            "top": top,  
            "left": lft  
        });
        if (prtlt.parent().data("min")) {
            prtlt.find(".ui-resizable-handle").toggle();
        }
    };
   
    $.portal.attach = function(prtlt) {
        prtlt.data("container").prepend(prtlt);
        $(".modal").remove();
        $(prtlt).addClass("sortable").removeClass("popup").draggable("destroy").resizable("destroy").css({  
            "width": "",
            "position": "",
            "z-index": "5", 
            "height": "" 
        });
        $(prtlt).find(".portlet-content").css({  
            "width": "",
            "height": "" 
        });
    };
   
    $.portal.modal = function() {
        $("<div class='modal' />").css({
            "height": 10,//$(document).height(),
            "z-index": "1000"
        }).appendTo(document.body);
    }
   
    $.portal.remember = function(callback) {
        $.portal.layout = {};
        $(".portalBox").each(function(x, cont) {
            if (this.id) {
                var id = this.id;
                $.portal.layout[id] = {};
                $(cont).find(".sortable").each(function(y, prt) {
                    if ($(prt).find(".portlet").attr("id")) {
                        $.portal.layout[id][$(prt).find(".portlet").attr("id")] = {
                            minimized: $(prt).data("min") ? true : false
                        };
                    }
                });
            }       
        });
        if($.portal.memCallBack) {
            $.portal.memCallBack($.portal.layout, callback);
        }
        else if(callback) {
            callback($.portal.layout);
        }
    }
   
    $(document).ready(function() {
      
        $("div.portalBox").sortable({
            connectWith: '.portalBox',
            items: '.sortable',
            handle: '.portlet-header',
            placeholder: 'placer',
            forcePlaceholderSize: true,
            forceHelperSize:true,
            revert: true,
            dropOnEmpty:true,
            stop: function(e, ui) { 
                ui.item.data("container", $(e.target))
                $.portal.remember();
                if($.portal.onStop) {
                    $.portal.onStop();
                }
            }
        });
      
    });
   
})(jQuery);


/* Portal behaviors */
$(document).resize(function(){
    }).mousedown(function() {
    $(".ui-icon-triangle-1-s").removeClass("ui-icon-triangle-1-s").addClass("ui-icon-circle-triangle-s");
});

$(".portlet-header").live("mouseover", function() {
    $(this).removeClass("ui-state-default").addClass("ui-state-hover");
}).live("mouseout", function() {
    $(this).removeClass("ui-state-hover").addClass("ui-state-default");
}).live("mousedown", function() {
    $(this).removeClass("ui-state-default").addClass("ui-state-active");
}).live("mouseup", function() {
    $(this).removeClass("ui-state-active").addClass("ui-state-default");
});

$("input.portlet-closer").live("click", function() {
    $(this).parents(".portlet").remove();
    $(".modal").remove();
    $.portal.remember();
    return false;
});

$("input.portlet-min-max").live("click", function() {
    var $this = $(this),
    prt = $this.parents(".sortable"),
    pop = $this.parents(".popup"),
    flr = $this.parents(".portlet").data("filler");
    if($this.attr("title") == "Maximize") {
        if(flr) {
            flr($this.parents(".portlet").attr("id"));
            $this.parents(".portlet").data("filler", false);
        }
        if(pop.length) pop.height(pop.data("popHeight")).find(".ui-resizable-handle").show();
        $this.attr("title", "Minimize").addClass("ui-icon-circle-minus").removeClass("ui-icon-circle-plus");
        $this.parents(".portlet").find(".portlet-content").slideDown();
        prt.data("min", false);
    }
    else {
        if(pop.length) pop.data("popHeight", pop.height()).css("height", "").find(".ui-resizable-handle").hide();
        $this.attr("title", "Maximize").removeClass("ui-icon-circle-minus").addClass("ui-icon-circle-plus");
        $this.parents(".portlet").find(".portlet-content").slideUp();
        prt.data("min", true);
    }
    if ($this.data("go")) {
        $.portal.remember();
    }
    else {
        $this.data("go", true);
    }
});

$("input.portlet-config").live("click", function() {
    
    $(this).removeClass("ui-icon-circle-triangle-s").addClass("ui-icon-triangle-1-s");
    $( "#dialog:ui-dialog" ).dialog( "destroy" );

    var portletModal = $(this).parent().parent();
    var thisId = $(this).parent().parent().attr('id');
    var thisId = thisId.replace('PortletContainer',''); 
    
    /* getting css values */
    var $dialogContent = $("#dialog-modal");
    var containerHeight = portletModal.css('height');
    var containerWidth = $(this).parent().parent().css('width');
    var containerLeft = portletModal.css('left');
    var containerTop = $(this).parent().parent().css('top');
    var containerTextColor = $(this).parent().parent().css('color');
    var containerBgColor = $(this).parent().parent().css('background-color');
    var containerBorderTopStyle = $(this).parent().parent().css('border-top-style');
    var containerBorderRightStyle = $(this).parent().parent().css('border-right-style');
    var containerBorderLeftStyle = $(this).parent().parent().css('border-left-style');
    var containerBorderBottomStyle = $(this).parent().parent().css('border-bottom-style');
    var containerBorderTopColor = $(this).parent().parent().css('border-top-color');
    var containerBorderRightColor = $(this).parent().parent().css('border-right-color');
    var containerBorderLeftColor = $(this).parent().parent().css('border-left-color');
    var containerBorderBottomColor = $(this).parent().parent().css('border-bottom-color');
    var containerMarginTop = $(this).parent().parent().css('margin-top');
    var containerMarginBottom = $(this).parent().parent().css('margin-bottom');
    var containerMarginRight = $(this).parent().parent().css('margin-right');
    var containerMarginLeft = $(this).parent().parent().css('margin-left');
    var containerPaddingTop = $(this).parent().parent().css('padding-top');
    var containerPaddingBottom = $(this).parent().parent().css('padding-bottom');
    var containerPaddingRight = $(this).parent().parent().css('padding-right');
    var containerPaddingLeft = $(this).parent().parent().css('padding-left');
    var containerFont = $(this).parent().parent().css('font-family');
    var containerFontAlignment = $(this).parent().parent().css('text-align');
    var containerFontSize = $(this).parent().parent().css('font-size');
    var containerFontColor = $(this).parent().parent().css('color');
    var containerisBold = $(this).parent().parent().css('font-weight');
    var containerisItalic = $(this).parent().parent().css('font-style');
    var containerTextDecoration = $(this).parent().parent().css('text-decoration');
    var containerWordSpacing = $(this).parent().parent().css('word-spacing');
    var containerLineHeight = $(this).parent().parent().css('line-height');
    var containerLetterSpacing = $(this).parent().parent().css('letter-spacing');
    var containerBorderTop = $(this).parent().parent().css('border-top-width');
    var containerBorderRight = $(this).parent().parent().css('border-right-width');
    var containerBorderBottom = $(this).parent().parent().css('border-bottom-width');
    var containerBorderLeft = $(this).parent().parent().css('border-left-width');
    var containerBorderIsSame = $("#BorderIsSame-"+thisId);
    var containerBorderStyleIsSame = $("#BorderStyleIsSame-"+thisId);
    var containerBorderColorIsSame = $("#BorderColorIsSame-"+thisId);
    var containerMarginIsSame = $("#MarginIsSame-"+thisId);
    var containerPaddingIsSame = $("#PaddingIsSame-"+thisId);
    var containercss = $("#containercss-"+thisId);
    //alert(containerFontSize);
    //alert(containerLineHeight);
    /* getting field values */
    var containerHeightField = $dialogContent.find("input[id='containerHeight']");
    var containerWidthField = $dialogContent.find("input[id='containerWidth']");
    var containerLeftField = $dialogContent.find("input[id='containerLeft']");
    var containerTopField = $dialogContent.find("input[id='containerTop']");
    var containerTextColorField = $dialogContent.find("input[id='colorpickerField1']");
    var containerBgColorField = $dialogContent.find("input[id='colorpickerField2']");
    var containerBorderTopStyleField = $dialogContent.find("select[id='top-border-style']");
    var containerBorderTopColorField = $dialogContent.find("input[id='colorpickerField3']");
    var containerBorderTopField = $dialogContent.find("input[id='top-border-width']");
    var containerBorderRightStyleField = $dialogContent.find("select[id='right-border-style']");
    var containerBorderRightField = $dialogContent.find("input[id='right-border-width']");
    var containerBorderRightColorField = $dialogContent.find("input[id='colorpickerField4']");
    var containerBorderLeftStyleField=$dialogContent.find("select[id='left-border-style']");
    //alert("hello");alert(containerBorderTopField.val(containerBorderTopField));
    var containerBorderLeftColorField = $dialogContent.find("input[id='colorpickerField5']");
    var containerBorderLeftField = $dialogContent.find("input[id='left-border-width']");
    var containerBorderBottomStyleField = $dialogContent.find("select[id='bottom-border-style']");
    var containerBorderBottomColorField = $dialogContent.find("input[id='colorpickerField6']");
    var containerBorderBottomField=$dialogContent.find("input[id='bottom-border-width']");
    var containerMarginTopField=$dialogContent.find("input[id='margin-top-border-width']");
    var containerMarginBottomField = $dialogContent.find("input[id='margin-bottom-border-width']");
    var containerMarginRightField = $dialogContent.find("input[id='margin-right-border-width']");
    //alert(containerMarginRight);alert(containerMarginRightField.val());
    var containerMarginLeftField = $dialogContent.find("input[id='margin-left-border-width']");
    var containerPaddingTopField=$dialogContent.find("input[id='padding-top-border-width']");
    var containerPaddingBottomField = $dialogContent.find("input[id='padding-bottom-border-width']");
    var containerPaddingRightField = $dialogContent.find("input[id='padding-right-border-width']");
    var containerPaddingLeftField = $dialogContent.find("input[id='padding-left-border-width']");
    var containerFontField=$dialogContent.find("select[id='fontName']");
    var containerFontAlignmentField = $dialogContent.find("select[id='alignment']");
    var containerFontSizeField = $dialogContent.find("select[id='fontSize']");
    var containerFontColorField = $dialogContent.find("input[id='colorpickerField1']");
    var containerisBoldField=$dialogContent.find("input[id='isBold']");
    var containerisItalicField = $dialogContent.find("input[id='isItalic']");
    var containerTextDecorationField = $dialogContent.find("select[id='textDecoration']");
    var containerWordSpacingField = $dialogContent.find("select[id='wordSpacing']");
    var containerLineHeightField = $dialogContent.find("select[id='lineHeight']");
    var containerLetterSpacingField = $dialogContent.find("select[id='letterSpacing']");
    var containerBorderIsSameField = $dialogContent.find("input[id='bordersameforall']");
    var containerBorderStyleIsSameField = $dialogContent.find("input[id='borderstylesameforall']");
    var containerBorderColorIsSameField = $dialogContent.find("input[id='bordercolorsameforall']");
    var containerMarginIsSameField = $dialogContent.find("input[id='marginsameforall']");
    var containerPaddingIsSameField = $dialogContent.find("input[id='paddingsameforall']");
    var containerCssField = $dialogContent.find("textarea[id='customcss']");
    var containerBorderTopUnitField = $dialogContent.find("select[id='top-border-unit']");
    var containerBorderRightUnitField = $dialogContent.find("select[id='right-border-unit']");
    var containerBorderLeftUnitField = $dialogContent.find("select[id='left-border-unit']");
    var containerBorderBottomUnitField = $dialogContent.find("select[id='bottom-border-unit']");
    var containerMarginTopUnitField = $dialogContent.find("select[id='margin-top-border-unit']");
    var containerMarginBottomUnitField = $dialogContent.find("select[id='margin-bottom-border-unit']");
    var containerMarginRightUnitField = $dialogContent.find("select[id='margin-right-border-unit']");
    var containerMarginLeftUnitField = $dialogContent.find("select[id='margin-left-border-unit']");
    var containerPaddingTopUnitField = $dialogContent.find("select[id='padding-top-border-unit']");
    var containerPaddingBottomUnitField = $dialogContent.find("select[id='padding-bottom-border-unit']");
    var containerPaddingRightUnitField = $dialogContent.find("select[id='padding-right-border-unit']");
    var containerPaddingLeftUnitField = $dialogContent.find("select[id='padding-left-border-unit']");
   
    /* setting field values as rettrieved from container actual values */
    containerFontField.val(containerFont);
    containerFontAlignmentField.val(containerFontAlignment);
    containerFontSizeField.val(containerFontSize);
    containerFontColorField.val(rgb2hex(containerFontColor));
    containerisBoldField.val(containerisBold);
    containerisItalicField.val(containerisItalic);
    containerTextDecorationField.val(containerTextDecoration);
    containerWordSpacingField.val(containerWordSpacing);
    containerLineHeightField.val(containerLineHeight);
    containerLetterSpacingField.val(containerLetterSpacing);
    containerBorderTopStyleField.val(containerBorderTopStyle);
    containerBorderTopColorField.val(rgb2hex(containerBorderTopColor));
    //alert("top"+containerBorderTop);
    
    /*Border Conditions*/
    if ((containerBorderTop.match("px")).length > 0)
    {
        containerBorderTop = containerBorderTop.replace('px','');
        var containerBorderTopUnit="px";
    }
    else{//alert("called");
        containerBorderTop = containerBorderTop.replace('em','');
        containerBorderTop=parseInt(containerBorderTop)/8;
        var containerBorderTopUnit="em";
    }
      
    containerBorderTopField.val(containerBorderTop);
    containerBorderRightStyleField.val(containerBorderRightStyle);
    if ((containerBorderRight.match("px")).length > 0)
    {
        containerBorderRight = containerBorderRight.replace('px','');
        var containerBorderRightUnit="px";
    }
    else{
        containerBorderRight = containerBorderRight.replace('em','');
        containerBorderRight=parseInt(containerBorderRight)/8;
        containerBorderRightUnit="em";
    }
    containerBorderRightField.val(containerBorderRight);
    containerBorderRightColorField.val(rgb2hex(containerBorderRightColor));
    containerBorderLeftStyleField.val(containerBorderLeftStyle);
    containerBorderLeftColorField.val(rgb2hex(containerBorderLeftColor));
    //alert((containerBorderLeft.match("px").length));
    if ((containerBorderLeft.match("px").length) > 0)
    {//alert("called");
        containerBorderLeft = containerBorderLeft.replace('px','');
        var containerBorderLeftUnit="px";
    }
    else{
        containerBorderLeft = containerBorderLeft.replace('em','');
        containerBorderLeft=parseInt(containerBorderLeft)/8;
        //alert(containerBorderLeft);
        var containerBorderLeftUnit="em";
    }
    containerBorderLeftField.val(containerBorderLeft);
    containerBorderBottomStyleField.val(containerBorderBottomStyle);
    containerBorderBottomColorField.val(rgb2hex(containerBorderBottomColor));
    containerBorderBottomField.val(containerBorderBottom);
    
    if ((containerBorderBottom.match("px")).length > 0)
    {
        containerBorderBottom = containerBorderBottom.replace('px','');
        var containerBorderBottomUnit="px";
    }
    else{
        containerBorderBottom = containerBorderBottom.replace('em','');
        containerBorderBottom=parseInt(containerBorderBottom)/8;
        var containerBorderBottomUnit="em";
    }
    
    /*margin*/
    //alert(containerMarginTop);
    if ((containerMarginTop.match("px")).length > 0)
    {
        containerMarginTop = containerMarginTop.replace('px','');
        var containerMarginTopUnit="px";
    }
    else{
        containerMarginTop = containerMarginTop.replace('em','');
        containerMarginTop=parseInt(containerMarginTop)/8;
        var containerMarginTopUnit="em";
    }
    if ((containerMarginBottom.match("px")).length > 0)
    {
        containerMarginBottom = containerMarginBottom.replace('px','');
        var containerMarginBottomUnit="px";
    }
    else{
        containerMarginBottom = containerMarginBottom.replace('em','');
        containerMarginBottom=parseInt(containerMarginBottom)/8;
        var containerMarginBottomUnit="em";
    }
    if ((containerMarginRight.match("px")).length > 0)
    {
        containerMarginRight = containerMarginRight.replace('px','');
        var containerMarginRightUnit="px";
    }
    else{
        containerMarginRight = containerMarginRight.replace('em','');
        containerMarginRight=parseInt(containerMarginRight)/8;
        var containerMarginRightUnit="em";
    }
    if ((containerMarginLeft.match("px")).length > 0)
    {
        containerMarginLeft = containerMarginLeft.replace('px','');
        var containerMarginLeftUnit="px";
    }
    else{
        containerMarginLeft = containerMarginLeft.replace('em','');
        containerMarginLeft=parseInt(containerMarginLeft)/8;
        var containerMarginLeftUnit="em";
    }
   
    containerMarginTopField.val(containerMarginTop);
    containerMarginBottomField.val(containerMarginBottom);
    containerMarginRightField.val(containerMarginRight);
    containerMarginLeftField.val(containerMarginLeft);
    
    /*Padding*/    
    if ((containerPaddingTop.match("px")).length > 0)
    {
        containerPaddingTop = containerPaddingTop.replace('px','');
        var containerPaddingTopUnit="px";
    }
    else{
        containerPaddingTop = containerPaddingTop.replace('em','');
        containerPaddingTop=parseInt(containerPaddingTop)/8;
        var containerPaddingTopUnit="em";
    }
    if ((containerPaddingBottom.match("px")).length > 0)
    {
        containerPaddingBottom = containerPaddingBottom.replace('px','');
        var containerPaddingBottomUnit="px";
    }
    else{
        containerPaddingBottom = containerPaddingBottom.replace('em','');
        containerPaddingBottom=parseInt(containerPaddingBottom)/8;
        var containerPaddingBottomUnit="em";
    }
    if ((containerPaddingRight.match("px")).length > 0)
    {
        containerPaddingRight = containerPaddingRight.replace('px','');
        var containerPaddingRightUnit="px";
    }
    else{
        containerPaddingRight = containerPaddingRight.replace('em','');
        containerPaddingRight=parseInt(containerPaddingRight)/8;
        var containerPaddingRightUnit="em";
    }
    if ((containerPaddingLeft.match("px")).length > 0)
    {
        containerPaddingLeft = containerPaddingLeft.replace('px','');
        var containerPaddingLeftUnit="px";
    }
    else{
        containerPaddingLeft = containerPaddingLeft.replace('em','');
        containerPaddingLeft=parseInt(containerPaddingLeft)/8;
        var containerPaddingLeftUnit="em";
    }
    
    
    containerPaddingTopField.val(containerPaddingTop);
    containerPaddingBottomField.val(containerPaddingBottom);
    containerPaddingRightField.val(containerPaddingRight);
    containerPaddingLeftField.val(containerPaddingLeft);
    containerCssField.val(containercss.val());
    
    if(containerBorderIsSame.val() == 1){
        containerBorderIsSameField.attr('checked',true);
    }else if (containerBorderIsSame.val() == 0){
        containerBorderIsSameField.attr('checked',false);
    }
    if(containerBorderStyleIsSame.val() == 1){
        containerBorderStyleIsSameField.attr('checked',true);
    }else if (containerBorderStyleIsSame.val() == 0){
        containerBorderStyleIsSameField.attr('checked',false);
    }
    if(containerBorderColorIsSame.val() == 1){
        containerBorderColorIsSameField.attr('checked',true);
    }else if (containerBorderColorIsSame.val() == 0){
        containerBorderColorIsSameField.attr('checked',false);
    }
    if(containerMarginIsSame.val() == 1){
        containerMarginIsSameField.attr('checked',true);
    }else if (containerMarginIsSame.val() == 0){
        containerMarginIsSameField.attr('checked',false);
    }
    if(containerPaddingIsSame.val() == 1){
        containerPaddingIsSameField.attr('checked',true);
    }else if (containerPaddingIsSame.val() == 0){
        containerPaddingIsSameField.attr('checked',false);
    }
    if($(this).parent().parent().css('font-weight')=='700'){
        containerisBoldField.attr('checked',true);
    }else{
        containerisBoldField.attr('checked',false);
    }
    if($(this).parent().parent().css('font-style')=='italic'){
        containerisItalicField.attr('checked',true);
    }else{
        containerisItalicField.attr('checked',false);
    }
    containerBorderTopUnitField.val(containerBorderTopUnit);
    containerBorderRightUnitField.val(containerBorderRightUnit);
    containerBorderLeftUnitField.val(containerBorderLeftUnit);
    containerBorderBottomUnitField.val(containerBorderBottomUnit);
    containerMarginTopUnitField.val(containerMarginTopUnit);
    containerMarginBottomUnitField.val(containerMarginBottomUnit);
    containerMarginRightUnitField.val(containerMarginRightUnit);
    containerMarginLeftUnitField.val(containerMarginLeftUnit);
    containerPaddingTopUnitField.val(containerPaddingTopUnit);
    containerPaddingBottomUnitField.val(containerPaddingBottomUnit);
    containerPaddingRightUnitField.val(containerPaddingRightUnit);
    containerPaddingLeftUnitField.val(containerPaddingLeftUnit);
    containerHeightField.val(containerHeight);
    containerWidthField.val(containerWidth);
    containerTopField.val(containerTop);
    containerLeftField.val(containerLeft);
    containerTextColorField.val(rgb2hex(containerTextColor));
    containerBgColorField.val(rgb2hex(containerBgColor));

    $dialogContent.dialog({
        modal: true,
        height: 400,
        width: 900,
        title: "Make Changes",
        close: function() {
            $dialogContent.dialog("destroy");
            $dialogContent.hide();
        },
        buttons: {
            save : function() {
             
                /*custom css*/
                containercss.val(containerCssField.val());                
                
                /*Position & Dimensions*/
                portletModal.css('height',containerHeightField.val());
                portletModal.css('width',containerWidthField.val());
                portletModal.css('top',containerTopField.val());
                portletModal.css('left',containerLeftField.val());
              
                /* border */
                if(containerBorderIsSameField.is(':checked'))
                {
                    containerBorderIsSame.val('1');
                    portletModal.css('border-width',containerBorderTopField.val()+containerBorderTopUnitField.val());
                }
                else
                {
                    containerBorderIsSame.val('0');
                    portletModal.css('border-top-width',containerBorderTopField.val()+containerBorderTopUnitField.val());
                    portletModal.css('border-right-width',containerBorderRightField.val()+containerBorderRightUnitField.val());
                    portletModal.css('border-bottom-width',containerBorderBottomField.val()+containerBorderBottomUnitField.val());
                    portletModal.css('border-left-width',containerBorderLeftField.val()+containerBorderLeftUnitField.val());
                }
                if(containerBorderStyleIsSameField.is(':checked'))
                {
                    containerBorderStyleIsSame.val('1');
                    portletModal.css('border-style',containerBorderTopStyleField.val());
                }
                else
                {
                    containerBorderStyleIsSame.val('0');
                    portletModal.css('border-top-style',containerBorderTopStyleField.val());
                    portletModal.css('border-right-style',containerBorderRightStyleField.val());
                    portletModal.css('border-left-style',containerBorderLeftStyleField.val());
                    portletModal.css('border-bottom-style',containerBorderBottomStyleField.val());
                }
                if(containerBorderColorIsSameField.is(':checked'))
                {
                    containerBorderColorIsSame.val('1');
                    portletModal.css('border-color','#'+containerBorderTopColorField.val());
                }
                else
                {
                    containerBorderColorIsSame.val('0');
                    portletModal.css('border-top-color','#'+containerBorderTopColorField.val());
                    portletModal.css('border-right-color','#'+containerBorderRightColorField.val());
                    portletModal.css('border-left-color','#'+containerBorderLeftColorField.val());
                    portletModal.css('border-bottom-color','#'+containerBorderBottomColorField.val());
                }
              
                /* margin */
                if(containerMarginIsSameField.is(':checked'))
                {
                    containerMarginIsSame.val('1');
                    portletModal.css('margin',containerMarginIsSameField.val());
                }
                else
                {
                    containerMarginIsSame.val('0');
                    portletModal.css('margin-top',containerMarginTopField.val()+containerMarginTopUnitField.val());
                    portletModal.css('margin-bottom',containerMarginBottomField.val()+containerMarginBottomUnitField.val());
                    portletModal.css('margin-right',containerMarginRightField.val()+containerMarginRightUnitField.val());
                    portletModal.css('margin-left',containerMarginLeftField.val()+containerMarginLeftUnitField.val());
                }

                /*Padding*/
                if(containerPaddingIsSameField.is(':checked'))
                {
                    containerPaddingIsSame.val('1');
                    portletModal.css('padding',containerPaddingIsSameField.val());
                }
                else
                {
                    containerPaddingIsSame.val('0');
                    portletModal.css('padding-top',containerPaddingTopField.val()+containerPaddingTopUnitField.val());
                    portletModal.css('padding-bottom',containerPaddingBottomField.val()+containerPaddingBottomUnitField.val());
                    portletModal.css('padding-right',containerPaddingRightField.val()+containerPaddingRightUnitField.val());
                    portletModal.css('padding-left',containerPaddingLeftField.val()+containerPaddingLeftUnitField.val());
                }
              
                /*Text*/
                if(containerisBoldField.is(':checked'))
                {
                      
                    portletModal.css('font-weight','bold');
                }
                else
                {
                    portletModal.css('font-weight','normal');

                }
               
                if(containerisItalicField.is(':checked'))
                {
                    portletModal.css('font-style','italic');
                }
                else
                {
                    portletModal.css('font-style','');
               
                }
                portletModal.css('font-family',containerFontField.val());
                portletModal.css('text-align',containerFontAlignmentField.val());
                portletModal.css('font-size',parseInt(containerFontSizeField.val()));
                portletModal.css('color','#'+containerFontColorField.val());
                portletModal.css('text-decoration',containerTextDecorationField.val());
                portletModal.css('word-spacing',containerWordSpacingField.val());
                portletModal.css('line-height',containerLineHeightField.val());
                portletModal.css('letter-spacing',containerLetterSpacingField.val());
              
                /*Background*/
                portletModal.css('background-color','#'+containerBgColorField.val());
                $dialogContent.dialog("close");              
            },
            cancel : function() {
                $dialogContent.dialog("close");
            }
        }
    }).show();
});

$("input.portlet-detach").live("click", function() {
    if(!$(this).data("detached")) {
        $.portal.detach(
            $(this).data("detached", true).attr({
                "title": "Attach"
            }).removeClass("ui-icon-circle-arrow-n").addClass("ui-icon-circle-arrow-s").parents(".portlet")
            );
    }
    else {
        $.portal.attach(
            $(this).data("detached", false).attr({
                "title": "Detach"
            }).removeClass("ui-icon-circle-arrow-s").addClass("ui-icon-circle-arrow-n").parents(".portlet")
            );
    }   
});