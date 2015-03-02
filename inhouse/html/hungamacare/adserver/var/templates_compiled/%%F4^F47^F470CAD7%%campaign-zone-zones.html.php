<?php /* Smarty version 2.6.18, created on 2014-03-05 11:22:36
         compiled from campaign-zone-zones.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 't', 'campaign-zone-zones.html', 31, false),array('function', 'boldSearchPhrase', 'campaign-zone-zones.html', 62, false),array('modifier', 'escape', 'campaign-zone-zones.html', 59, false),array('modifier', 'string_format', 'campaign-zone-zones.html', 90, false),)), $this); ?>
<?php if ($this->_tpl_vars['status'] == 'linked'): ?>
  <?php $this->assign('checkboxPrefix', 'l'); ?>
<?php else: ?>
  <?php $this->assign('checkboxPrefix', 'a'); ?>
<?php endif; ?>


<!--rows-<?php echo $this->_tpl_vars['status']; ?>
-start-->
<?php if (! empty ( $this->_tpl_vars['topPager']->links )): ?>
<span id="page-<?php echo $this->_tpl_vars['status']; ?>
" class="hide"><?php echo $this->_tpl_vars['page']; ?>
</span>
<div class="tableWrapper topPagerContainer clearfix">
  <div class="pager topPager">
    <?php echo $this->_tpl_vars['topPager']->links; ?>

  </div>
</div>
<?php endif; ?>
<table id="zones-<?php echo $this->_tpl_vars['status']; ?>
" class="zones new-table tableWrapper">
  <tbody>
    <tr class="header hide">
      <th class="name"><label><input type="checkbox" id="<?php echo $this->_tpl_vars['status']; ?>
-select-all" class="checkbox select-all" /> <?php echo OA_Admin_Template::_function_t(array('str' => 'SelectUnselectAll'), $this);?>
</label></th>
      <th class="link"></th>
      <?php if (! empty ( $this->_tpl_vars['showStats'] )): ?>
          <th class="ctr"><?php echo OA_Admin_Template::_function_t(array('str' => 'FinanceCTR'), $this);?>
</th>
          <th class="cr"><?php echo OA_Admin_Template::_function_t(array('str' => 'FinanceCR'), $this);?>
</th>
          <th class="ecpm last"><?php echo OA_Admin_Template::_function_t(array('str' => 'FinanceCPM'), $this);?>
</th>
      <?php endif; ?>
    </tr>
  </tbody>

  <?php if (! empty ( $this->_tpl_vars['topPager']->links )): ?>
  <tbody id="select-all-container-<?php echo $this->_tpl_vars['status']; ?>
" class="hide">
    <tr class="header">
      <th colspan="<?php echo $this->_tpl_vars['colspan']; ?>
">
        <div id="zones-<?php echo $this->_tpl_vars['status']; ?>
-select-all" class="selectAllInAccount hide">
          All <em><?php echo $this->_tpl_vars['zonescounts']['showing']; ?>
</em> zones on this page selected. <a href="#">Select all <em><?php echo $this->_tpl_vars['zonescounts']['matching']; ?>
</em> matching zones from this account.</a>
        </div>
        <div id="zones-<?php echo $this->_tpl_vars['status']; ?>
-all-selected" class="selectAllInAccount hide">
          All <em><?php echo $this->_tpl_vars['zonescounts']['matching']; ?>
</em> matching zones from this account selected. <a href="#">Clear selection</a></a>
        </div>
      </th>
    </tr>
  </tbody>
  <?php endif; ?>

  <tbody id="zones-<?php echo $this->_tpl_vars['status']; ?>
-rows">
    <?php $_from = $this->_tpl_vars['websites']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['websiteid'] => $this->_tpl_vars['website']):
?>
    <tr class="website">
      <td class="name" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['website']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
        <label style="white-space: nowrap">
            <input id="<?php echo $this->_tpl_vars['checkboxPrefix']; ?>
w<?php echo $this->_tpl_vars['websiteid']; ?>
"
                   name="w<?php echo $this->_tpl_vars['websiteid']; ?>
" type="checkbox" class="checkbox parent" /><?php echo OA_Admin_Template::_function_boldSearchPhrase(array('text' => $this->_tpl_vars['website']['name'],'search' => $this->_tpl_vars['text']), $this);?>

        </label>
      </td>
      <td class="link">
          <a title="<?php echo OA_Admin_Template::_function_t(array('str' => 'EditWebsite'), $this);?>
 <?php echo $this->_tpl_vars['website']['name']; ?>
" class="website-icon" href="affiliate-edit.php?affiliateid=<?php echo $this->_tpl_vars['websiteid']; ?>
">&nbsp;</a>
      </td>
      <?php if (! empty ( $this->_tpl_vars['showStats'] )): ?>
          <td></td>
          <td></td>
          <td></td>
      <?php endif; ?>
    </tr>

      <?php $_from = $this->_tpl_vars['website']['zones']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['zoneid'] => $this->_tpl_vars['zone']):
?>
      <tr class="zone <?php if ($this->_tpl_vars['aZonesIdHash'][$this->_tpl_vars['zoneid']]): ?> just-linked<?php endif; ?>">
        <td class="name" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['zone']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
        <label>
            <input id="<?php echo $this->_tpl_vars['checkboxPrefix']; ?>
w<?php echo $this->_tpl_vars['websiteid']; ?>
_z<?php echo $this->_tpl_vars['zoneid']; ?>
"
                   name="z<?php echo $this->_tpl_vars['zoneid']; ?>
" type="checkbox" class="checkbox" />
            <?php echo OA_Admin_Template::_function_boldSearchPhrase(array('text' => $this->_tpl_vars['zone']['name'],'search' => $this->_tpl_vars['text']), $this);?>

        </label>
        </td>
        <td class="link">
            <a title="<?php echo OA_Admin_Template::_function_t(array('str' => 'EditZone'), $this);?>
 <?php echo $this->_tpl_vars['website']['name']; ?>
" class="zone-icon" href="zone-edit.php?affiliateid=<?php echo $this->_tpl_vars['websiteid']; ?>
&zoneid=<?php echo $this->_tpl_vars['zoneid']; ?>
">&nbsp;</a>
        </td>
        <?php if (! empty ( $this->_tpl_vars['showStats'] )): ?>
            <?php $this->assign('ctr', ($this->_tpl_vars['zone']['ctr']*100)); ?>
            <?php $this->assign('cr', ($this->_tpl_vars['zone']['cr']*100)); ?>
            <td <?php if ($this->_tpl_vars['zone']['campaign_stats']): ?>class="estim"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['ctr'])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.3f") : smarty_modifier_string_format($_tmp, "%.3f")); ?>
%</td>
            <td <?php if ($this->_tpl_vars['zone']['campaign_stats']): ?>class="estim"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['cr'])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.3f") : smarty_modifier_string_format($_tmp, "%.3f")); ?>
%</td>
            <td <?php if ($this->_tpl_vars['zone']['campaign_stats']): ?>class="estim"<?php endif; ?>>$<?php echo ((is_array($_tmp=$this->_tpl_vars['zone']['ecpm'])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f") : smarty_modifier_string_format($_tmp, "%.2f")); ?>
</td>
        <?php endif; ?>
      </tr>
      <?php endforeach; endif; unset($_from); ?>

    <?php endforeach; else: ?>
    <tr class="empty">
      <td colspan="<?php echo $this->_tpl_vars['colspan']; ?>
">
        <?php echo OA_Admin_Template::_function_t(array('str' => 'NoWebsitesAndZones'), $this);?>

        <?php if ($this->_tpl_vars['text']): ?>
          <?php echo OA_Admin_Template::_function_t(array('str' => 'NoWebsitesAndZonesText','values' => ((is_array($_tmp=$this->_tpl_vars['text'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp))), $this);?>

        <?php endif; ?>

        <?php if ($this->_tpl_vars['checkboxPrefix'] == 'a'): ?>
        <?php echo OA_Admin_Template::_function_t(array('str' => 'ToLink'), $this);?>

        <?php else: ?>
        <?php echo OA_Admin_Template::_function_t(array('str' => 'ToUnlink'), $this);?>

        <?php endif; ?>
      </td>
    </tr>
    <?php endif; unset($_from); ?>
  </tbody>
  <?php if (! empty ( $this->_tpl_vars['pager']->links )): ?>
  <tfoot class="tableFooter">
      <tr>
      <td  colspan="<?php echo $this->_tpl_vars['colspan']; ?>
">
            <div class="pager">
              <span class="summary"><?php echo $this->_tpl_vars['pager']->summary; ?>
</span>
              <span class="controls"><?php echo $this->_tpl_vars['pager']->links; ?>
</span>
            </div>
      </td>
      </tr>
  </tfoot>
  <?php endif; ?>

</table>
<!--rows-<?php echo $this->_tpl_vars['status']; ?>
-end-->

<!--status-<?php echo $this->_tpl_vars['status']; ?>
-start-->
  <?php if ($this->_tpl_vars['status'] == 'linked'): ?>
  <?php echo OA_Admin_Template::_function_t(array('str' => 'Linked'), $this);?>
:
  <?php else: ?>
  <?php echo OA_Admin_Template::_function_t(array('str' => 'Available'), $this);?>
:
  <?php endif; ?>
  <span class="status-value"><?php echo $this->_tpl_vars['zonescounts']['all']; ?>
</span><br />

  <?php echo OA_Admin_Template::_function_t(array('str' => 'Showing'), $this);?>
: <span class="status-value"><?php echo $this->_tpl_vars['zonescounts']['showing']; ?>
</span>
<!--status-<?php echo $this->_tpl_vars['status']; ?>
-end-->