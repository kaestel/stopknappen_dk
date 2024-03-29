<?php
/**
* This file contains customized HTML-element output functions
*/
class HTML extends HTMLCore {


	function frontendComments($item, $add_path, $_options = false) {
		global $page;


		$headline = "Comments";
		$no_comments = "No comments yet.";

		if($_options !== false) {
			foreach($_options as $_option => $_value) {
				switch($_option) {
					case "headline"            : $headline              = $_value; break;
					case "no_comments"         : $no_comments           = $_value; break;
				}
			}
		}

		$_ = '';

		$_ .= '<div class="comments i:comments item_id:'.$item["item_id"].'"';
		$_ .= '	data-comment-add="'.security()->validPath($add_path).'"';
		$_ .= '	data-csrf-token="'.session()->value("csrf").'"';
		$_ .= '	>';
		$_ .= '	<h2 class="comments">'.$headline.'</h2>';
		if($item["comments"]):
			$_ .= '<ul class="comments">';
			foreach($item["comments"] as $comment):
			$_ .= '<li class="comment comment_id:'.$comment["id"].'" itemprop="comment" itemscope itemtype="https://schema.org/Comment">';
				$_ .= '<ul class="info">';
					$_ .= '<li class="published_at" itemprop="datePublished" content="'.date("Y-m-d", strtotime($comment["created_at"])).'">'.date("Y-m-d, H:i", strtotime($comment["created_at"])).'</li>';
					$_ .= '<li class="author" itemprop="author">'.$comment["nickname"].'</li>';
				$_ .= '</ul>';
				$_ .= '<p class="comment" itemprop="text">'. $comment["comment"].'</p>';
			$_ .= '</li>';
			endforeach;
		$_ .= '</ul>';
		else:
		$_ .= '<p>'.$no_comments.'</p>';
		endif;
		$_ .= '</div>';
		
		return $_;

	}

	function frontendQuestions($item, $qnas, $add_path) {
		global $page;

		$_ = '';

		$_ .= '<div class="qnas i:qnas item_id:'.$item["item_id"].'"';
		$_ .= '	data-csrf-token="'.session()->value("csrf").'"';
		$_ .= '	data-question-add="'. security()->validPath("/janitor/admin/qna/save").'"';
		$_ .= '	>';
		$_ .= '	<h2 class="qnas">Spørgsmål og svar</h2>';

		if($qnas):
			$_ .= '<ul class="qnas">';
			foreach($qnas as $qna):
				$_ .= '<li class="qna qna_id:'.$qna["id"].'">';
				$_ .= '	<ul class="info">';
				$_ .= '		<li class="user">'.$qna["user_nickname"].'</li>';
				$_ .= '		<li class="created_at">'. date("Y-m-d, H:i", strtotime($qna["created_at"])).'</li>';
				$_ .= '	</ul>';
				$_ .= '	<p class="question">'.nl2br($qna["question"]).'</p>';

				if($qna["answer"]):

					$_ .= '	<ul class="info answer">';
					$_ .= '		<li class="user">Stopknappen</li>';
					$_ .= '		<li class="created_at">'. date("Y-m-d, H:i", strtotime($qna["modified_at"])).'</li>';
					$_ .= '	</ul>';
					$_ .= '	<p class="answer">'.nl2br($qna["answer"]).'</p>';

				else:

					$_ .= '	<p class="answer">Ikke besvaret</p>';

				endif;

				$_ .= '</li>';
			endforeach;
			$_ .= '	</ul>';
		else:

		$_ .= '	<p>Ingen spørgsmål endnu</p>';

		endif;
		$_ .= '</div>';

		return $_;

	}

	
	function frontendOffer($item, $url, $description = false) {

		$_ = '';

		if($item["prices"]) {

			global $page;

			$offer_key = arrayKeyValue($item["prices"], "type", "offer");
			$default_key = arrayKeyValue($item["prices"], "type", "default");

			$_ .= '<ul class="offer" itemscope itemtype="http://schema.org/Offer">';
				$_ .= '<li class="name" itemprop="name" content="'.$item["name"].'"></li>';
				$_ .= '<li class="currency" itemprop="priceCurrency" content="'.$page->currency().'"></li>';

				if($offer_key !== false) {
					$_ .= '<li class="price default">'.formatPrice($item["prices"][$default_key]).(isset($item["subscription_method"]) && $item["subscription_method"] && $item["prices"][$default_key]["price"] ? ' / '.$item["subscription_method"]["name"] : '').'</li>';

					$_ .= '<li class="price offer" itemprop="price" content="'.$item["prices"][$offer_key]["price"].'">'.formatPrice($item["prices"][$offer_key]).(isset($item["subscription_method"]) && $item["subscription_method"] && $item["prices"][$default_key]["price"] ? ' / '.$item["subscription_method"]["name"] : '').'</li>';

				}
				else if($item["prices"][$default_key]["price"]) {

					// TEMP: Custom adjustment for co-work option
					if($item["classname"] == "cowork") {
						
						$custom_price = $item["prices"][$default_key];
						$custom_price["price"] = $custom_price["price_without_vat"];
						$_ .= '<li class="price" itemprop="price" content="'.$item["prices"][$default_key]["price"].'">From '.formatPrice($custom_price).(isset($item["subscription_method"]) && $item["subscription_method"] && $item["prices"][$default_key]["price"] ? ' / '.$item["subscription_method"]["name"] : '').'</li>';
					}
					else {
						$_ .= '<li class="price" itemprop="price" content="'.$item["prices"][$default_key]["price"].'">'.formatPrice($item["prices"][$default_key]).(isset($item["subscription_method"]) && $item["subscription_method"] && $item["prices"][$default_key]["price"] ? ' / '.$item["subscription_method"]["name"] : '').'</li>';
					}
				}
				else {
					$_ .= '<li class="price" itemprop="price" content="'.$item["prices"][$default_key]["price"].'">Free (Not a membership)</li>';
				}

				$_ .= '<li class="url" itemprop="url" content="'.$url.'"></li>';
				if($description) {
					$_ .= '<li class="description" itemprop="description">'.$description.'</li>';
				}

			$_ .= '</ul>';
	
		}

		return $_;
	}


