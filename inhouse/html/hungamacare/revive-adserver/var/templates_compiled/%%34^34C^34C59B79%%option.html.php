<?php /* Smarty version 2.6.18, created on 2014-12-10 15:45:07
         compiled from option.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'option.html', 3, false),array('function', 't', 'option.html', 7, false),)), $this); ?>

<?php if ($this->_tpl_vars['oxInstalled']): ?>
<form id='settingsform' name='settingsform' ENCTYPE='multipart/form-data' method='post' action='<?php echo ((is_array($_tmp=$this->_tpl_vars['formUrl'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
' onSubmit='return max_formValidate(this);'>
    <?php if ($this->_tpl_vars['adminUser'] && $this->_tpl_vars['optionType'] == 'account-settings' && ! $this->_tpl_vars['formIsDisabled']): ?>
    <br />
    <div class='errormessage'><img class='errormessage' src='<?php echo ((is_array($_tmp=$this->_tpl_vars['assetPath'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
/images/padlock-<?php echo $this->_tpl_vars['image']; ?>
.gif' width='16' height='16' border='0' align='absmiddle'>
        <?php if ($this->_tpl_vars['configLocked']): ?><?php echo OA_Admin_Template::_function_t(array('str' => 'EditConfigNotPossible'), $this);?>
<?php else: ?><?php echo OA_Admin_Template::_function_t(array('str' => 'EditConfigPossible'), $this);?>
<?php endif; ?>
    </div>
    <?php endif; ?>
<?php endif; ?>

<?php $_from = $this->_tpl_vars['aOption']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['aValue']):
?>
	<?php $_from = $this->_tpl_vars['aValue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['filename'] => $this->_tpl_vars['aItem']):
?>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "options/".($this->_tpl_vars['filename']), 'smarty_include_vars' => array('aItem' => $this->_tpl_vars['aItem'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php endforeach; endif; unset($_from); ?>
<?php endforeach; endif; unset($_from); ?>

<?php if ($this->_tpl_vars['oxInstalled']): ?>
    <?php if ($this->_tpl_vars['disableSubmit']): ?>
        <br /><br /><input type="submit" name="submitsettings" value="<?php echo OA_Admin_Template::_function_t(array('str' => 'SaveChanges'), $this);?>
" tabindex="<?php echo $this->_tpl_vars['tabindex']++; ?>
" disabled></form>
    <?php else: ?>
        <br /><br /><input type="submit" name="submitsettings" value="<?php echo OA_Admin_Template::_function_t(array('str' => 'SaveChanges'), $this);?>
" tabindex="<?php echo $this->_tpl_vars['tabindex']++; ?>
"></form>
    <?php endif; ?>
<?php endif; ?>

<?php echo '
<script language=\'JavaScript\' type="text/javascript">
<!--
    function setUploadConversionValues() {
        document.settingsform.start_upload.value = 1;
        document.settingsform.submit();
    }

    function toggleSocketInput() {
        var dbTypeObj      = new getObj(\'aConfig[database][type]\');
        if (dbTypeObj.obj) {
            var localSocketObj = new getObj(\'aConfig[database][localsocket]\');
            var socketObj      = new getObj(\'aConfig[database][socket]\');
            var portObj        = new getObj(\'aConfig[database][port]\');
            var hostObj        = new getObj(\'aConfig[database][host]\');
        } else {
            var dbTypeObj      = new getObj(\'database_type\');
            var localSocketObj = new getObj(\'database_localsocket\');
            var socketObj      = new getObj(\'database_socket\');
            var portObj        = new getObj(\'database_port\');
            var hostObj        = new getObj(\'database_host\');
        }

        if (localSocketObj.obj.disabled) return;

        var portEnabled = dbTypeObj.obj.options[dbTypeObj.obj.selectedIndex].value == \'pgsql\';

        if (localSocketObj.obj.checked == true) {
            setInputDisabled(hostObj.obj, true);
            setInputDisabled(portObj.obj, !portEnabled);
            setInputDisabled(socketObj.obj, false);
        } else {
            setInputDisabled(hostObj.obj, false);
            setInputDisabled(portObj.obj, false);
            setInputDisabled(socketObj.obj, true);
        }
    }

    function setInputDisabled(input, disabled)
    {
      input.disabled = disabled;

      if (disabled) {
        $(input).parent().prev().find(".required").hide();
      } else {
        $(input).parent().prev().find(".required").show();
      }
    }
//-->
</script>
<script language=\'JavaScript\' type="text/javascript">
<!--
'; ?>

<?php echo $this->_tpl_vars['dependbuffer']; ?>

<?php echo '
}

phpAds_refreshEnabled();
'; ?>


<?php if ($this->_tpl_vars['section'] == 'database'): ?>
toggleSocketInput();
<?php endif; ?>

<?php echo $this->_tpl_vars['checkbuffer']; ?>

<?php echo $this->_tpl_vars['usertypebuffer']; ?>

<?php echo '
//--></script>
'; ?>
