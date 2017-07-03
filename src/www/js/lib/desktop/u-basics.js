u.logo_max_font_size = 15;
u.logo_min_font_size = 8;

u.logo_max_border_radius = 25;
u.logo_min_border_radius = 15;

u.logo_max_width = 50;
u.logo_min_width = 30;

u.logo_max_top = 30;
u.logo_min_top = 14;

u.logo_max_padding_top = 16;
u.logo_min_padding_top = 7;

u.logo_max_height = 34;
u.logo_min_height = 23;

u.logoScroller = function() {

	// reduce logo
	if(page.scrolled_y < page.logo.top_offset) {

		page.logo.is_reduced = false;

		var state = (page.logo.top_offset-page.scrolled_y)/page.logo.top_offset;

//		var reduce_font = (1-state) * u.logo_min_font_size;
		page.logo.css_rule.style.setProperty("font-size", u.logo_max_font_size - ((u.logo_max_font_size - u.logo_min_font_size) * (1-state))+"px", "important");

		page.logo.css_rule.style.setProperty("border-radius", u.logo_max_border_radius - ((u.logo_max_border_radius - u.logo_min_border_radius) * (1-state))+"px", "important");
		page.logo.css_rule.style.setProperty("width", u.logo_max_width - ((u.logo_max_width - u.logo_min_width) * (1-state))+"px", "important");
		page.logo.css_rule.style.setProperty("top", u.logo_max_top - ((u.logo_max_top - u.logo_min_top) * (1-state))+"px", "important");
		page.logo.css_rule.style.setProperty("height", u.logo_max_height - ((u.logo_max_height - u.logo_min_height) * (1-state))+"px", "important");
		page.logo.css_rule.style.setProperty("padding-top", u.logo_max_padding_top - ((u.logo_max_padding_top - u.logo_min_padding_top) * (1-state))+"px", "important");

	}
	// claim end state, once
	else if(!page.logo.is_reduced) {

		page.logo.is_reduced = true;
		page.logo.css_rule.style.setProperty("font-size", u.logo_min_font_size+"px", "important");

		page.logo.css_rule.style.setProperty("border-radius", u.logo_min_border_radius+"px", "important");
		page.logo.css_rule.style.setProperty("width", u.logo_min_width+"px", "important");
		page.logo.css_rule.style.setProperty("top", u.logo_min_top+"px", "important");
		page.logo.css_rule.style.setProperty("height", u.logo_min_height+"px", "important");
		page.logo.css_rule.style.setProperty("padding-top", u.logo_min_padding_top+"px", "important");
	}
	
}