	function articleInfo($item, $url, $_options) {

		$media = false;
		$sharing = false;

		if($_options !== false) {
			foreach($_options as $_option => $_value) {
				switch($_option) {
					case "media"            : $media              = $_value; break;
					case "sharing"          : $sharing            = $_value; break;
				}
			}
		}


		$_ = '';

		$_ .= '<ul class="info">';
		$_ .= '	<li class="published_at" itemprop="datePublished" content="'. date("Y-m-d", strtotime($item["published_at"])) .'">'. date("Y-m-d, H:i", strtotime($item["published_at"])) .'</li>';
		$_ .= '	<li class="modified_at" itemprop="dateModified" content="'. date("Y-m-d", strtotime($item["modified_at"])) .'"></li>';
		$_ .= '	<li class="author" itemprop="author">'. (isset($item["user_nickname"]) ? $item["user_nickname"] : SITE_NAME) .'</li>';
		$_ .= '	<li class="main_entity'. ($sharing ? ' share' : '') .'" itemprop="mainEntityOfPage" content="'. SITE_URL.$url .'"></li>';
		$_ .= '	<li class="publisher" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">';
		$_ .= '		<ul class="publisher_info">';
		$_ .= '			<li class="name" itemprop="name">Stopknappen</li>';
		$_ .= '			<li class="logo" itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">';
		$_ .= '				<span class="image_url" itemprop="url" content="'. SITE_URL .'/img/logo-large.png"></span>';
		$_ .= '				<span class="image_width" itemprop="width" content="720"></span>';
		$_ .= '				<span class="image_height" itemprop="height" content="405"></span>';
		$_ .= '			</li>';
		$_ .= '		</ul>';
		$_ .= '	</li>';
		$_ .= '	<li class="image_info" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">';

		if($media):
			$_ .= '		<span class="image_url" itemprop="url" content="'. SITE_URL .'/images/'. $item["item_id"] .'/'. $media["variant"] .'/720x.'. $media["format"] .'"></span>';
			$_ .= '		<span class="image_width" itemprop="width" content="720"></span>';
			$_ .= '		<span class="image_height" itemprop="height" content="'. floor(720 / ($media["width"] / $media["height"])) .'"></span>';
		else:
			$_ .= '		<span class="image_url" itemprop="url" content="'. SITE_URL .'/img/logo-large.png"></span>';
			$_ .= '		<span class="image_width" itemprop="width" content="720"></span>';
			$_ .= '		<span class="image_height" itemprop="height" content="405"></span>';
		endif;

		$_ .= '	</li>';

		if(isset($item["location"]) && $item["location"] && $item["latitude"] && $item["longitude"]):
			$_ .= '	<li class="place" itemprop="contentLocation" itemscope itemtype="http://schema.org/Place">';
			$_ .= '		<ul class="geo" itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates">';
			$_ .= '			<li class="name" itemprop="name">'.$item["location"].'</li>';
			$_ .= '			<li class="latitude" itemprop="latitude" content="'.round($item["latitude"], 5).'"></li>';
			$_ .= '			<li class="longitude" itemprop="longitude" content="'.round($item["longitude"], 5).'"></li>';
			$_ .= '		</ul>';
			$_ .= '	</li>';
		endif;

		$_ .= '</ul>';

		return $_;

	}


