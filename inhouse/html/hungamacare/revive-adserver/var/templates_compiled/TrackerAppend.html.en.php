<div>
<script type="text/javascript">
<!--

function MMM_trackerAction(action, id)
{
    var f = document.getElementById('trackerAppendForm');
    
    f.t_action.value = action;
    f.t_id.value = id;
    f.submit();
    return false;
}

//-->
</script>
<?php if ($t->showReminder)  {?><div class="errormessage"><img class="errormessage" src="<?php echo htmlspecialchars($t->assetPath);?>/images/warning.gif" align="absmiddle">
<span class='tab-s'>You have unsaved changes on this page, make sure you press &quot;Save Changes&quot; when finished</span><br>
</div><?php }?>
<form id="trackerAppendForm" class="section" method="post">
    <input type="hidden" name="clientid" value="<?php echo htmlspecialchars($t->advertiser_id);?>" />
    <input type="hidden" name="trackerid" value="<?php echo htmlspecialchars($t->tracker_id);?>" />
    <input type="hidden" name="t_action" />
    <input type="hidden" name="t_id" />
    <input type="hidden" name="t_paused" value="<?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'getPausedCodes'))) echo htmlspecialchars($t->getPausedCodes());?>" />
    <h3>Append tracker code</h3>
    <?php if ($this->options['strict'] || (is_array($t->codes)  || is_object($t->codes))) foreach($t->codes as $k => $v) {?><div class="<?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'cycleRow'))) echo htmlspecialchars($t->cycleRow("row"));?>">
        <div class="label">
            <label for="<?php echo htmlspecialchars($v['id']);?>"><?php echo htmlspecialchars($v['rank']);?>. Tracker code<?php if ($v['paused'])  {?> (Paused)<?php }?></label>
        </div>
        <div class="element">
            <textarea name="<?php echo htmlspecialchars($v['name']);?>" id="<?php echo htmlspecialchars($v['id']);?>" rows="3"><?php echo htmlspecialchars($v['tagcode']);?></textarea><br />
            <span>
                <?php if ($v['autotrack'])  {?><input type="checkbox" name="<?php echo htmlspecialchars($v['autotrackname']);?>" id="<?php echo htmlspecialchars($v['autotrackname']);?>" checked="checked" />
                <?php } else {?><input type="checkbox" name="<?php echo htmlspecialchars($v['autotrackname']);?>" id="<?php echo htmlspecialchars($v['autotrackname']);?>" />
                <?php }?> Automatically change the HTML code to track the same variables
            </span>
        </div>
        <div class="link-buttons">
            <?php if (!$v['paused'])  {?><a href="#" onclick="return MMM_trackerAction('pause', '<?php echo htmlspecialchars($k);?>')"><img src="<?php echo htmlspecialchars($t->assetPath);?>/images/icon-deactivate.gif" width="16" height="16" /> Pause</a><?php }?>
            <?php if ($v['paused'])  {?><a href="#" onclick="return MMM_trackerAction('restart', '<?php echo htmlspecialchars($k);?>')"><img src="<?php echo htmlspecialchars($t->assetPath);?>/images/icon-activate.gif" width="16" height="16" /> Restart</a><?php }?>
            <?php if ($v['move_up'])  {?><a href="#" onclick="return MMM_trackerAction('up', '<?php echo htmlspecialchars($k);?>')"><img src="<?php echo htmlspecialchars($t->assetPath);?>/images/triangle-u.gif" width="16" height="16" /> Move up</a><?php }?>
            <?php if (!$v['move_up'])  {?><span><img src="<?php echo htmlspecialchars($t->assetPath);?>/images/triangle-u-d.gif" width="16" height="16" /> Move up</span><?php }?>
            <?php if ($v['move_down'])  {?><a href="#" onclick="return MMM_trackerAction('down', '<?php echo htmlspecialchars($k);?>')"><img src="<?php echo htmlspecialchars($t->assetPath);?>/images/triangle-d.gif" width="16" height="16" /> Move down</a><?php }?>
            <?php if (!$v['move_down'])  {?><span><img src="<?php echo htmlspecialchars($t->assetPath);?>/images/triangle-d-d.gif" width="16" height="16" /> Move down</span><?php }?>
            <a href="#" onclick="return MMM_trackerAction('del', '<?php echo htmlspecialchars($k);?>')"><img src="<?php echo htmlspecialchars($t->assetPath);?>/images/icon-recycle.gif" width="16" height="16" /> Delete</a>
        </div>
    </div><?php }?>
    <div class="row last"><img src="<?php echo htmlspecialchars($t->assetPath);?>/images/icon-acl-add.gif" width="16" height="16" alt="Append new tag" />&nbsp;<a href="#" onclick="return MMM_trackerAction('new', '')">Append new tag</a></div>
    <br />
    <br />
    <input name="save" type="submit" value="Save changes" />
</form>
</td></tr></table>
</div>