<?php
global $IC;
global $action;
global $itemtype;

$qnas = false;
$next = false;
$prev = false;

$item = $IC->getItem(array("sindex" => $action[0], "extend" => array("tags" => true, "user" => true, "comments" => true, "readstate" => true)));
if($item) {
	$this->sharingMetaData($item);

	$qnas = $IC->getItems(array("itemtype" => "qna", "status" => 1, "where" => "qna.about_item_id = ".$item["id"], "extend" => array("user" => true)));

	$next = $IC->getNext($item["item_id"], array("itemtype" => $itemtype, "status" => 1, "order" => "position ASC", "extend" => true));
	$prev = $IC->getPrev($item["item_id"], array("itemtype" => $itemtype, "status" => 1, "order" => "position ASC", "extend" => true));
}


// clean tags for non-indexing related stuff
$related_tags = $item["tags"];
$todo_tag_index = arrayKeyValue($related_tags, "context", "todo");
if($todo_tag_index !== false) {
	unset($related_tags[$todo_tag_index]);
}
$editing_tag_index = arrayKeyValue($related_tags, "context", "editing");
if($editing_tag_index !== false) {
	unset($related_tags[$editing_tag_index]);
}

$related_topic_pattern = array(
	"itemtype" => $itemtype, 
	"tags" => $related_tags, 
	"exclude" => $item["id"],
	"autofill" => false,
	"limit" => 5,
	"extend" => array(
		"tags" => true, 
		"user" => true, 
		"readstate" => true
	)
);

// get related items
$related_topics = $IC->getRelatedItems($related_topic_pattern);

?>
<div class="scene topic i:topic">

<? if($item):
	$media = $IC->sliceMedia($item); ?>

	<div class="i:article topic id:<?= $item["item_id"] ?>" itemscope itemtype="http://schema.org/Article"
		data-csrf-token="<?= session()->value("csrf") ?>"
		data-readstate="<?= $item["readstate"] ?>"
		data-readstate-add="<?= $this->validPath("/janitor/admin/profile/addReadstate/".$item["item_id"]) ?>" 
		data-readstate-delete="<?= $this->validPath("/janitor/admin/profile/deleteReadstate/".$item["item_id"]) ?>" 
		>


		<?= $HTML->articleTags($item, [
			"context" => ["about"],
			"url" => "/start/tag",
			"default" => ["/start", "Startknappen"]
		]) ?>


		<h1 itemprop="headline"><?= $item["name"] ?></h1>

		<?= $HTML->articleInfo($item, "/start/".$item["sindex"], [
			"media" => $media
		]) ?>


		<? if($editing_tag_index !== false && preg_match("/Kladde/", $item["tags"][arrayKeyValue($item["tags"], "context", "editing")]["value"])): ?>
		<div class="disclaimer">
			<h3>Dette emne er midt i en intens redigeringsprocess</h3>
			<p>Du må gerne læse kladden, men den kan indeholde både halve sætninger og sågar sludder og vrøvl.</p>
		</div>
		<? endif; ?>


		<? if($item["html"]): ?>
		<div class="articlebody" itemprop="articleBody">
			<?= $item["html"] ?>
		</div>
		<? endif; ?>


		<?= $HTML->frontendQuestions($item, $qnas, "/janitor/admin/qna/save") ?>

		<?= $HTML->frontendComments($item, "/janitor/starttopic/addComment") ?>

	</div>


	<? if($next || $prev): ?>
	<div class="pagination">
		<ul>
		<? if($prev): ?>
			<li class="previous"><a href="/start/<?= $prev[0]["sindex"] ?>"><?= strip_tags($prev[0]["name"]) ?></a></li>
		<? endif; ?>
		<? if($next): ?>
			<li class="next"><a href="/start/<?= $next[0]["sindex"] ?>"><?= strip_tags($next[0]["name"]) ?></a></li>
		<? endif; ?>
		</ul>
	</div>
	<? endif; ?>


<? else: ?>


	<h1>Teknologi er tydeligvis ikke svaret på alting</h1>
	<p>
		Vi kunne ikke finde det angivne emne - måske er det flygtet for at undgå verdens undergang :)
	</p>
	<p>Tryk på <a href="/start">Startknappen</a>.</p>


<? endif; ?>


<? 	if($related_topics): ?>
	<div class="related">
		<h2>Relaterede emner <a href="/start">(Se alle)</a></h2>
		<ul class="topics i:articleMiniList">
	<?	foreach($related_topics as $item):
			$media = $IC->sliceMedia($item); ?>
			<li class="article topic item_id:<?= $item["item_id"] ?>" itemscope itemtype="http://schema.org/Article"
				data-readstate="<?= $item["readstate"] ?>"
				>


				<?= $HTML->articleTags($item, [
					"context" => ["about"],
					"url" => "/start/tag"
				]) ?>


				<h3 class="headline"><a href="/start/<?= $item["sindex"] ?>"><?= strip_tags($item["name"]) ?></a></h3>


				<?= $HTML->articleInfo($item, "/start/".$item["sindex"], [
					"media" => $media
				]) ?>


				<? if($item["description"]): ?>
				<div class="description" itemprop="description">
					<p><?= nl2br($item["description"]) ?></p>
				</div>
				<? endif; ?>

			</li>
	<?		endforeach; ?>
		</ul>
	</div>
<? 	endif; ?>


</div>