<?php /* Smarty version 2.6.18, created on 2015-01-11 12:01:52
         compiled from options/url.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'options/url.html', 17, false),)), $this); ?>
<tr><td>&nbsp;</td>
    <td id='cell_<?php echo $this->_tpl_vars['aItem']['name']; ?>
' class='<?php if ($this->_tpl_vars['aItem']['disabled']): ?>celldisabled<?php else: ?>cellenabled<?php endif; ?>' valign='top'><?php echo $this->_tpl_vars['aItem']['text']; ?>
</td>
    <td width='100%' valign='top'>
        <table>
            <tr>
                <td width='60' align='right' nowrap>
			    <?php if ($this->_tpl_vars['aItem']['type'] == 'n'): ?>
			        http://
			    <?php elseif ($this->_tpl_vars['aItem']['type'] == 's'): ?>
			        https://
			    <?php else: ?>
			        http(s)://
			    <?php endif; ?>
                </td>
                <td>
                    <input onBlur='phpAds_refreshEnabled(); max_formValidateElement(this);' class='flat' type='text' name='<?php echo $this->_tpl_vars['aItem']['name']; ?>
' id='<?php echo $this->_tpl_vars['aItem']['name']; ?>
' <?php if ($this->_tpl_vars['aItem']['disabled']): ?>disabled='disabled'<?php endif; ?>
                            size='<?php echo $this->_tpl_vars['aItem']['size']; ?>
' value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aItem']['value'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" tabindex='<?php echo $this->_tpl_vars['aItem']['tabindex']++; ?>
'>
                </td>
           </tr>
       </table>
    </td>
    <td><?php echo $this->_tpl_vars['this']->_showPadLock($this->_tpl_vars['aItem']); ?>
</td>
</tr>