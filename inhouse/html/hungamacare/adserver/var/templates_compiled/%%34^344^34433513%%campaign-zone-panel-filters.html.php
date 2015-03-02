<?php /* Smarty version 2.6.18, created on 2014-03-05 11:22:35
         compiled from campaign-zone-panel-filters.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 't', 'campaign-zone-panel-filters.html', 14, false),)), $this); ?>

<label class="filter search-filter">
  <?php echo OA_Admin_Template::_function_t(array('str' => 'ZonesSearch'), $this);?>
<br />
  <input id="quick-search-<?php echo $this->_tpl_vars['panelId']; ?>
" class="quick-search" type="text" title="<?php echo OA_Admin_Template::_function_t(array('str' => 'ZonesSearchTitle'), $this);?>
" />
</label>