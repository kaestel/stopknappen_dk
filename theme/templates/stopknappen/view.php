<?php
global $IC;
global $action;
global $itemtype;
$model = $IC->typeObject($itemtype);

$qnas = false;
$next = false;
$prev = false;

// default related search pattern
$related_topic_pattern = array(
	"itemtype" => $itemtype, 
	"tags" => [], 
	"autofill" => false,
	"limit" => 5,
	"extend" => array(
		"tags" => true, 
		"user" => true, 
		"readstate" => true
	)
);

// Use special property, fixed_url_identifier to identify topic
$fixed_url_identifier = $action[0];
$sql = "SELECT item_id FROM ".$model->db." WHERE fixed_url_identifier = '$fixed_url_identifier' LIMIT 1";
$query = new Query;
if($query->sql($sql)) {
	$item_id = $query->result(0, "item_id");
	$item = $IC->getItem(array("id" => $item_id, "extend" => array("tags" => true, "user" => true, "comments" => true, "readstate" => true)));
}
// attempt look up by sindex, for fallback purposes
else {
	$item = $IC->getItem(array("sindex" => $action[0], "extend" => array("tags" => true, "user" => true, "comments" => true, "readstate" => true)));
}

// Did we find the topic
if($item && $item["itemtype"] == $itemtype) {
	$this->sharingMetaData($item);

	$qnas = $IC->getItems(array("itemtype" => "qna", "status" => 1, "where" => "qna.about_item_id = ".$item["id"], "extend" => array("user" => true)));

	$next = $IC->getNext($item["item_id"], array("itemtype" => $itemtype, "status" => 1, "order" => "position ASC", "extend" => true));
	$prev = $IC->getPrev($item["item_id"], array("itemtype" => $itemtype, "status" => 1, "order" => "position ASC", "extend" => true));

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

	// Update related search pattern
	$related_topic_pattern["tags"] = $related_tags;
	$related_topic_pattern["exclude"] = $item["id"];

}
// avoid showing wrong topic types
else {
	$item = false;
}


// get related items
$related_topics = $IC->getRelatedItems($related_topic_pattern);

?>
<div class="scene topic i:topic">

<? if($item):
	$media = $IC->sliceMediae($item); ?>

	<div class="i:article topic article id:<?= $item["item_id"] ?>" itemscope itemtype="http://schema.org/Article"
		data-csrf-token="<?= session()->value("csrf") ?>"
		data-readstate="<?= $item["readstate"] ?>"
		data-readstate-add="<?= $this->validPath("/janitor/admin/profile/addReadstate/".$item["item_id"]) ?>" 
		data-readstate-delete="<?= $this->validPath("/janitor/admin/profile/deleteReadstate/".$item["item_id"]) ?>" 
		>


		<?= $HTML->articleTags($item, [
			"context" => ["about"],
			"url" => "/stop/tag",
			"default" => ["/stop", "Stopknappen"]
		]) ?>


		<h1 itemprop="headline"><?= $item["name"] ?></h1>

		<?= $HTML->articleInfo($item, "/stop/".$item["fixed_url_identifier"], [
			"media" => $media
		]) ?>


		<? if($editing_tag_index !== false && preg_match("/Kladde/", $item["tags"][arrayKeyValue($item["tags"], "context", "editing")]["value"])): ?>
		<div class="disclaimer">
			<h3>Dette emne er midt i en intens redigeringsprocess</h3>
			<p>
				Du må gerne læse kladden, men den kan indeholde både halve sætninger og udokumenteret sludder og 
				vrøvl. Redigeringen er en ucensureret process og fordybelsen i et enkelt emne, kan nogle gange gøre 
				redaktørene både følelsesladede og blinde for andre vinkler.
			</p>
			<p>
				Hvis du læser noget du finder stødende eller forkert, så læg en kommentar eller stil spørgsmål 
				nederst på siden – det er den bedste måde at sikre dig, at vi ikke overser dit perspektiv.
			</p>
		</div>
		<? endif; ?>


		<? if($item["html"]): ?>
		<div class="articlebody" itemprop="articleBody">
			<?= $item["html"] ?>
		</div>
		<? endif; ?>


		<?= $HTML->frontendQuestions($item, $qnas, "/janitor/admin/qna/save") ?>

		<?= $HTML->frontendComments($item, "/janitor/stoptopic/addComment") ?>

	</div>


	<? if($next || $prev): ?>
	<div class="pagination i:pagination">
		<ul>
		<? if($prev): ?>
			<li class="previous"><a href="/stop/<?= $prev[0]["fixed_url_identifier"] ?>"><?= strip_tags($prev[0]["name"]) ?></a></li>
		<? endif; ?>
		<? if($next): ?>
			<li class="next"><a href="/stop/<?= $next[0]["fixed_url_identifier"] ?>"><?= strip_tags($next[0]["name"]) ?></a></li>
		<? endif; ?>
		</ul>
	</div>
	<? endif; ?>


<? else: ?>


	<h1>Teknologi er tydeligvis ikke svaret på alting</h1>
	<p>
		Vi kunne ikke finde det angivne emne - måske er det flygtet for at undgå verdens undergang :)
	</p>
	<p>Tryk på <a href="/stop">Stopknappen</a>.</p>


<? endif; ?>


<? 	if($related_topics): ?>
	<div class="related">
		<h2>Relaterede emner <a href="/stop">(Se alle)</a></h2>
		<ul class="topics i:articleMiniList">
		<? foreach($related_topics as $item):
			$media = $IC->sliceMediae($item); ?>
			<li class="article topic item_id:<?= $item["item_id"] ?>" itemscope itemtype="http://schema.org/Article"
				data-readstate="<?= $item["readstate"] ?>"
				>


				<?= $HTML->articleTags($item, [
					"context" => ["about"],
					"url" => "/stop/tag"
				]) ?>


				<h3 class="headline"><a href="/stop/<?= $item["fixed_url_identifier"] ?>"><?= strip_tags($item["name"]) ?></a></h3>


				<?= $HTML->articleInfo($item, "/stop/".$item["fixed_url_identifier"], [
					"media" => $media
				]) ?>


				<? if($item["description"]): ?>
				<div class="description" itemprop="description">
					<p><?= nl2br($item["description"]) ?></p>
				</div>
				<? endif; ?>

			</li>
		<? endforeach; ?>
		</ul>
	</div>
<? 	endif; ?>


</div>