	// $context should be array of allowed contexts
	// - if $context is false, no tags are shown (except editing and default tag)
	// $default should be array with url and text
	// $url should be url to prefix tag links
	// $editing defines if editing link is shown
	function articleTags($item, $_options = false) {

		$context = false;
		$default = false;
		$url = false;
		$editing = true;
		$schema = "articleSection";


		if($_options !== false) {
			foreach($_options as $_option => $_value) {
				switch($_option) {
					case "context"           : $context             = $_value; break;
					case "default"           : $default             = $_value; break;

					case "url"               : $url                 = $_value; break;
					
					case "editing"           : $editing             = $_value; break;
					case "schema"            : $schema              = $_value; break;

				}
			}
		}



		$_ = '';


		// editing tag
		if($item["tags"] && $editing):
			$editing_tag = arrayKeyValue($item["tags"], "context", "editing");
			if($editing_tag !== false):
				$_ .= '<li class="editing" title="Denne artikel redigeres stadig">'.($item["tags"][$editing_tag]["value"] == "true" ? "Redigeres" : $item["tags"][$editing_tag]["value"]).'</li>';
			endif;
		endif;

		// default tag
		if(is_array($default)):
			$_ .= '<li><a href="'.$default[0].'">'.$default[1].'</a></li>';
		endif;

		// item tag list
		if($item["tags"] && $context):
			foreach($item["tags"] as $item_tag):
				if(array_search($item_tag["context"], $context) !== false):
					$_ .= '<li'.($schema ? ' itemprop="'.$schema.'"' : '').'>';
					if($url):
						$_ .= '<a href="'.$url."/".urlencode($item_tag["value"]).'">';
					endif;
					$_ .= $item_tag["value"];
					if($url):
						$_ .= '</a>';
					endif;
					$_ .= '</li>';
				endif;
			endforeach;
		endif;


		// only print tags ul if it has content
		if($_) {
			$_ = '<ul class="tags">'.$_.'</ul>';
		}


		return $_;
	}


	/**
	* Create search input HTML snippet
	*/
	function searchBox($url, $_options = false) {

		$headline = "Search";
		$pattern = false;
		$label = "3 chars min.";
		$button = "Search";
		$query = "";


		if($_options !== false) {
			foreach($_options as $_option => $_value) {
				switch($_option) {
					case "headline"           : $headline             = $_value; break;
					case "pattern"            : $pattern              = $_value; break;
					case "query"              : $query                = $_value; break;

					case "label"              : $label                = $_value; break;
					case "button"             : $button               = $_value; break;
				}
			}
		}



		$_ = '';


		$_ .= '<div class="search i:search">';
		$_ .= '<h2>'.$headline.'</h2>';
		$_ .= $this->formStart($url, ["class" => "labelstyle:inject"]);
			$_ .= $this->input("pattern", ["type" => "hidden", "value" => ($pattern ? json_encode($pattern) : "")]);
			$_ .= '<fieldset>';
				$_ .= $this->input("query", ["type" => "string", "label" => $label, "min" => 3, "required" => true, "value" => $query]);
			$_ .= '</fieldset>';
			$_ .= '<ul class="actions">';
				$_ .= $this->submit($button, ["wrapper" => "li.search"]);
			$_ .= '</ul>';
		$_ .= $this->formEnd();
		$_ .= '</div>';

		return $_;
	}


