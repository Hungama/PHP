<?php /* Smarty version 2.6.18, created on 2015-01-11 12:05:08
         compiled from plugin-view.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'plugin-view.html', 14, false),array('function', 't', 'plugin-view.html', 15, false),)), $this); ?>

<?php if ($this->_tpl_vars['configLocked']): ?>
    <div class='errormessage'><img class='errormessage' src='<?php echo ((is_array($_tmp=$this->_tpl_vars['assetPath'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
/images/padlock-<?php echo $this->_tpl_vars['image']; ?>
.gif' width='16' height='16' border='0' align='absmiddle'>
        <?php echo OA_Admin_Template::_function_t(array('str' => 'EditConfigNotPossible'), $this);?>

    </div>
<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "plugin-group-switcher.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->_tpl_vars['formError'] && $this->_tpl_vars['formError']['id'] > 0 && $this->_tpl_vars['formError']['message']): ?>
<div class="error-box" style="margin-bottom: 10px">
        <?php echo ((is_array($_tmp=$this->_tpl_vars['formError']['message'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

      </div>
</div>
<?php endif; ?>
<div style="min-width: 750px">
    <form name="packageform" id="packageform" method="post" action="plugin-index.php" enctype="multipart/form-data">
            <div class="control-panel">
                <div class="control-set left">
    		        <span class='corner bottom-left'></span>
    		        <span class='corner bottom-right'></span>

    	            <h2>Upgrade this plugin</h2>
    	            Select file
    	            <input name="package" value="<?php echo $this->_tpl_vars['aPackage']['name']; ?>
" type="hidden">
                    <input name="token"   value="<?php echo $this->_tpl_vars['token']; ?>
" type="hidden" />
    	            <input name="filename" tabindex="1" type="file" <?php if ($this->_tpl_vars['configLocked']): ?>disabled='true'<?php endif; ?>>
    	            <input value="Upgrade" name="upgrade" tabindex="1" type="submit" <?php if ($this->_tpl_vars['configLocked']): ?>disabled='true'<?php endif; ?>>
                </div>
                <div class="control-set left">
    		        <span class='corner bottom-left'></span>
    		        <span class='corner bottom-right'></span>

    	            <h2>Tools</h2>
    	            <input name="package" value="<?php echo $this->_tpl_vars['aPackage']['name']; ?>
" type="hidden">
    	            <input value="Diagnose" name="diagnose" tabindex="3" type="submit" <?php if ($this->_tpl_vars['configLocked']): ?>disabled='true'<?php endif; ?>>
    	            <input name="package" value="<?php echo $this->_tpl_vars['aPackage']['name']; ?>
" type="hidden">
    	            <input value="Export Code" name="export" tabindex="3" type="submit" <?php if ($this->_tpl_vars['configLocked']): ?>disabled='true'<?php endif; ?>>
    	            <input name="package" value="<?php echo $this->_tpl_vars['aPackage']['name']; ?>
" type="hidden">
    	            <input value="Backup Tables" name="backup" tabindex="3" type="submit" <?php if ($this->_tpl_vars['configLocked']): ?>disabled='true'<?php endif; ?>>
    	        </div>
            </div>
    </form>
</div>
<?php if ($this->_tpl_vars['aWarnings']): ?>
    <div class="error-box" style="margin-bottom: 10px">
        <?php $_from = $this->_tpl_vars['aWarnings']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['idx'] => $this->_tpl_vars['warning']):
?>
            <?php echo $this->_tpl_vars['warning']; ?>

            <br />
        <?php endforeach; endif; unset($_from); ?>
    </div>
<?php endif; ?>
<?php if ($this->_tpl_vars['aErrors']): ?>
    <div class="error-box" style="margin-bottom: 10px">
        <?php $_from = $this->_tpl_vars['aErrors']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['idx'] => $this->_tpl_vars['error']):
?>
            <?php echo $this->_tpl_vars['error']; ?>

            <br />
        <?php endforeach; endif; unset($_from); ?>
    </div>
<?php endif; ?>
<?php if ($this->_tpl_vars['aMessages']): ?>
    <div class="infomessage" style="margin-bottom: 10px">
        <?php $_from = $this->_tpl_vars['aMessages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['idx'] => $this->_tpl_vars['message']):
?>
            <?php echo $this->_tpl_vars['message']; ?>

            <br />
        <?php endforeach; endif; unset($_from); ?>
    </div>
<?php endif; ?>
<div style="min-width: 750px">
    <p class="backlink"><a href="<?php echo $this->_tpl_vars['backURL']; ?>
">&laquo; Back to plugins list</a></p>

    <div class='panel'>
        <span class='corner top-left'></span>
        <span class='corner top-right'></span>
        <span class='corner bottom-left'></span>
        <span class='corner bottom-right'></span>

        <div style="overflow: hidden;">
	        <div class="split-right">
		        <table class="detail-table">
		            <tr><th>Version</th><td><?php echo $this->_tpl_vars['aPackage']['version']; ?>
</td><th>Author</th><td><?php echo $this->_tpl_vars['aPackage']['author']; ?>
</td></tr>
		            <tr><th>Creation Date</th><td><?php echo $this->_tpl_vars['aPackage']['creationdate']; ?>
</td><th>Email</th><td><?php if ("{".($this->_tpl_vars['aPackage']).".authoremail"): ?><a href="mailto:<?php echo $this->_tpl_vars['aPackage']['authoremail']; ?>
"><?php endif; ?><?php echo $this->_tpl_vars['aPackage']['authoremail']; ?>
<?php if ("{".($this->_tpl_vars['aPackage']).".authoremail"): ?></a><?php endif; ?></td></tr>
		            <tr><th>License</th><td><?php echo $this->_tpl_vars['aPackage']['license']; ?>
</td><th>URL</th><td><?php if ("{".($this->_tpl_vars['aPackage']).".authorurl"): ?><a href="<?php echo $this->_tpl_vars['aPackage']['authorurl']; ?>
"><?php endif; ?><?php echo $this->_tpl_vars['aPackage']['authorurl']; ?>
<?php if ("{".($this->_tpl_vars['aPackage']).".authorurl"): ?></a><?php endif; ?></td></tr>
				</table>
	        </div>

	        <div class="split-left">
                <div class="item-info">
                    <p>
                        <span class="name">
                            <?php if ($this->_tpl_vars['aPackage']['displayname'] != ''): ?>
                                <?php echo $this->_tpl_vars['aPackage']['displayname']; ?>

                            <?php else: ?>
                                <?php echo $this->_tpl_vars['aPackage']['name']; ?>

                            <?php endif; ?>
                        </span>
                    </p>
                    <p><?php echo $this->_tpl_vars['aPackage']['description']; ?>
</p>
                </div>
            </div>

	      </div>
    </div>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "plugin-group-index-list.html", 'smarty_include_vars' => array('aPlugins' => $this->_tpl_vars['aPlugins'],'hideSwitcher' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

    <div class='panel'>
        <span class='corner top-left'></span>
        <span class='corner top-right'></span>
        <span class='corner bottom-left'></span>
        <span class='corner bottom-right'></span>

        <div style="overflow: hidden;">
           <pre class='item-info'><?php echo $this->_tpl_vars['readme']; ?>
</pre>
	    </div>
    </div>

</div>