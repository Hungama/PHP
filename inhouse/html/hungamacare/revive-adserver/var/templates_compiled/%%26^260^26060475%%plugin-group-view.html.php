<?php /* Smarty version 2.6.18, created on 2015-01-11 12:05:19
         compiled from plugin-group-view.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'plugin-group-view.html', 16, false),array('function', 'cycle', 'plugin-group-view.html', 94, false),)), $this); ?>
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

<p class="backlink"><a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['backURL'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">&laquo; Back to <?php if ($this->_tpl_vars['parentDisplay']): ?> <?php echo ((is_array($_tmp=$this->_tpl_vars['parentDisplay'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 <?php elseif ($this->_tpl_vars['parent']): ?> <?php echo ((is_array($_tmp=$this->_tpl_vars['parent'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 <?php else: ?> plugins list <?php endif; ?></a></p>

<div class='panel'>
   <span class='corner top-left'></span>
   <span class='corner top-right'></span>
   <span class='corner bottom-left'></span>
   <span class='corner bottom-right'></span>

   <div style="overflow: hidden;">
    <div class="split-right">
       <div class="vertical first-vertical">
        <table class="detail-table">
            <tr><th>Version</th><td><?php echo $this->_tpl_vars['aPlugin']['version']; ?>
</td><th>Author</th><td><?php echo $this->_tpl_vars['aPlugin']['author']; ?>
</td></tr>
            <tr><th>Creation Date</th><td><?php echo $this->_tpl_vars['aPlugin']['creationdate']; ?>
</td><th>Email</th><td><?php if ("{".($this->_tpl_vars['aPlugin']).".authoremail"): ?><a href="mailto:<?php echo $this->_tpl_vars['aPlugin']['authoremail']; ?>
"><?php endif; ?><?php echo $this->_tpl_vars['aPlugin']['authoremail']; ?>
<?php if ("{".($this->_tpl_vars['aPlugin']).".authoremail"): ?></a><?php endif; ?></td></tr>
            <tr><th>License</th><td><?php echo $this->_tpl_vars['aPlugin']['license']; ?>
</td><th>URL</th><td><?php if ("{".($this->_tpl_vars['aPlugin']).".authorurl"): ?><a href="<?php echo $this->_tpl_vars['aPlugin']['authorurl']; ?>
"><?php endif; ?><?php echo $this->_tpl_vars['aPlugin']['authorurl']; ?>
<?php if ("{".($this->_tpl_vars['aPlugin']).".authorurl"): ?></a><?php endif; ?></td></tr>
		</table>
	</div>
    <div class="vertical top-split">
        <table class="detail-table">
	        <tr><th>Compatible with</th><td><?php echo $this->_tpl_vars['aPlugin']['oxversion']; ?>
</td></tr>
	        <tr><th>Extends</th><td><?php echo $this->_tpl_vars['aPlugin']['extends']; ?>
</td></tr>
	        <tr><th>Has specific settings</th><td><?php if ($this->_tpl_vars['aPlugin']['settings']): ?> yes <?php else: ?> no <?php endif; ?></td></tr>
	        <tr><th>Has specific preferences</th><td><?php if ($this->_tpl_vars['aPlugin']['preferences']): ?> yes <?php else: ?> no <?php endif; ?></td></tr>
	    </table>
    </div>
    <div class="vertical top-split last-vertical">
	    <table class="detail-table">
	        <tr><th>Schema Name</th><td><?php if ($this->_tpl_vars['aPlugin']['schema_name']): ?> <?php echo $this->_tpl_vars['aPlugin']['schema_name']; ?>
 <?php else: ?> -- <?php endif; ?></td></tr>
	        <tr><th>Schema Version</th><td><?php if ($this->_tpl_vars['aPlugin']['schema_version']): ?> <?php echo $this->_tpl_vars['aPlugin']['schema_version']; ?>
 <?php else: ?> -- <?php endif; ?></td></tr>
	        <!-- tr><td colspan="2" style="padding: 0px">
	          <form name='pluginform' id='pluginform' method='post' action="plugin-index.php?checkdb=<?php echo $this->_tpl_vars['aPlugin']['name']; ?>
&plugins=true&parent=<?php echo ((is_array($_tmp=$this->_tpl_vars['parent'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
                  <input class="checkdb" type="submit" value="Check Database" />
                </form>
	        </td>
	        </tr-->
        </table>
      </div>
    </div>

    <div class="split-left">
           <div class="item-info">
               <p>
                   <span class="name">
                       <?php if ($this->_tpl_vars['aPlugin']['displayname']): ?>
                           <?php echo $this->_tpl_vars['aPlugin']['displayname']; ?>

                       <?php else: ?>
                           <?php echo $this->_tpl_vars['aPlugin']['name']; ?>

                       <?php endif; ?>
                   </span>
               </p>
               <p><?php echo $this->_tpl_vars['aPlugin']['description']; ?>
</p>
           </div>
    </div>

  </div>
</div>

<?php if (count ( $this->_tpl_vars['aPlugin']['pluginGroupComponents'] ) > 0): ?>
    <table class="data">
      <thead>
    	<tr>
    		<td>
                Extension
    		</td>
    		<td>
                Group
    		</td>
    		<td>
                Component
    		</td>
        </tr>
      </thead>
      <tbody>
        <?php echo smarty_function_cycle(array('name' => 'bgclass','values' => "odd,even",'assign' => 'bgClass','reset' => 1), $this);?>

        <?php $_from = $this->_tpl_vars['aPlugin']['pluginGroupComponents']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['name'] => $this->_tpl_vars['aItem']):
?>
        <?php echo smarty_function_cycle(array('name' => 'bgclass','assign' => 'bgClass'), $this);?>

        	<tr class="<?php echo $this->_tpl_vars['bgClass']; ?>
">
        		<td><?php echo $this->_tpl_vars['aItem']['extension']; ?>
</td>
        		<td><?php echo $this->_tpl_vars['aItem']['group']; ?>
</td>
        		<td><?php echo $this->_tpl_vars['aItem']['component']; ?>
</td>
            </tr>
        <?php endforeach; endif; unset($_from); ?>
        </tbody>
    </table>
<?php endif; ?>

