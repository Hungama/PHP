<?php /* Smarty version 2.6.18, created on 2014-12-10 16:11:28
         compiled from confirmation-dialog.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'confirmation-dialog.html', 23, false),array('function', 'tabindex', 'confirmation-dialog.html', 33, false),)), $this); ?>

<script type="text/javascript">
<?php echo '<!--
  $(document).ready(function() {
'; ?>

    $(".<?php echo $this->_tpl_vars['linkToConfirmClass']; ?>
").confirmedLink("<?php echo $this->_tpl_vars['linkToConfirmClass']; ?>
", "<?php echo $this->_tpl_vars['id']; ?>
");
<?php echo '
  });
//-->'; ?>

</script>

<div id="<?php echo ((is_array($_tmp=@$this->_tpl_vars['id'])) ? $this->_run_mod_handler('default', true, $_tmp, '') : smarty_modifier_default($_tmp, '')); ?>
confirmation-dialog" class="jqmWindow">
  <div class="jqm-window-title">&nbsp;&nbsp;<?php echo $this->_tpl_vars['title']; ?>
</div>

  <div class="jqm-window-body">

    <div>
      <?php echo $this->_tpl_vars['message']; ?>

    </div>

    <div class="jqm-controls">
      <input id="<?php echo ((is_array($_tmp=@$this->_tpl_vars['id'])) ? $this->_run_mod_handler('default', true, $_tmp, '') : smarty_modifier_default($_tmp, '')); ?>
cd-submit" type="button" value="<?php echo $this->_tpl_vars['confirmLabel']; ?>
" class="main-submit" <?php echo OA_Admin_Template::_function_tabindex(array(), $this);?>
 />&nbsp;
      <input id="<?php echo ((is_array($_tmp=@$this->_tpl_vars['id'])) ? $this->_run_mod_handler('default', true, $_tmp, '') : smarty_modifier_default($_tmp, '')); ?>
cd-cancel" type="button" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['cancelLabel'])) ? $this->_run_mod_handler('default', true, $_tmp, 'Cancel') : smarty_modifier_default($_tmp, 'Cancel')); ?>
"  <?php echo OA_Admin_Template::_function_tabindex(array(), $this);?>
 />
    </div>
  </div>
</div>