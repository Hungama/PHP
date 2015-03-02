<?php /* Smarty version 2.6.18, created on 2014-02-25 13:26:50
         compiled from edit-table/hidden.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'edit-table/hidden.html', 14, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['from']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['s']):
?>
<input type="hidden" name="<?php echo $this->_tpl_vars['s']['name']; ?>
" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['s']['value'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
<?php endforeach; endif; unset($_from); ?>