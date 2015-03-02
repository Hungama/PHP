<?php /* Smarty version 2.6.18, created on 2014-12-10 16:28:09
         compiled from user-link.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'user-link.html', 15, false),array('function', 't', 'user-link.html', 31, false),array('function', 'tabindex', 'user-link.html', 31, false),)), $this); ?>

<?php if ($this->_tpl_vars['aErrors']): ?>
  <div class='errormessage' id='errors'>
    <img class='errormessage' src='<?php echo ((is_array($_tmp=$this->_tpl_vars['assetPath'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
/images/errormessage.gif' align='absmiddle' />
    <span class='tab-r'>The following errors were found:</span><br />
    <ul>
        <?php $_from = $this->_tpl_vars['aErrors']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['error']):
?>
            <li><?php echo $this->_tpl_vars['error']; ?>
 </li>
        <?php endforeach; endif; unset($_from); ?>
    </ul>
  </div>
<?php endif; ?>

<form action="<?php echo $this->_tpl_vars['action']; ?>
" method="<?php echo $this->_tpl_vars['method']; ?>
">
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "edit-table/hidden.html", 'smarty_include_vars' => array('from' => $this->_tpl_vars['hiddenFields'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "edit-table/create.html", 'smarty_include_vars' => array('from' => $this->_tpl_vars['fields'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

  <div class="controls">
    <?php if ($this->_tpl_vars['showLinkButton']): ?>
      <input value="<< <?php echo OA_Admin_Template::_function_t(array('str' => 'Back'), $this);?>
" type="button" <?php echo OA_Admin_Template::_function_tabindex(array(), $this);?>
 onclick="javascript:location.href='<?php echo $this->_tpl_vars['backUrl']; ?>
'">
      <input value="<?php echo OA_Admin_Template::_function_t(array('str' => 'LinkUser'), $this);?>
" class="main-submit" type="submit" <?php echo OA_Admin_Template::_function_tabindex(array(), $this);?>
>
      <?php if (! $this->_tpl_vars['existingUser']): ?><span class="hint"><?php echo OA_Admin_Template::_function_t(array('str' => 'NewUserWillBeCreated'), $this);?>
</span><?php endif; ?>
    <?php else: ?>
      <input value="<?php echo OA_Admin_Template::_function_t(array('str' => 'SaveChanges'), $this);?>
" class="main-submit" type="submit" <?php echo OA_Admin_Template::_function_tabindex(array(), $this);?>
>
    <?php endif; ?>
  </div>
</form>