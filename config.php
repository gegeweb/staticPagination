<?php if(!defined('PLX_ROOT')) exit; ?>
<?php

# Control du token du formulaire
plxToken::validateFormToken($_POST);

if(!empty($_POST)) {
	var_dump($_POST);
	$plxPlugin->setParam('dispTotalPg', plxUtils::getValue($_POST['dispTotalPg']), 'numeric');
	$plxPlugin->setParam('dispFirstLink', plxUtils::getValue($_POST['dispFirstLink']), 'numeric');
	$plxPlugin->setParam('dispPrevLink', plxUtils::getValue($_POST['dispPrevLink']), 'numeric');
	$plxPlugin->setParam('dispPages', plxUtils::getValue($_POST['dispPages']), 'numeric');
	$plxPlugin->setParam('dispHellip', plxUtils::getValue($_POST['dispHellip']), 'numeric');
	$plxPlugin->setParam('dispNextLink', plxUtils::getValue($_POST['dispNextLink']), 'numeric');
	$plxPlugin->setParam('dispLastLink', plxUtils::getValue($_POST['dispLastLink']), 'numeric');
	$plxPlugin->setParam('numberPg', plxUtils::getValue($_POST['numberPg']), 'numeric');
	$plxPlugin->saveParams();
	header('Location: parametres_plugin.php?p=staticPagination');
	exit;
}
$sel=' checked="checked"';
$dispTotalPg = ($plxPlugin->getParam('dispTotalPg')==1 OR $plxPlugin->getParam('dispTotalPg')=='')?$sel:'';
$dispFirstLink = ($plxPlugin->getParam('dispFirstLink')==1 OR $plxPlugin->getParam('dispFirstLink')=='')?$sel:'';
$dispPrevLink = ($plxPlugin->getParam('dispPrevLink')==1 OR $plxPlugin->getParam('dispPrevLink')=='')?$sel:'';
$dispPages = ($plxPlugin->getParam('dispPages')==1 OR $plxPlugin->getParam('dispPages')=='')?$sel:'';
$dispHellip = ($plxPlugin->getParam('dispHellip')==1 OR $plxPlugin->getParam('dispHellip')=='')?$sel:'';
$dispNextLink = ($plxPlugin->getParam('dispNextLink')==1 OR $plxPlugin->getParam('dispNextLink')=='')?$sel:'';
$dispLastLink = ($plxPlugin->getParam('dispLastLink')==1 OR $plxPlugin->getParam('dispLastLink')=='')?$sel:'';
$numberPg = $plxPlugin->getParam('numberPg') !=='' ? $plxPlugin->getParam('numberPg') : '5';
?>

<script type="text/javascript">
var head = document.getElementsByTagName("head")[0];
var css = document.createElement('link');
css.type = "text/css";
css.rel = "stylesheet";
css.href = "<?php echo PLX_PLUGINS ?>staticPagination/style.css";
css.media = "screen";
head.appendChild(css);
</script>

