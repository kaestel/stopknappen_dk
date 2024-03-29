<?php
global $action;
global $IC;
global $model;
global $itemtype;

$items = $IC->getItems(array("itemtype" => $itemtype, "order" => "status DESC, position ASC, published_at DESC", "extend" => array("tags" => true)));
?>

<div class="scene defaultList <?= $itemtype ?>List">
	<h1>Startknappen topics</h1>

	<ul class="actions">
		<?= $JML->listNew(array("label" => "New topic")) ?>
	</ul>

	<div class="all_items i:defaultList taggable sortable filters"<?= $HTML->jsData(["order", "tags", "search"], ["filter-tag-contexts" => "about,editing"]) ?>>
<?		if($items): ?>
		<ul class="items">
<?			foreach($items as $item): ?>
			<li class="item item_id:<?= $item["id"] ?>">
				<h3><?= strip_tags($item["name"]) ?></h3>

				<?= $JML->tagList($item["tags"], ["context" => "about,editing"]) ?>

				<?= $JML->listActions($item) ?>
			 </li>
<?			endforeach; ?>
		</ul>
<?		else: ?>
		<p>No topics.</p>
<?		endif; ?>
	</div>

</div>
