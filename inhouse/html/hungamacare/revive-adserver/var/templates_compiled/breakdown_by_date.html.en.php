<div>
	<table width='100%' border='0' cellspacing='0' cellpadding='0'>
	<tr>
	<td style="background-color: #f6f6f6; padding-left: 40px; width: 100%; border-bottom: 1px solid #999999;">
	 <br />

    <?php if ($t->showDaySpanSelector)  {?><div>
    <?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showDaySpanSelector'))) echo htmlspecialchars($t->showDaySpanSelector());?>
    </div><?php }?>

    <?php if ($t->displayInaccurateStatsWarning)  {?><div class="stats-tz-warning">
        <?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showInaccurateStatsWarning'))) echo htmlspecialchars($t->showInaccurateStatsWarning());?>
    </div><?php }?>

    <table width='100%' border='0' cellspacing='0' cellpadding='0'>
	<tr>
        <?php if (!$t->disableGraph)  {?>
    		<td style="padding-bottom:5px; white-space: nowrap;">
    			<br />
    			<a href="stats.php?<?php echo htmlspecialchars($t->aGraphData['queryString']);?>&plugin=advertiser:statshistory" accesskey="e">
                <img src="<?php echo htmlspecialchars($t->assetPath);?>/images/excel.gif" border="0" alt="" /> <?php echo $t->strExportStatisticsToExcel;?>
                </a>
    		</td>
    		<td width="90%">&nbsp;</td>
    	<?php } else {?>
    		<td style="padding-bottom:5px; white-space: nowrap;">
    			<br />
    			<span style="color: #999999;">
                <img src="<?php echo htmlspecialchars($t->assetPath);?>/images/excel.gif" border="0" alt="" /> <?php echo $t->strExportStatisticsToExcel;?></span>
    		</td>
    		<td width="90%">&nbsp;</td>
    	<?php }?>
	</tr>
	</table>
    </td>
  </tr>
  <tr>
	<td style="padding-left: 40px;">
    <?php if ($t->noStatsAvailable)  {?>
    <div class='errormessage' style='margin-top: 2em'><img class='errormessage' src='<?php echo htmlspecialchars($t->assetPath);?>/images/info.gif' width='16' height='16' border='0' align='absmiddle'><?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showNoStatsString'))) echo htmlspecialchars($t->showNoStatsString());?></div>
    <?php } else {?>
    <table width="100%" class="table">
        <thead>
            <tr>
                <th scope="col" class="aleft"><a href="<?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'listOrderHrefRev'))) echo htmlspecialchars($t->listOrderHrefRev($t->statsBreakdown));?>"><?php echo htmlspecialchars($t->statsKey);?><?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'listOrderImage'))) if ($t->listOrderImage($t->statsBreakdown)) { ?><img src="<?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'listOrderImage'))) echo htmlspecialchars($t->listOrderImage($t->statsBreakdown));?>" border="0" /><?php }?></a></th>
                <?php if ($this->options['strict'] || (is_array($t->aColumns)  || is_object($t->aColumns))) foreach($t->aColumns as $ck => $cv) {?>
                <?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showColumn'))) if ($t->showColumn($ck)) { ?><th scope="col" class="aright"><a href="<?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'listOrderHrefRev'))) echo htmlspecialchars($t->listOrderHrefRev($ck));?>"><?php echo htmlspecialchars($cv);?><?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'listOrderImage'))) if ($t->listOrderImage($ck)) { ?><img src="<?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'listOrderImage'))) echo htmlspecialchars($t->listOrderImage($ck));?>" border="0" /><?php }?></a></th><?php }?>
                <?php }?>
            </tr>
        </thead>
        <tbody>
            <?php if ($this->options['strict'] || (is_array($t->aStatsData)  || is_object($t->aStatsData))) foreach($t->aStatsData as $h) {?><tr class="<?php echo htmlspecialchars($h['htmlclass']);?>">
                <td class="<?php echo htmlspecialchars($h['htmlclass']);?>" nowrap="nowrap">
                    <img src="<?php echo htmlspecialchars($t->assetPath);?>/<?php echo htmlspecialchars($t->statsIcon);?>" width="16" height="16" align="absmiddle" />
                    <?php if ($h['link'])  {?><a href="<?php echo htmlspecialchars($h['link']);?>"><?php echo htmlspecialchars($h['date_f']);?></a><?php }?>
                    <?php if (!$h['link'])  {?><span><?php echo htmlspecialchars($h['date_f']);?></span><?php }?>
                </td>
                <?php if ($this->options['strict'] || (is_array($t->aColumns)  || is_object($t->aColumns))) foreach($t->aColumns as $ck => $cv) {?>
                <?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showColumn'))) if ($t->showColumn($ck)) { ?><td class="aright <?php echo htmlspecialchars($h['htmlclass']);?>">
                    <?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showColumnLink'))) if ($t->showColumnLink($h,$ck)) { ?>
                    <a href="<?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showColumnLink'))) echo htmlspecialchars($t->showColumnLink($h,$ck));?><?php echo htmlspecialchars($h['convlinkparams']);?>"><?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showValue'))) echo htmlspecialchars($t->showValue($h,$ck));?></a>
                    <?php } else {?>
                    <?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showValue'))) echo htmlspecialchars($t->showValue($h,$ck));?>
                    <?php }?>
                </td><?php }?>
                <?php }?>
            </tr><?php }?>
            <tr>
                <td colspan="<?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'getColSpan'))) echo htmlspecialchars($t->getColSpan());?>" class="nblight" style="padding-bottom: 3em">
                    <div style="float: left">
                        <form method="get">
                            <?php if ($this->options['strict'] || (is_array($t->aPageParams)  || is_object($t->aPageParams))) foreach($t->aPageParams as $pk => $pv) {?>
                            <input type="hidden" name="<?php echo htmlspecialchars($pk);?>" value="<?php echo htmlspecialchars($pv);?>" />
                            <?php }?>
                            <?php if ($t->showDaySpanSelector)  {?>
                            <?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'tr'))) echo htmlspecialchars($t->tr("strViewBreakdown"));?>:
                            <?php echo $this->elements['statsBreakdown']->toHtml();?>
                            <?php }?>
                            <?php if ($t->pagerSelect)  {?>
                            &nbsp;&nbsp;
                            <?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'tr'))) echo htmlspecialchars($t->tr("strItemsPerPage"));?>:
                            <?php echo $t->pagerSelect;?>
                            <?php }?>
                        </form>
                    </div>
                    <div style="float: right">
                            <?php if ($t->pagerLinks)  {?>
                            &nbsp;&nbsp;
                            <?php echo $t->pagerLinks;?>
                            <?php }?>
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="col" class="aleft">&nbsp;</th>
                <?php if ($this->options['strict'] || (is_array($t->aColumns)  || is_object($t->aColumns))) foreach($t->aColumns as $ck => $cv) {?>
                <?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showColumn'))) if ($t->showColumn($ck)) { ?><th scope="col" class="aright"><?php echo htmlspecialchars($cv);?></th><?php }?>
                <?php }?>
            </tr>
            <?php if ($t->showAverage)  {?><tr>
                <td><b><?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'tr'))) echo htmlspecialchars($t->tr("strTotal"));?></b></td>
                <?php if ($this->options['strict'] || (is_array($t->aColumns)  || is_object($t->aColumns))) foreach($t->aColumns as $ck => $cv) {?>
                <?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showColumn'))) if ($t->showColumn($ck)) { ?><td class="aright"><?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showValue'))) echo htmlspecialchars($t->showValue($t->aTotal,$ck));?></td><?php }?>
                <?php }?>
            </tr><?php }?>
            <?php if (!$t->showAverage)  {?><tr>
                <td class="last"><b><?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'tr'))) echo htmlspecialchars($t->tr("strTotal"));?></b></td>
                <?php if ($this->options['strict'] || (is_array($t->aColumns)  || is_object($t->aColumns))) foreach($t->aColumns as $ck => $cv) {?>
                <?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showColumn'))) if ($t->showColumn($ck)) { ?><td class="aright last"><?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showValue'))) echo htmlspecialchars($t->showValue($t->aTotal,$ck));?></td><?php }?>
                <?php }?>
            </tr><?php }?>
            <?php if ($t->showAverage)  {?><tr>
                <td class="last"><?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'tr'))) echo htmlspecialchars($t->tr("strAverage"));?> (<?php echo htmlspecialchars($t->averageSpan);?> <?php echo htmlspecialchars($t->averageDesc);?>)</td>
                <?php if ($this->options['strict'] || (is_array($t->aColumns)  || is_object($t->aColumns))) foreach($t->aColumns as $ck => $cv) {?>
                <?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showColumn'))) if ($t->showColumn($ck)) { ?><td class="aright last"><?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showValue'))) echo htmlspecialchars($t->showValue($t->average,$ck));?></td><?php }?>
                <?php }?>
            </tr><?php }?>
        </tbody>
    </table>
    <?php }?>
</div>