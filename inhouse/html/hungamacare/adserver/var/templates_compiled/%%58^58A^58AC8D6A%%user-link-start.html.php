<?php /* Smarty version 2.6.18, created on 2014-03-13 17:53:32
         compiled from user-link-start.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 't', 'user-link-start.html', 73, false),array('function', 'tabindex', 'user-link-start.html', 73, false),)), $this); ?>
<script language="javascript">
<!--
var returnEmail = <?php if ($this->_tpl_vars['returnEmail']): ?>true<?php else: ?>false<?php endif; ?>;
<?php echo '
  $(document).ready(function() {
    $("#user-key").keyup(function() {
      updateHint();
    });

    $("#user-key").autocomplete("user-search.php", {
      width: 500,
      formatItem: function(row) {
        if (row[1] && row[1].length > 0) {
          return row[2] + " [" + row[1] + "]";
        } else {
          return row[2];
        }
      },
      formatResult: function(row) {
        if (returnEmail) {
          return row[1];
        } else {
          return row[2];
        }
      },
      selectFirst: false,
      mustMatch: false,
      scroll: false
    }).result(function() {
      updateHint();
      $("#link-user-button").focus();
    }).focus();

    updateHint();
  });

  function updateHint()
  {
    var key = $("#user-key").val();
    if (key && key.length > 0) {
      $("#link-user-hint").fadeOut(400);
      $("#link-user-button").attr("disabled", false);
    }
    else {
      $("#link-user-hint").fadeIn(400);
      $("#link-user-button").attr("disabled", true);
    }
  }
//-->'; ?>

</script>

<br>
<?php echo $this->_tpl_vars['strLinkUserHelp']; ?>


<form action="<?php echo $this->_tpl_vars['action']; ?>
">
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "edit-table/create.html", 'smarty_include_vars' => array('from' => $this->_tpl_vars['fields'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

  <input type="hidden" name="<?php echo $this->_tpl_vars['entityIdName']; ?>
" value="<?php echo $this->_tpl_vars['entityIdValue']; ?>
" />
  <input type="hidden" name="link" value="1" />

  <div class="controls">
    <input id="link-user-button" value="<?php echo OA_Admin_Template::_function_t(array('str' => 'LinkUser'), $this);?>
" type="submit" <?php echo OA_Admin_Template::_function_tabindex(array(), $this);?>
>
    <span id="link-user-hint" class="hint"><?php if ($this->_tpl_vars['sso']): ?><?php echo OA_Admin_Template::_function_t(array('str' => 'ToLinkProvideEmail'), $this);?>
<?php else: ?><?php echo OA_Admin_Template::_function_t(array('str' => 'ToLinkProvideUsername'), $this);?>
<?php endif; ?></span>
  </div>
</form>