<form class="inline-form" id="form_staticPagination" action="parametres_plugin.php?p=staticPagination" method="post">
	<fieldset class="withlabel">
		<p><?php $plxPlugin->lang('L_PAGER_CHECK_LIB') ?></p>
		<p>
			<input<?php echo $dispFirstLink ?> type="checkbox" id="id_dispFirstLink" name="dispFirstLink" value="1" />
			<label for="id_dispFirstLink"><?php echo L_PAGINATION_FIRST_TITLE ?>&nbsp;:</label>
			<?php echo '<span class="p_first">'.L_PAGINATION_FIRST.'</span>' ?>
		</p>
		<p>
			<input<?php echo $dispPrevLink ?> type="checkbox" id="id_dispPrevLink" name="dispPrevLink" value="1" />		
			<label for="id_dispPrevLink"><?php echo L_PAGINATION_PREVIOUS_TITLE ?>&nbsp;:</label>
			<?php echo '<span class="p_prev">'.L_PAGINATION_PREVIOUS.'</span>' ?>
		</p>
		<p>
			<input<?php echo $dispPages ?> type="checkbox" id="id_dispPages" name="dispPages" value="1" />
			<label for="id_dispPages"><?php $plxPlugin->lang('L_PAGER_PAGES') ?>&nbsp;:</label>
			<?php echo '<span class="p_page">1</span>' ?>
		</p>
		<p style="margin-left: 2em;">
			<input<?php echo $dispHellip ?> type="checkbox" id="id_dispHellip" name="dispHellip" value="1" />
			<label for="id_dispHellip"><?php $plxPlugin->lang('L_PAGER_INDICATOR') ?>&nbsp;:</label>
			<?php echo '<span class="p_page">&hellip;</span>' ?>
		</p>
		<p>
			<input<?php echo $dispNextLink ?> type="checkbox" id="id_dispNextLink" name="dispNextLink" value="1" />		
			<label for="id_dispNextLink"><?php echo L_PAGINATION_NEXT_TITLE ?>&nbsp;:</label>
			<?php echo '<span class="p_next">'.L_PAGINATION_NEXT.'</span>' ?>
		</p>
		<p>
			<input<?php echo $dispLastLink ?> type="checkbox" id="id_dispLastLink" name="dispLastLink" value="1" />		
			<label for="id_dispLastLink"><?php echo L_PAGINATION_LAST_TITLE ?>&nbsp;:</label>
			<?php echo '<span class="p_last">'.L_PAGINATION_LAST.'</span>' ?>
		</p>
		<p>
			<input<?php echo $dispTotalPg ?> type="checkbox" id="id_dispTotalPg" name="dispTotalPg" value="1" />			
			<label for="id_dispTotalPg"><?php $plxPlugin->lang('L_PAGER_NUM_PAGES') ?>:</label>
			<?php printf('<span class="p_pager">'.ucfirst(L_PAGINATION).'</span>',4,10) ?>
		</p>
		<p>
			<label for="id_numberPg"><?php $plxPlugin->lang('L_PAGER_NAX_PAGES') ?>:</label>
			<input type="number" id="id_numberPg" name="numberPg" min="3" value="<?php echo $numberPg ?>" />			
		</p>
		<p class="in-action-bar">
			<?php echo plxToken::getTokenPostMethod() ?>
			<input type="submit" name="submit" value="<?php $plxPlugin->lang('L_PAGER_SAVE') ?>" />
		</p>
	</fieldset>
</form>
<div id="pagination">
<p>
<?php
if($dispFirstLink!='')echo '<span class="p_first">'.L_PAGINATION_FIRST.'</span>';
if($dispPrevLink!='')echo '<span class="p_prev">'.L_PAGINATION_PREVIOUS.'</span>';

if($dispPages!='') {

	$stop_p = 3 + round($numberPg/2) ;
	if( $stop_p < $numberPg ) $stop_p = $numberPg;
	if( $stop_p > 10 ) $stop_p = 10;
	$start_p = $stop_p - $numberPg + 1;
	if($dispHellip!='' and $start_p > 1)echo '<span class="p_page">&hellip;</span>';
	if($start_p < 1 ) $start_p = 1;
	for( $j = $start_p; $j <= $stop_p; $j++ ) {
		($j == 4 ) ? $html_str = '<span class="p_current">4</span>' : $html_str = '<span class="p_page">'.$j.'</span>';
		echo $html_str;
	}
	if($dispHellip!='' and $stop_p < 10) echo '<span class="p_page">&hellip;</span>';

} else {
	echo '<span class="p_current">4</span>';
}
if($dispNextLink!='') echo '<span class="p_next">'.L_PAGINATION_NEXT.'</span>';
if($dispLastLink!='') echo '<span class="p_last">'.L_PAGINATION_LAST.'</span>';
?>
</p>
<?php
if($dispTotalPg!='') printf('<p class="p_pager">'.ucfirst(L_PAGINATION).'</p>',4,10);
?>
</div>
<p>
	<?php $plxPlugin->lang('L_PAGER_CSS_DESCRIPTION') ?>
</p>
<ul>
	<li>div#pagination : <?php $plxPlugin->lang('L_PAGER_CSS_CONTAINER') ?></li>
	<li>div#pagination span : <?php $plxPlugin->lang('L_PAGER_CSS_SPAN') ?></li>
	<li>.p_page : <?php $plxPlugin->lang('L_PAGER_CSS_ITEM') ?></li>
	<li>.p_first : <?php $plxPlugin->lang('L_PAGER_CSS_FIRST') ?></li>
	<li>.p_prev : <?php $plxPlugin->lang('L_PAGER_CSS_PREV') ?></li>
	<li>.p_current : <?php $plxPlugin->lang('L_PAGER_CSS_CURRENT') ?></li>
	<li>.p_next : <?php $plxPlugin->lang('L_PAGER_CSS_NEXT') ?></li>
	<li>.p_last : <?php $plxPlugin->lang('L_PAGER_CSS_LAST') ?></li>
	<li>.p_pager : <?php $plxPlugin->lang('L_PAGER_NUM_PAGES') ?></li>
</ul>
