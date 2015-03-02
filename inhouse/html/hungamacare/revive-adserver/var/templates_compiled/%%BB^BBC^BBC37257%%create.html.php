<?php /* Smarty version 2.6.18, created on 2014-12-10 16:28:09
         compiled from edit-table/create.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'oa_edit', 'edit-table/create.html', 17, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['from']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['_e_outer'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['_e_outer']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['t']):
        $this->_foreach['_e_outer']['iteration']++;
?>
<?php if (! ($this->_foreach['_e_outer']['iteration'] <= 1)): ?>
<br /><br />
<?php endif; ?>
<?php $this->_tag_stack[] = array('oa_edit', array('type' => 'section','params' => $this->_tpl_vars['t'])); $_block_repeat=true;OA_Admin_Template::_block_edit($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
<?php $_from = $this->_tpl_vars['t']['fields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['v']):
?>
    <?php $this->_tag_stack[] = array('oa_edit', array('params' => $this->_tpl_vars['v'])); $_block_repeat=true;OA_Admin_Template::_block_edit($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?><?php echo $this->_tpl_vars['v']['label']; ?>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo OA_Admin_Template::_block_edit($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
<?php endforeach; endif; unset($_from); ?>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo OA_Admin_Template::_block_edit($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
<?php endforeach; endif; unset($_from); ?>