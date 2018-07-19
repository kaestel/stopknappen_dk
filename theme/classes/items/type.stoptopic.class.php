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

		// HTML
		$this->addToModel("html", array(
			"type" => "html",
			"label" => "HTML",
			"hint_message" => "Write!",
			"error_message" => "A text without any words? How weird.",
			"allowed_tags" => "p,h2,h3,h4,ul,jpg,png"
		));

	}

}

?>