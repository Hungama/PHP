<?php /* Smarty version 2.6.18, created on 2015-01-11 12:05:42
         compiled from plugin-group-settings.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "plugin-group-switcher.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<p class="backlink"><a href="<?php echo $this->_tpl_vars['backURL']; ?>
">&laquo; Back <?php if ($this->_tpl_vars['plugin']): ?> to <?php echo $this->_tpl_vars['plugin']; ?>
 <?php else: ?> to list <?php endif; ?></a></p>

<div class="panel">
       <span class='corner top-left'></span>
       <span class='corner top-right'></span>
       <span class='corner bottom-left'></span>
       <span class='corner bottom-right'></span>

    <div>
        <div class="item-info">
            <span class="name">Component Group Settings: <?php echo $this->_tpl_vars['group']; ?>
</span>
        </div>
    </div>
</div>