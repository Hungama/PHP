<?php /* Smarty version 2.6.18, created on 2014-03-28 11:59:12
         compiled from options/textarea.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'options/textarea.html', 7, false),)), $this); ?>
<tr><td>&nbsp;</td>
    <td id='cell_<?php echo $this->_tpl_vars['aItem']['name']; ?>
' class='<?php if ($this->_tpl_vars['aItem']['disabled']): ?>celldisabled<?php else: ?>cellenabled<?php endif; ?>' valign='top'><?php echo $this->_tpl_vars['aItem']['text']; ?>

    <?php if ($this->_tpl_vars['aItem']['req']): ?><span class="required">*</span><?php endif; ?>
    </td>
    <td width='100%' valign='top'>
        <textarea onBlur='phpAds_refreshEnabled(); max_formValidateElement(this);' class='flat' name='<?php echo $this->_tpl_vars['aItem']['name']; ?>
' id='<?php echo $this->_tpl_vars['aItem']['name']; ?>
' rows='<?php echo $this->_tpl_vars['aItem']['rows']; ?>
' <?php if ($this->_tpl_vars['aItem']['disabled']): ?>disabled='disabled'<?php endif; ?>
            style='width: 350px;' tabindex='<?php echo $this->_tpl_vars['aItem']['tabindex']++; ?>
'><?php echo ((is_array($_tmp=$this->_tpl_vars['aItem']['value'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</textarea>
    </td>
    <td><?php echo $this->_tpl_vars['this']->_showPadLock($this->_tpl_vars['aItem']); ?>
</td>
</tr>