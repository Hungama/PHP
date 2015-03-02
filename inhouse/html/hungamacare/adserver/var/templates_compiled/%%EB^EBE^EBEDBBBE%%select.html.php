<?php /* Smarty version 2.6.18, created on 2014-03-05 10:35:21
         compiled from options/select.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'options/select.html', 3, false),array('function', 'html_options', 'options/select.html', 18, false),)), $this); ?>
<?php if ($this->_tpl_vars['aItem']['items']): ?>
    <tr><td>&nbsp;</td>
        <td id='cell_<?php echo $this->_tpl_vars['aItem']['name']; ?>
' class='<?php if ($this->_tpl_vars['aItem']['disabled']): ?>celldisabled<?php else: ?>cellenabled<?php endif; ?>'><?php echo ((is_array($_tmp=$this->_tpl_vars['aItem']['text'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

        <?php if ($this->_tpl_vars['aItem']['req']): ?><span class="required">*</span><?php endif; ?>
        </td>
        <td width='100%'>
            <select name='<?php echo $this->_tpl_vars['aItem']['name']; ?>
' id='<?php echo $this->_tpl_vars['aItem']['name']; ?>
'
		    <?php if ($this->_tpl_vars['aItem']['reload'] == 'yes'): ?>
		         onChange="this.form.field_changed.value=name;this.form.submit();phpAds_refreshEnabled();"
		    <?php else: ?>
                onChange="phpAds_refreshEnabled();
		        <?php if (isset ( $this->_tpl_vars['aItem']['onchange'] )): ?>
		          <?php echo $this->_tpl_vars['aItem']['onchange']; ?>

		        <?php endif; ?>
		        "
            <?php endif; ?>
            <?php if ($this->_tpl_vars['aItem']['disabled']): ?> disabled='disabled'<?php endif; ?> tabindex='<?php echo $this->_tpl_vars['aItem']['tabindex']++; ?>
'>
            <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['aItem']['items'],'selected' => $this->_tpl_vars['aItem']['value']), $this);?>

            </select>
		    <?php if ($this->_tpl_vars['aItem']['showSubmitButton']): ?>
		        &nbsp;<a href="javascript:void(0)" onClick="document.forms['settingsform'].submit();"><img src="<?php echo ((is_array($_tmp=$this->_tpl_vars['assetPath'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
/images/ltr/go_blue.gif" border="0"></a>
		    <?php endif; ?>
        </td>
        <td><?php echo $this->_tpl_vars['this']->_showPadLock($this->_tpl_vars['aItem']); ?>
</td>
    </tr>
<?php endif; ?>