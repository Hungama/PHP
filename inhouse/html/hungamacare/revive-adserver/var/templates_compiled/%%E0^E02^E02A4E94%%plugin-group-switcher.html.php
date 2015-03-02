<?php /* Smarty version 2.6.18, created on 2015-01-11 11:37:21
         compiled from plugin-group-switcher.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 't', 'plugin-group-switcher.html', 15, false),)), $this); ?>

<div id="section-switcher">
<form method="get" action="plugin-index.php">
    <b><?php echo OA_Admin_Template::_function_t(array('str' => 'ChooseSection'), $this);?>
:</b>
    <select name='selection' id="selection" onchange="this.form.submit()">
        <option value="plugins" <?php if ($this->_tpl_vars['selected'] == 'plugins'): ?> selected <?php endif; ?> ><?php echo OA_Admin_Template::_function_t(array('str' => 'Plugins'), $this);?>
</option>
        <option value="groups" <?php if ($this->_tpl_vars['selected'] == 'groups'): ?> selected <?php endif; ?> ><?php echo OA_Admin_Template::_function_t(array('str' => 'Groups'), $this);?>
</option>
    </select>
    <input type="image" src="<?php echo $this->_tpl_vars['assetPath']; ?>
/images/ltr/go_blue.gif" />
</form>
</div>