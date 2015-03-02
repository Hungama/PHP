<?php /* Smarty version 2.6.18, created on 2014-02-25 13:08:31
         compiled from advertiser-trackers-list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 't', 'advertiser-trackers-list.html', 19, false),array('function', 'ox_column_class', 'advertiser-trackers-list.html', 63, false),array('function', 'ox_column_title', 'advertiser-trackers-list.html', 64, false),array('function', 'cycle', 'advertiser-trackers-list.html', 103, false),array('function', 'ox_tracker_type', 'advertiser-trackers-list.html', 118, false),array('modifier', 'count', 'advertiser-trackers-list.html', 75, false),array('modifier', 'escape', 'advertiser-trackers-list.html', 112, false),)), $this); ?>


<div class='tableWrapper'>
    <div class='tableHeader'>
        <ul class='tableActions'>
        	<?php if ($this->_tpl_vars['canAdd']): ?>
            <li>
                <a href='tracker-edit.php?clientid=<?php echo $this->_tpl_vars['clientId']; ?>
' class='inlineIcon iconTrackerAdd'><?php echo OA_Admin_Template::_function_t(array('str' => 'AddTracker'), $this);?>
</a>
            </li>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['canDelete']): ?>
            <li class='inactive activeIfSelected'>
                <a id='deleteSelection' href='#' class='inlineIcon iconDelete'><?php echo OA_Admin_Template::_function_t(array('str' => 'Delete'), $this);?>
</a>
                
                <?php echo '
                <script type=\'text/javascript\'>
                <!--
                
                $(\'#deleteSelection\').click(function(event) {
					event.preventDefault();
					
					if (!$(this).parents(\'li\').hasClass(\'inactive\')) {
						var ids = [];
						$(this).parents(\'.tableWrapper\').find(\'.toggleSelection input:checked\').each(function() {
							ids.push(this.value);
						});
						
						if (!tablePreferences.warningBeforeDelete || confirm("'; ?>
<?php echo OA_Admin_Template::_function_t(array('str' => 'ConfirmDeleteTrackers'), $this);?>
<?php echo '")) {
							window.location = \'tracker-delete.php?clientid='; ?>
<?php echo $this->_tpl_vars['clientId']; ?>
<?php echo '&trackerid=\' + ids.join(\',\');
						}
					}
                });
                
                //-->
                </script>
                '; ?>

            </li>
            <?php endif; ?>
        </ul>
        
        <div class='clear'></div>
        <div class='corner left'></div>
        <div class='corner right'></div>
    </div>

    <table cellspacing='0' summary=''>
        <thead>
            <tr>
                <th class='first toggleAll'>
                    <input type='checkbox' />
                </th>
                <th class='<?php echo OA_Admin_Template::_function_ox_column_class(array('item' => 'name','order' => 'up','default' => 1), $this);?>
'>
                    <?php echo OA_Admin_Template::_function_ox_column_title(array('item' => 'name','order' => 'up','default' => 1,'str' => 'Name','url' => $this->_tpl_vars['url']), $this);?>

                </th>
                <th>
                	<?php echo OA_Admin_Template::_function_t(array('str' => 'ConversionType'), $this);?>

                </th>
                <th class='last'>
                	&nbsp;
                </th>
            </tr>
        </thead>

<?php if (! count($this->_tpl_vars['from'])): ?>
        <tbody>
            <tr class='odd'>
                <td colspan='4'>&nbsp;</td>
            </tr>
            <tr class='even'>
                <td colspan='4'>
                    <div class='tableMessage'>
                        <div class='panel'>
                            <?php echo OA_Admin_Template::_function_t(array('str' => 'NoTrackers'), $this);?>


                            <div class='corner top-left'></div>
                            <div class='corner top-right'></div>
                            <div class='corner bottom-left'></div>
                            <div class='corner bottom-right'></div>
                        </div>
                    </div>
                    
                    &nbsp;
                </td>
            </tr>
            <tr class='odd'>
                <td colspan='4'>&nbsp;</td>
            </tr>
        </tbody>
        
<?php else: ?>
        <tbody>
    <?php echo smarty_function_cycle(array('name' => 'bgcolor','values' => "even,odd",'assign' => 'bgColor','reset' => 1), $this);?>

    <?php $_from = $this->_tpl_vars['from']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['trackerId'] => $this->_tpl_vars['tracker']):
?>
        <?php echo smarty_function_cycle(array('name' => 'bgcolor','assign' => 'bgColor'), $this);?>

            <tr class='<?php echo $this->_tpl_vars['bgColor']; ?>
'>
                <td class='toggleSelection'>
                    <input type='checkbox' value='<?php echo $this->_tpl_vars['trackerId']; ?>
' />
                </td>
                <td>
                    <?php if ($this->_tpl_vars['canEdit']): ?>
                    <a href='tracker-edit.php?clientid=<?php echo $this->_tpl_vars['clientId']; ?>
&trackerid=<?php echo $this->_tpl_vars['trackerId']; ?>
' class='inlineIcon iconTracker'><?php echo ((is_array($_tmp=$this->_tpl_vars['tracker']['trackername'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a>
                    <?php else: ?>
                    <span class='inlineIcon iconTracker'><?php echo ((is_array($_tmp=$this->_tpl_vars['tracker']['trackername'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</span>
                    <?php endif; ?>
                </td>
                <td>
					<?php echo OA_Admin_Template::_function_ox_tracker_type(array('type' => $this->_tpl_vars['tracker']['type']), $this);?>

                </td>
                <td class='alignRight'>
                    <ul class='rowActions'>
                    	<?php if ($this->_tpl_vars['canLink']): ?>
                        <li>
                            <a href='tracker-campaigns.php?clientid=<?php echo $this->_tpl_vars['clientId']; ?>
&trackerid=<?php echo $this->_tpl_vars['trackerId']; ?>
' class='inlineIcon iconTrackerLink'><?php echo OA_Admin_Template::_function_t(array('str' => 'LinkedCampaigns'), $this);?>
</a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </td>
            </tr>
    <?php endforeach; endif; unset($_from); ?>
       </tbody>
<?php endif; ?>
    </table>
</div>