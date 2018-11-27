<?php
/**
* @package janitor.itemtypes
* This file contains itemtype functionality
*/

class TypeStoptopic extends Itemtype {

	/**
	* Init, set varnames, validation rules
	*/
	function __construct() {

		// construct ItemType before adding to model
		parent::__construct(get_class());


		// itemtype database
		$this->db = SITE_DB.".item_stoptopic";


		// Name
		$this->addToModel("name", array(
			"type" => "string",
			"label" => "Topic",
			"required" => true,
			"hint_message" => "Headline of the topic", 
			"error_message" => "Headline must be filled out."
		));

		// Description
		$this->addToModel("description", array(
			"type" => "text",
			"label" => "Short description",
			"hint_message" => "Write a short description of the topic",
			"error_message" => "A short description without any words? How weird."
		));

		// Fixed url id (to allow for prettier and fixed url's – because sindex must be unique, and stop and start topics have identical names – also this prevents topic url from changing)
		$this->addToModel("fixed_url_identifier", array(
			"type" => "string",
			"label" => "Fixed URL identifier",
			"hint_message" => "The URL identifier is used for linking to topics. If left empty, this will be based on Topic name.", 
			"error_message" => "Fixed URL identifier has invalid value."
		));

		// HTML
		$this->addToModel("html", array(
			"type" => "html",
			"label" => "HTML",
			"hint_message" => "Write!",
			"error_message" => "A text without any words? How weird.",
			"allowed_tags" => "p,h2,h3,h4,ul,jpg,png"
		));

	}

	// update fixed_url_identifier based on sindex (if not defined)
	function postSave($item_id) {

		$IC = new Items();
		$item = $IC->getItem(["id" => $item_id, "extend" => true]);

		if(!$item["fixed_url_identifier"]) {
			$_POST["fixed_url_identifier"] = $item["sindex"];
			$this->update(["update", $item_id]);			
		}

	}

	// update fixed_url_identifier based on sindex (if not defined)
	function postUpdate($item_id) {

		$IC = new Items();
		$item = $IC->getItem(["id" => $item_id, "extend" => true]);

		if(!$item["fixed_url_identifier"]) {
			$_POST["fixed_url_identifier"] = $item["sindex"];
			// TODO: risky - can cause endless loop
			$this->update(["update", $item_id]);
		}

	}

}

?>