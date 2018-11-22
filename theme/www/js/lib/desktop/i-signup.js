Util.Objects["signup"] = new function() {
	this.init = function(scene) {
//		u.bug("scene init:" + u.nodeId(scene))
		

		scene.resized = function() {
//			u.bug("scene.resized:" + u.nodeId(this));
		}

		scene.scrolled = function() {
//			u.bug("scrolled:" + u.nodeId(this))
		}

		scene.ready = function() {
//			u.bug("scene.ready:" + u.nodeId(this));

			page.cN.scene = this;


			var form_signup = u.qs("form.signup", this);
			var place_holder = u.qs("div.articlebody .placeholder.signup", this);

			if(form_signup && place_holder) {
				place_holder.parentNode.replaceChild(form_signup, place_holder);
			}

			if(form_signup) {
				u.f.init(form_signup);

				form_signup.preSubmitted = function() {
					this.actions["signup"].value = "Vent";
					u.ac(this, "submitting");
					u.ac(this.actions["signup"], "disabled");
//					this.DOMsubmit();
				}
			}

			u.showScene(this);


			// accept cookies?
			page.acceptCookies();


			page.resized();
		}


		// scene is ready
		scene.ready();

	}

}