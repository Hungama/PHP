<?php /* Smarty version 2.6.18, created on 2014-12-10 15:55:06
         compiled from userlog-index.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'userlog-index.html', 5, false),array('function', 't', 'userlog-index.html', 8, false),array('function', 'html_options', 'userlog-index.html', 15, false),array('function', 'cycle', 'userlog-index.html', 80, false),)), $this); ?>
<form id="auditForm" name="auditForm" method="POST">
<input type='hidden' name='listorder' value='<?php echo $this->_tpl_vars['listorder']; ?>
'>
<input type='hidden' name='orderdirection' value='<?php echo $this->_tpl_vars['orderdirection']; ?>
'>
<input type='hidden' name='origAdvertiserId' value='<?php echo $this->_tpl_vars['advertiserId']; ?>
'>
<input type='hidden' name='origPublisherId' value='<?php echo ((is_array($_tmp=$this->_tpl_vars['publisherId'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
'>

<fieldset id="auditFilter">
    <legend><?php echo OA_Admin_Template::_function_t(array('str' => 'Filters'), $this);?>
</legend>

    <?php if ($this->_tpl_vars['showAdvertisers']): ?>
	<div class="filterWrapper">
	    <label class="filterLabel" for="advertiserId"><?php echo OA_Admin_Template::_function_t(array('str' => 'Advertiser'), $this);?>
</label>
	    <span>
	        <select style="width:25%" id="advertiserId" name="advertiserId" onchange="submitForm();">
	            <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['aAdvertiser'],'selected' => $this->_tpl_vars['advertiserId']), $this);?>

	        </select>
	        <?php if (count ( $this->_tpl_vars['aCampaign'] ) > 0): ?>
	        <select style="width:25%" id="campaignId" name="campaignId" onchange="submitForm();">
	            <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['aCampaign'],'selected' => $this->_tpl_vars['campaignId']), $this);?>

	        </select>
            <?php endif; ?>
	    </span>
	</div>
   <?php endif; ?>
	
    <?php if ($this->_tpl_vars['showPublishers']): ?>
	<div class="filterWrapper">
	    <label class="filterLabel" for="publisherId"><?php echo OA_Admin_Template::_function_t(array('str' => 'Publisher'), $this);?>
</label>
	    <span>
	        <select style="width:25%" id="publisherId" name="publisherId" onchange="submitForm();">
	            <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['aPublisher'],'selected' => $this->_tpl_vars['publisherId']), $this);?>

	        </select>
	        <?php if (count ( $this->_tpl_vars['aZone'] ) > 0): ?>
	        <select style="width:25%" id="zoneId" name="zoneId" onchange="submitForm();">
	            <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['aZone'],'selected' => $this->_tpl_vars['zoneId']), $this);?>

	        </select>
	        <?php endif; ?>
	    </span>
	</div>
	<?php endif; ?>
	
	<div class="filterWrapper">
	    <span class="filterLabel"><?php echo OA_Admin_Template::_function_t(array('str' => 'Date'), $this);?>
</span>
	    <?php echo $this->_tpl_vars['daySpan']->display(); ?>

	       <a href='#' onclick='return periodFormSubmit()'>
	           <img src='<?php echo ((is_array($_tmp=$this->_tpl_vars['assetPath'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
/images/ltr/go_blue.gif' border='0' tabindex='6' />
	       </a>
    </div>
    <div>
        <input type="button" value="<?php echo OA_Admin_Template::_function_t(array('str' => 'Clear'), $this);?>
" onclick="resetFilter();" />
    </div>
</fieldset>

<?php if (! $this->_tpl_vars['aAuditEnabled']): ?>
	<div class='errormessage'><img class='errormessage' src='<?php echo ((is_array($_tmp=$this->_tpl_vars['assetPath'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
/images/info.gif' width='16' height='16' border='0' align='absmiddle'>
	    <?php echo OA_Admin_Template::_function_t(array('str' => 'AuditTrailDisabled'), $this);?>
 
	</div>
<?php endif; ?>
    


<div>
    <table class="data-grid table">
        <tbody>
            <tr class="header">
                <th width="15%"><a href="userlog-index.php?<?php echo $this->_tpl_vars['urlParam']; ?>
"><?php echo OA_Admin_Template::_function_t(array('str' => 'Timestamp'), $this);?>
</a>
                    <a href="userlog-index.php?<?php echo $this->_tpl_vars['urlParam']; ?>
">
                        <?php if ($this->_tpl_vars['orderdirection'] == 'up'): ?>
                        <img src="<?php echo ((is_array($_tmp=$this->_tpl_vars['assetPath'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
/images/caret-u.gif" />
                        <?php else: ?>
                        <img src="<?php echo ((is_array($_tmp=$this->_tpl_vars['assetPath'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
/images/caret-ds.gif" />
                        <?php endif; ?>
                    </a>
                </th>
                <th><?php echo OA_Admin_Template::_function_t(array('str' => 'Event'), $this);?>
</th>
                <th width="10%">&nbsp;</th>
            </tr>
            <?php if (count ( $this->_tpl_vars['aAuditData'] ) > 0): ?>
            <?php $_from = $this->_tpl_vars['aAuditData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['info'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['info']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['aValue']):
        $this->_foreach['info']['iteration']++;
?>
            <?php echo smarty_function_cycle(array('values' => 'odd,even','assign' => 'rowClass'), $this);?>

            <tr class="<?php echo $this->_tpl_vars['rowClass']; ?>
">
                <td><?php echo $this->_tpl_vars['aValue']['updated']; ?>
</td>
                <td>
                    <?php echo ((is_array($_tmp=$this->_tpl_vars['aValue']['username'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 <?php echo OA_Admin_Template::_function_t(array('str' => $this->_tpl_vars['aValue']['action']), $this);?>
 <?php echo $this->_tpl_vars['aValue']['contextDescription']; ?>
 "<?php echo ((is_array($_tmp=$this->_tpl_vars['aValue']['details']['key_desc'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" <?php if (! empty ( $this->_tpl_vars['aValue']['contextid'] )): ?>(#<?php echo $this->_tpl_vars['aValue']['contextid']; ?>
)<?php endif; ?>
                    <?php if (! empty ( $this->_tpl_vars['aValue']['parentcontext'] )): ?>
                        in <?php echo $this->_tpl_vars['aValue']['parentcontext']; ?>
 (#<?php echo $this->_tpl_vars['aValue']['parentcontextid']; ?>
)
                    <?php endif; ?>
                    <?php if (! empty ( $this->_tpl_vars['aValue']['hasChildren'] )): ?>
                        <?php echo OA_Admin_Template::_function_t(array('str' => 'AdditionalItems'), $this);?>

                    <?php endif; ?>
                </td>
                <td><img src="<?php echo ((is_array($_tmp=$this->_tpl_vars['assetPath'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
/images/icon-zoom.gif" />&nbsp;<a href="userlog-audit-detailed.php?auditId=<?php echo $this->_tpl_vars['aValue']['auditid']; ?>
"><?php echo OA_Admin_Template::_function_t(array('str' => 'View'), $this);?>
</a></td>
            </tr>
            <?php endforeach; endif; unset($_from); ?>
            <?php else: ?>
            <tr class="<?php echo $this->_tpl_vars['rowClass']; ?>
">
                <td colspan="3">
                    <?php echo OA_Admin_Template::_function_t(array('str' => 'AuditResultsNotFound'), $this);?>

                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<div class="filters">
    <?php echo OA_Admin_Template::_function_t(array('str' => 'ItemsPerPage'), $this);?>
: <?php echo $this->_tpl_vars['pager']->pagerSelect; ?>
&nbsp;<?php if (! empty ( $this->_tpl_vars['pager']->links )): ?><?php echo $this->_tpl_vars['pager']->links; ?>
<?php endif; ?>
</div>
</form>
<?php echo '
<script type=\'text/javascript\'>
<!--
    function submitForm() {
        var form = document.getElementById(\'auditForm\');
        var url  = \'userlog-index.php\';
        var aUrl = [];

        if (form.advertiserId && form.advertiserId.options[form.advertiserId.selectedIndex].value != \'\') {
	        var advertiserId = form.advertiserId.options[form.advertiserId.selectedIndex].value;
	        aUrl.push(\'advertiserId=\' + advertiserId);
	        if (form.origAdvertiserId.value == advertiserId && form.elements[\'campaignId\'] && form.campaignId.disabled == false) {
	            var campaignId = form.campaignId.options[form.campaignId.selectedIndex].value;
	            aUrl.push(\'campaignId=\' + campaignId);
	        }
	    }
        if (form.publisherId && form.publisherId.options[form.publisherId.selectedIndex].value != \'\') {
            var publisherId = form.publisherId.options[form.publisherId.selectedIndex].value;
            aUrl.push(\'publisherId=\' + publisherId);
	        if (form.origPublisherId.value == publisherId && form.elements[\'zoneId\'] && form.zoneId.disabled == false) {
	            var zoneId = form.zoneId.options[form.zoneId.selectedIndex].value;
	            aUrl.push(\'zoneId=\' + zoneId);
	        }
        }

        if (form.period_preset.options[form.period_preset.selectedIndex].value != \'\'
            && form.elements[\'period_start\'] && form.elements[\'period_end\'])
        {
            var periodPreset = form.period_preset.options[form.period_preset.selectedIndex].value;
            var periodStart  = form.period_start.value;
            var periodEnd    = form.period_end.value;

            aUrl.push(\'period_preset=\' + periodPreset);
            aUrl.push(\'period_start=\' + periodStart);
            aUrl.push(\'period_end=\' + periodEnd);
        }
        var setPerPage = form.setPerPage.options[form.setPerPage.selectedIndex].value;
        aUrl.push(\'setPerPage=\' + setPerPage);

        var params = aUrl.join(\'&\');
        if (aUrl.length > 0) {
            url = url + \'?\' + params;
        }
        document.location.href = url;
        return false;
    }

    function toggleForm() {
        var form = document.getElementById(\'auditForm\');

        if (form.publisherId && form.advertiserId && form.advertiserId.options[form.advertiserId.selectedIndex].value > 0) {
            //  disable publisher widget
            form.publisherId.disabled = true;
        } else if (form.advertiserId && form.publisherId && form.publisherId.options[form.publisherId.selectedIndex].value > 0) {
            // disable advertiser widget
            form.advertiserId.disabled = true;
        }

        return false;
    }

    function resetFilter() {
        var form = document.getElementById(\'auditForm\');
        //  reset advertiser filter
        if (form.advertiserId && form.advertiserId.options[form.advertiserId.selectedIndex].value != \'\') {
            form.advertiserId.selectedIndex = 0;
            if (form.elements[\'campaignId\'] && form.campaignId.disabled == false) {
                form.campaignId.selectedIndex = 0;
            }
        }
        //  reset website filter
        if (form.publisherId && form.publisherId.options[form.publisherId.selectedIndex].value != \'\') {
            form.publisherId.selectedIndex = 0;
            if (form.elements[\'zoneId\'] && form.zoneId.disabled == false) {
                form.zoneId.selectedIndex = 0;
            }
        }
        //  reset date filter
        form.period_preset.selectedIndex = 0;
        form.period_start.value = \'\';
        form.period_end.value   = \'\';

        submitForm();
    }

    toggleForm();
//-->
</script>
'; ?>
