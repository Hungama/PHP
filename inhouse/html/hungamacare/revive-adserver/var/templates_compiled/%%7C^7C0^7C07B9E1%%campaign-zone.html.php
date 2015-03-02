<?php /* Smarty version 2.6.18, created on 2014-12-10 14:59:51
         compiled from campaign-zone.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'view_before_content', 'campaign-zone.html', 12, false),array('function', 't', 'campaign-zone.html', 21, false),array('function', 'view_after_content', 'campaign-zone.html', 342, false),)), $this); ?>
<?php echo $this->_plugins['function']['view_before_content'][0][0]->beforeContent(array(), $this);?>


<form id="zoneLinkingForm">
<div id="campaign-zone" class="new-form">
  <input id="advertiser-id" type="hidden" value="<?php echo $this->_tpl_vars['advertiserId']; ?>
" />
  <input id="campaign-id" type="hidden" value="<?php echo $this->_tpl_vars['campaignId']; ?>
" />

  <div id="filters">
    <div id="filters-available">
      <h3 class="filter-panel-title"><?php echo OA_Admin_Template::_function_t(array('str' => 'AvailableZones'), $this);?>
</h3>
      <div class="filter-panel">
	      <div class="bg-left"></div>
	      <div class="bg-right"></div>

	      <div class="filter-content">
          <div id="status-available">&nbsp;</div>
	        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "campaign-zone-panel-filters.html", 'smarty_include_vars' => array('panelId' => 'available','categories' => $this->_tpl_vars['aCategories'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	      </div>
	      &nbsp;
	    </div>
    </div>

    <div id="filters-linked">
      <h3 class="filter-panel-title"><?php echo OA_Admin_Template::_function_t(array('str' => 'LinkedZones'), $this);?>
</h3>
      <div class="filter-panel">
        <div class="bg-left"></div>
        <div class="bg-right"></div>

        <div class="filter-content">
          <div id="status-linked">&nbsp;</div>
	        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "campaign-zone-panel-filters.html", 'smarty_include_vars' => array('panelId' => 'linked','categories' => $this->_tpl_vars['aCategories'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	      </div>
	    </div>
    </div>
  </div>

  &nbsp;

  <div id="select-zones">
    <div id="available">
      <div class="zones-container new-table-container">
        <div id="zones-available-loading" class="ajax-loading panel-loading hide"></div>
        <div id="zones-available-container">
          <table id="zones-available" class="zones new-table">
            <tbody>
              <tr class="header hide">
                <th class="name"><label><input type="checkbox" id="available-select-all" class="checkbox select-all" /> <?php echo OA_Admin_Template::_function_t(array('str' => 'SelectUnselectAll'), $this);?>
</label></th>
                <th class="link"></th>
                <th class="ctr"><?php echo OA_Admin_Template::_function_t(array('str' => 'FinanceCTR'), $this);?>
</th>
                <th class="cr"><?php echo OA_Admin_Template::_function_t(array('str' => 'FinanceCR'), $this);?>
</th>
                <th class="ecpm last"><?php echo OA_Admin_Template::_function_t(array('str' => 'FinanceCPM'), $this);?>
</th>
              </tr>
            </tbody>

            <tbody id="zones-available-rows">
              <tr class="hide"><td></td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div id="linked">
      <div class="zones-container new-table-container">
        <div id="zones-linked-loading" class="ajax-loading panel-loading hide"></div>
        <div id="zones-linked-container">
          <table id="zones-linked" class="zones new-table">
            <tbody>
              <tr class="header hide">
                <th class="name"><label><input type="checkbox" id="linked-select-all" class="checkbox select-all" /> <?php echo OA_Admin_Template::_function_t(array('str' => 'SelectUnselectAll'), $this);?>
</label></th>
                <th class="link"></th>
                <th class="ctr"><?php echo OA_Admin_Template::_function_t(array('str' => 'FinanceCTR'), $this);?>
</th>
                <th class="cr"><?php echo OA_Admin_Template::_function_t(array('str' => 'FinanceCR'), $this);?>
</th>
                <th class="ecpm last"><?php echo OA_Admin_Template::_function_t(array('str' => 'FinanceCPM'), $this);?>
</th>
              </tr>
            </tbody>

            <tbody id="zones-linked-rows">
              <tr class="hide"><td></td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div id="linking-buttons">
      <button accesskey="l" id="link-button" class="flat button" type="button" ><u>L</u>ink <span class="arrow-right"></span></button><br />
      <button accesskey="u" id="unlink-button" class="flat button" type="button"><span class="arrow-left"></span> <u>U</u>nlink</button>

      <div style="margin-top: 2ex; text-align: center">
        <span id="linking-indicator" class="ajax-loading-big hide"></span>
        <span id="linking-status"></span>
        <span id="error-indicator" class="ajax-error hide"><?php echo OA_Admin_Template::_function_t(array('str' => 'LinkingNotSuccess'), $this);?>
</span>
      </div>
    </div>
  </div>

  <div class="accurate-info"><div class="accurate-box"></div><?php echo OA_Admin_Template::_function_t(array('str' => 'CalculatedForThisCampaign'), $this);?>
</div>
  <div class="estim-info"><div class="estim-box"></div><?php echo OA_Admin_Template::_function_t(array('str' => 'CalculatedForAllCampaigns'), $this);?>
</div>

	<script type="text/javascript"><!--
<?php echo '
  $(document).ready(function() {
    // Multicheckbox selections, selection by row clicks
    $("#zones-available-container, #zones-linked-container").multicheckboxes({
      toSelectClass: "to-link",
      toUselectClass: "",
      selectAllSelector: ".select-all",
      updateElement: "tr"
    });

    addMultiselectListeners("available");
    addMultiselectListeners("linked");

    $("#zones-linked-container, #zones-available-container").bind("filter", function() {
      var panel = this.id.substring("zones-".length).replace(/-container/, \'\');
      var $quickSearch = $("#quick-search-" + panel);
      var postData = {
        "clientid": $("#advertiser-id").val(),
        "campaignid": $("#campaign-id").val(),
        "status": panel,
        "text": $quickSearch.is(".example-search") ? "" : $quickSearch.val()
      };

      sendZonesRequest(panel, "campaign-zone-zones.php", postData);
    });

    // Link/Unlink buttons
    $("#link-button").bind("click", [ "link" ], sendLinkingRequest);
    $("#unlink-button").bind("click", [ "unlink" ], sendLinkingRequest);

    // Quick search fields
    $("#quick-search-available, #quick-search-linked")
      .example("zone name, website name", { class_name: \'example-search\'})
      .typeWatch({
        callback: function() {
          var panelId = this.el.id.substring("quick-search-".length);
          $("#zones-" + panelId + \'-container\').trigger("filter");
        },
        wait: 500,
        captureLength: 1
      });

    $("#zones-available-container, #zones-linked-container").trigger("filter").trigger("multichange");
  });

  function sendZonesRequest(panel, url, params) {
    $.ajax({
      url: url,
      type: "GET",
      data: params,
      cache: false,
      complete: function() {
        $("#zones-" + panel + "-loading").hide();
      },
      success: function(data) {
        if (!checkReload(data)) {
          updatePanel(data, panel);
        }
      },
      error: function() {
        $("#error-indicator").show();
      }
    });
    $("#error-indicator").hide();
    $("#zones-" + panel + "-loading").show();
  }

  // Performs linking/unlinking and refreshes panels on completion
  function sendLinkingRequest(event) {
    var action = event.data[0];

    $("#link-button, #unlink-button").attr("disabled", true);

    var $checkboxContainer;
    if (action == "link") {
      $checkboxContainer = $("#zones-available");
    } else {
      $checkboxContainer = $("#zones-linked");
    }

    var checkedNames = $.map($checkboxContainer.find(":checked").not(".select-all"), function(val) {
      return val.name;
    });

    // Data from all filters
    var quickSearchLinked = $("#quick-search-linked").is(".example-search") ? "" : $("#quick-search-linked").val();
    var quickSearchAvailable = $("#quick-search-available").is(".example-search") ? "" : $("#quick-search-available").val();
    if (action == "link") {
        if (quickSearchLinked  != "" && quickSearchLinked != quickSearchAvailable) {
           quickSearchLinked = "";
           $("#quick-search-linked").val("");
        }
    }
    else {
      if (quickSearchAvailable  != "" && quickSearchLinked != quickSearchAvailable) {
         quickSearchAvailable = "";
         $("#quick-search-available").val("");
      }
    }

    var postData = {
      "clientid": $("#advertiser-id").val(),
      "campaignid": $("#campaign-id").val(),
      "text-linked": quickSearchLinked,
      "text-available": quickSearchAvailable,
      "action": action,
      "ids[]": checkedNames,
      "allSelected": $checkboxContainer.data("allSelected"),
      "page-linked": $("#page-linked").text(),
      "page-available": $("#page-available").text()
    };

    $.ajax({
      url: "campaign-zone-link.php",
      type: "POST",
      data: postData,
      cache: false,
      complete: function() {
        $(".select-all").attr("checked", false);
        $("#linking-indicator").hide();
      },
      success: function(data) {
        if (!checkReload(data)) {
          updatePanel(data, "available");
          updatePanel(data, "linked");

	        $("#linking-status").html(extractPart(data, "info", "result")).stop().show().css("opacity", "1");
	        if (window.linkingTimout) {
	          window.linkingTimout.clearTimeout();
	        }
	        window.linkingTimeout = window.setTimeout(function() {
	          $("#zones-available").find("tr.just-linked").removeClass("just-linked", $("#zones-available-rows tr").size() <= 100 ? 5000 : 0);
	          $("#zones-linked").find("tr.just-linked").removeClass("just-linked",  $("#zones-linked-rows tr").size() <= 100 ? 5000 : 0);
	          $("#linking-status").fadeOut(5000);
	        }, 2000);
	      }

'; ?>
<?php if ($this->_tpl_vars['runMPE']): ?>
	      // Run MPE
	      $.get('run-mpe.php');
<?php endif; ?><?php echo '

      },
      error: function() {
        $("#error-indicator").show();
      }
    });

    $("#error-indicator").hide();
    $("#linking-indicator").show();
    $("#linking-status").hide();
  }

  function updatePanel(data, panel) {
    var panelRows = extractPart(data, panel, "rows");
    $("#zones-" + panel + "-container").get(0).innerHTML = panelRows;
    $("#zones-" + panel + " tr.header").visible(!$("#zones-" + panel + "-rows tr:eq(0)").is(".empty"));
    var panelStatus = extractPart(data, panel, "status");
    $("#status-" + panel).html(panelStatus);
    $("#zones-" + panel + "-container").trigger(\'dataUpdate\');
    $("#zones-" + panel + "-container a.page").click(function() {
      sendZonesRequest(panel, this.href, {})
      return false;
    });

    if ($("#page-" + panel).size() > 0) {
      $("#zones-" + panel + "-loading").addClass("has-paging");
    } else {
      $("#zones-" + panel + "-loading").removeClass("has-paging");
    }
    addSelectAllListeners(panel);
  }

  function addMultiselectListeners(panel) {
    $("#zones-" + panel + "-container").bind("multichange", function() {
      var $selectAll = $("#zones-" + panel + " .select-all");
      var selectAllChecked = $selectAll.size() > 0 && $selectAll.is(":checked");
      $("#zones-" + panel + "-select-all, #select-all-container-" + panel).setElementVisible(selectAllChecked);
      if (!selectAllChecked) {
        cancelAllZonesSelection(panel);
      }

      $("#" + (panel == "available" ? "link" : "unlink") + "-button")
        .attr("disabled", $("#zones-" + panel + " :checked").not(".select-all").size() == 0);
    });
  }

  function addSelectAllListeners(panel) {
    $("#zones-" + panel + "-select-all a").click(function() {
      $("#zones-" + panel + "-select-all").hide();
      $("#zones-" + panel + "-all-selected").show();
      $("#zones-" + panel).data("allSelected", true);
      return false;
    });
    $("#zones-" + panel + "-all-selected a").click(function() {
      cancelAllZonesSelection(panel);
      $("#zones-" + panel + " :checkbox").attr("checked", false);
      $("#zones-" + panel + "-rows tr").removeClass("to-link");
      return false;
    });
  }

  function cancelAllZonesSelection(panel) {
    $("#select-all-container-" + panel).hide();
    $("#zones-" + panel + "-select-all").hide();
    $("#zones-" + panel + "-all-selected").hide();
    $("#zones-" + panel).data("allSelected", false);
  }

  function checkReload(data) {
    if (data.indexOf("<!-- install -->") >= 0 || data.indexOf("<!-- login -->") >= 0) {
      document.location.reload();
      return true;
    }
    return false;
  }

  function extractPart(data, status, part) {
    var startMarker = "<!--" + part + "-" + status + "-start-->";
    var endMarker = "<!--" + part + "-" + status + "-end-->";
    return data.substring(data.indexOf(startMarker) + startMarker.length, data.indexOf(endMarker));
  }
'; ?>

  //--></script>

</div>
</form>
<?php echo $this->_plugins['function']['view_after_content'][0][0]->afterContent(array(), $this);?>