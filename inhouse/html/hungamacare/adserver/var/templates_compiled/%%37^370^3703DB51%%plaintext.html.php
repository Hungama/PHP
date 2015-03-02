<?php /* Smarty version 2.6.18, created on 2014-03-05 10:35:21
         compiled from options/plaintext.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'options/plaintext.html', 5, false),)), $this); ?>
<tr>
    <td>&nbsp;</td>
    <td id='cell_<?php echo $this->_tpl_vars['aItem']['name']; ?>
' valign='top'><?php echo $this->_tpl_vars['aItem']['text']; ?>
</td>
    <td width='100%' valign='top'>
		&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['aItem']['value'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

    </td>
    <td></td>
</tr>