	// Create pagination element
	function pagination($pagination_items, $_options = false) {


		// Make links for page or sindex
		$type = "page";


		// Default both directions
		$direction = false;

		// Default show total
		$show_total = true;

		// Default base url
		$base_url = $this->path;

		// Default class
		$class = "pagination";

		$labels = [
			"next" => "Next", 
			"prev" => "Previous", 
			"total" => "Page {current_page} of {page_count} pages"
		];

		// overwrite defaults
		if($_options !== false) {
			foreach($_options as $_option => $_value) {
				switch($_option) {

					case "type"              : $type               = $_value; break;

					case "direction"         : $direction          = $_value; break;

					case "show_total"        : $show_total         = $_value; break;

					case "base_url"          : $base_url           = $_value; break;

					case "class"             : $class              = $_value; break;

					case "labels"            : $labels             = $_value; break;

				}
			}
		}


		$_ = '';

		// No pagination unless matching elements
		if(($pagination_items["next"] && ($direction === "next" || !$direction)) || ($pagination_items["prev"] && ($direction === "prev" || !$direction))) {

			$_ .= '<div class="'.$class.'">'."\n";
			$_ .= "\t".'<ul>'."\n";


			if(($direction === "prev" || !$direction) && $pagination_items["prev"]) {

				$labels["prev"] = preg_replace("/\{name\}/", $pagination_items["prev"]["name"], $labels["prev"]);

				if($type == "page" && $pagination_items["current_page"] > 0) {
					$_ .= "\t\t".'<li class="previous"><a href="'.$base_url.'/page/'.($pagination_items["current_page"]-1).'">'.strip_tags($labels["prev"]).'</a></li>'."\n";
				}
				else {
					$_ .= "\t\t".'<li class="previous"><a href="'.$base_url.'/'.$pagination_items["prev"]["sindex"].'">'.strip_tags($labels["prev"]).'</a></li>'."\n";
				}

			}


			if($show_total) {

				$labels["total"] = preg_replace("/\{current_page\}/", $pagination_items["current_page"], $labels["total"]);
				$labels["total"] = preg_replace("/\{page_count\}/", $pagination_items["page_count"], $labels["total"]);

				$_ .= "\t\t".'<li class="pages">'.$labels["total"].'</li>'."\n";
			}


			if(($direction === "next" || !$direction) && $pagination_items["next"]) {

				// print_r($pagination_items);
				$labels["next"] = preg_replace("/\{name\}/", $pagination_items["next"]["name"], $labels["next"]);

				// Page based
				if($type == "page" && $pagination_items["current_page"] < $pagination_items["page_count"]) {
					$_ .= "\t\t".'<li class="next"><a href="'.$base_url.'/page/'.($pagination_items["current_page"]+1).'">'.strip_tags($labels["next"]).'</a></li>'."\n";
				}
				// Sindex based
				else {
					$_ .= "\t\t".'<li class="next"><a href="'.$base_url.'/'.$pagination_items["next"]["sindex"].'">'.strip_tags($labels["next"]).'</a></li>'."\n";
				}

			}


			$_ .= "\t".'</ul>'."\n";
			$_ .= '</div>'."\n";

		}

		return $_;
	}


	function serverMessages($type = []) {

		$_ = '';
		
		if(message()->hasMessages($type)) {
			$_ .= '<div class="messages">';

			$all_messages = message()->getMessages($type);
			message()->resetMessages();
			foreach($all_messages as $type => $messages) {
				foreach($messages as $message) {
					$_ .= '<p class="'.$type.'">'.$message.'</p>';
				}
			}
			$_ .= '</div>';
		}

		return $_;
	}
}

// create standalone instance to make HTML available without model
$HTML = new HTML();

?>
