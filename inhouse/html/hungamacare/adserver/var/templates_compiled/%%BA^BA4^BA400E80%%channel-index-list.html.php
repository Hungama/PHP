<?php /* Smarty version 2.6.18, created on 2014-02-25 12:07:25
         compiled from channel-index-list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 't', 'channel-index-list.html', 19, false),array('function', 'cycle', 'channel-index-list.html', 112, false),array('function', 'ox_entity_id', 'channel-index-list.html', 121, false),array('modifier', 'count', 'channel-index-list.html', 80, false),array('modifier', 'escape', 'channel-index-list.html', 120, false),array('modifier', 'default', 'channel-index-list.html', 125, false),)), $this); ?>


<div class='tableWrapper'>
    <div class='tableHeader'>
        <ul class='tableActions'>
            <li>
            	<?php if ($this->_tpl_vars['entityUrl'] != 'affiliate-channels.php' || $this->_tpl_vars['affiliateId'] != -1): ?>
	            <a href='channel-edit.php?<?php echo $this->_tpl_vars['entityId']; ?>
' class='inlineIcon iconTargetingChannelAdd'><?php echo OA_Admin_Template::_function_t(array('str' => 'AddNewChannel'), $this);?>
</a>
                <?php else: ?>
	            <span class='inlineIcon iconTargetingChannelAddDisabled'><?php echo OA_Admin_Template::_function_t(array('str' => 'AddNewChannel'), $this);?>
</span>
                <?php endif; ?>
            </li>
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
<?php echo OA_Admin_Template::_function_t(array('str' => 'ConfirmDeleteChannels'), $this);?>
<?php echo '")) {
							window.location = \'channel-delete.php?'; ?>
<?php echo $this->_tpl_vars['entityId']; ?>
<?php echo '&channelid=\' + ids.join(\',\');
						}
					}
                });

                //-->
                </script>
                '; ?>

            </li>
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
                <th>
                    <?php echo OA_Admin_Template::_function_t(array('str' => 'Name'), $this);?>

                </th>
                <?php if ($this->_tpl_vars['entityUrl'] != 'affiliate-channels.php'): ?>
                <th>
                    <?php echo OA_Admin_Template::_function_t(array('str' => 'Owner'), $this);?>

                </th>
                <?php endif; ?>
                <th>
                    <?php echo OA_Admin_Template::_function_t(array('str' => 'Description'), $this);?>

                </th>
                <th class='last alignRight'>&nbsp;

                </th>
            </tr>
        </thead>

<?php if (! count($this->_tpl_vars['from'])): ?>
        <tbody>
            <tr class='odd'>
                <td colspan='<?php if ($this->_tpl_vars['entityUrl'] != 'affiliate-channels.php'): ?>5<?php else: ?>4<?php endif; ?>'>&nbsp;</td>
            </tr>
            <tr class='even'>
                <td colspan='<?php if ($this->_tpl_vars['entityUrl'] != 'affiliate-channels.php'): ?>5<?php else: ?>4<?php endif; ?>' class="hasPanel">
                    <div class='tableMessage'>
                        <div class='panel'>
                            <?php if ($this->_tpl_vars['entityUrl'] != 'affiliate-channels.php' || $this->_tpl_vars['affiliateId'] != -1): ?>
                                <?php echo OA_Admin_Template::_function_t(array('str' => 'NoChannels'), $this);?>

                            <?php else: ?>
                                <?php echo OA_Admin_Template::_function_t(array('str' => 'NoChannelsAddWebsite'), $this);?>

                            <?php endif; ?>

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
                <td colspan='<?php if ($this->_tpl_vars['entityUrl'] != 'affiliate-channels.php'): ?>5<?php else: ?>4<?php endif; ?>'>&nbsp;</td>
            </tr>
        </tbody>

<?php else: ?>
        <tbody>
    <?php echo smarty_function_cycle(array('name' => 'bgcolor','values' => "even,odd",'assign' => 'bgColor','reset' => 1), $this);?>

    <?php $_from = $this->_tpl_vars['from']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['channelId'] => $this->_tpl_vars['channel']):
?>
        <?php echo smarty_function_cycle(array('name' => 'bgcolor','assign' => 'bgColor'), $this);?>

            <tr class='<?php echo $this->_tpl_vars['bgColor']; ?>
'>
              <td class='toggleSelection'>
                  <input type='checkbox' value='<?php echo $this->_tpl_vars['channelId']; ?>
' />
                </td>
                <td>
                    <a href='channel-edit.php?<?php echo $this->_tpl_vars['entityId']; ?>
&channelid=<?php echo $this->_tpl_vars['channelId']; ?>
' class='inlineIcon iconTargetingChannel'><?php echo ((is_array($_tmp=$this->_tpl_vars['channel']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a>
                    <?php echo OA_Admin_Template::_function_ox_entity_id(array('type' => 'Channel','id' => $this->_tpl_vars['channelId']), $this);?>

                </td>
                <?php if ($this->_tpl_vars['entityUrl'] != 'affiliate-channels.php'): ?>
                <td>
                  <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['channel']['owner'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')))) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>

                </td>
                <?php endif; ?>
                <td>
                  <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['channel']['description'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')))) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>

                </td>
                <td class='alignRight'>
                    <ul class='rowActions'>
                        <li>
                            <a href='channel-acl.php?<?php echo $this->_tpl_vars['entityId']; ?>
&channelid=<?php echo $this->_tpl_vars['channelId']; ?>
' class='inlineIcon iconTargetingChannelAcl'><?php echo OA_Admin_Template::_function_t(array('str' => 'EditChannelLimitations'), $this);?>
</a>
                        </li>
                    </ul>
                </td>
            </tr>
    <?php endforeach; endif; unset($_from); ?>
       </tbody>
<?php endif; ?>
    </table>
</div>