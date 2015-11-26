<?
global $action;
global $IC;
global $model;

$items = $IC->getItems(array("status" => 1, "itemtype" => "wishlist", "extend" => true));
?>
<div class="scene wishlist i:wishlist">
	<h1>Ønskesedler</h1>
	<p>Input til gavmildhed.</p>

<?	if($items): ?>
	<ul class="items wishlists">
<?		foreach($items as $item): ?>
		<li<?= $HTML->attribute("class", $item["classname"], "item") ?>><a href="/wishlist/view/<?= $item["sindex"] ?>"><?= $item["name"] ?></a></li>
<?		endforeach; ?>
	</ul>
<?	endif; ?>

</div>
