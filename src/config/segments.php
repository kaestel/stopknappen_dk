<?php

// local segmentation
// setup default site runs only on desktop to minimize maintenance
$segments_config["www"] = array(
	
	"desktop_edge"  => "desktop",
	"desktop"       => "desktop",
	"desktop_ie11"  => "desktop",

	"smartphone"    => "smartphone",

	"desktop_ie10"  => "desktop_light",
	"desktop_ie9"   => "desktop_light",
	"desktop_light" => "desktop_light",
	"tv"            => "desktop_light",

	"tablet"        => "tablet",
	"tablet_light"  => "tablet",

	"mobile"        => "mobile",
	"mobile_light"  => "mobile",

	"seo"           => "seo"

);

?>