Util.Modules["front"] = new function() {
	this.init = function(scene) {
		// u.bug("scene init:", scene);

		scene.resized = function(event) {
			// u.bug("scene.resized:", this);

			if(this.intro && !this.intro_done) {

				if(this.intro.stop) {
					// adjust scene padding for nice centered animation
					u.ass(this.intro, {
						"paddingTop": (((u.browserH() - this.intro.stop.offsetHeight)/2) - page.hN.offsetHeight) + "px",
						"paddingBottom": (((u.browserH() - this.intro.stop.offsetHeight)/2) - page.hN.offsetHeight) + "px"
					});

				}
				else if(this.intro.quote) {
					// adjust scene padding for nice centered animation
					u.ass(this.intro, {
						"paddingTop": (((u.browserH() - this.intro.quote.offsetHeight)/2) - page.hN.offsetHeight) + "px",
						"paddingBottom": (((u.browserH() - this.intro.quote.offsetHeight)/2) - page.hN.offsetHeight) + "px"
					});

				}

			}


			if(this.div_article) {
				this.div_article_y = u.absY(this.div_article);
			}

			if(this.div_posts) {
				this.div_posts_y = u.absY(this.div_posts);
			}

		}

		scene.scrolled = function(event) {
			// u.bug("scrolled:", this);

			this.renderControl();
		}

		scene.renderControl = function() {
			// u.bug("renderControl:", this);

			if(this.intro_done && !this.div_article_done) {
				page.resized();
				this.initArticle();
			}
			else if(this.intro_done && this.div_article_done && !this.div_posts_done && page.scrolled_y - (page.browser_h / 2) > this.div_posts_y - page.browser_h) {
				this.initPosts();
			}

			// show terms
			if(this.intro_done && !this.terms) {
				this.terms = true;
				// accept cookies?
				page.acceptCookies();
			}

		}


		scene.ready = function() {
			// u.bug("scene.ready:", this);

			page.cN.scene = this;

			// get main elements
			this.intro = u.qs(".intro", this);
			this.div_article = u.qs("div.article", this);
			this.div_posts = u.qs("div.posts", this);


			page.resized();
			this.initIntro();

		}


		// INTRO

		// Prepare intro content for playback
		scene.initIntro = function() {
//			u.bug("initIntro")

			// if intro exists
			if(this.intro) {

				// map reference
				this.intro.scene = this;


				// end intro on click
				u.e.click(this.intro);
				this.intro.clicked = function() {
//					u.bug("intro clicked")

					// stop event chain
					if(typeof(this.stopTimeline) == "function") {
						// stop any playback
						this.stopTimeline();
					}
					// or just hide intro
					else {
						// hide intro
						this.scene.endIntro();
					}
				}

				// apply text-scaling
				u.textscaler(this.intro, {
					"min_height":400,
					"max_height":1000,
					"min_width":600,
					"max_width":1300,
					"unit":"rem",
					"h2.stop span":{
						"min_size":4,
						"max_size":10
					},
					".quote h2":{
						"min_size":4,
						"max_size":10
					},
					".quote h3":{
						"min_size":1.5,
						"max_size":3
					},
					".quote h4":{
						"min_size":1,
						"max_size":1.5
					},
					".quote p":{
						"min_size":1,
						"max_size":1.5
					}
				});


				this.intro.stop = u.qs("h2.stop", this.intro);
				this.intro.stop.span = u.qs("span", this.intro.stop);

				this.intro.quote = u.qs(".quote", this.intro);
				if(this.intro.quote) {
					this.intro.quote.spans = u.qsa("span", this.intro.quote);
				}

				// show node
				this.intro.show = function(node) {
					u.a.transition(node, "all 0.3s ease-in");
					u.a.setOpacity(node, 1);
				}

				// hide node
				this.intro.hide = function(node) {
					u.a.transition(node, "all 0.2s ease-in");
					u.a.setOpacity(node, 0);
				}

				// show next span in quote
				this.intro.showSpan = function() {

					this.i = this.i || 0;
					this.show(this.quote.spans[this.i++]);
				}


				this.intro.is_ready = true;

				// re-position the intro elements
				page.resized();


				// create intro timeline
				u.timeline(this.intro);
				var t = 0;

				// show: stop
				this.intro.atDo(t+=100, function() {this.show(this.stop);});

				// show: green circle
				this.intro.atDo(t+=100, function() {
					var width = this.stop.span.offsetWidth;
					var height = this.stop.span.offsetHeight;

					// set size of "stop"-span to make a circle
					u.ass(this.stop.span, {
						"padding": ((width+40) - height) / 2 + "px 20px",
						"border-radius":(width+40)/2 + "px"
					});

					// recalc intro position
					page.resized();

					// show green circle
					u.a.transition(this.stop.span, "all 0.2s ease-in-out");
					u.ass(this.stop.span, {
						"backgroundColor": "#26962d"
					});
				});

				// hide: stop
				this.intro.atDo(t+=1800, function() {this.hide(this.stop);});

				// any quote to show
				if(this.intro.quote && this.intro.quote.spans.length) {

					// show first span
					this.intro.atDo(t+=400, function() {
					
						u.ass(this.stop, {
							"display": "none"
						});
						delete this.stop;

						u.ass(this.quote, {
							"display": "block"
						});

						// recalc intro position
						page.resized();

						this.showSpan();
					});


					if(this.intro.quote.spans.length > 1) {
						var i, span;
						for(i = 1; span = this.intro.quote.spans[i]; i++) {

							this.intro.atDo(
								t+=parseInt(u.cv(this.intro.quote.spans[i-1], "t")), 
								function() {this.showSpan();}
							);

						}

					}

					// wait before ending
					this.intro.atDo(t+=parseInt(u.cv(this.intro.quote.spans[this.intro.quote.spans.length-1], "t")), function(){});
				}
				else {

					// wait before ending
					this.intro.atDo(400, function(){});
				}

				// timeline ended
				this.intro.timelineEnded = this.intro.timelineStopped = function() {
					u.bug("timeline ended")

					// hide intro
					this.scene.endIntro();

//					u.t.setTimer(this.scene, "endIntro", 500);
				}

				// start playback
				this.intro.playTimeline({"start":0, "speed":1});

			}
			// no intro
			else {

				// endIntro will continue to next step
				this.scene.endIntro();

			}

		}

		// hide intro and continue to article
		scene.endIntro = function() {
			u.bug("end intro");
//			return;

			// ensure correct rendering
			page.resized();

			// could also be called if no intro is present
			if(this.intro) {

				this.intro.transitioned = function() {

					this.scene.removeChild(this);
					delete this.scene.intro;


					// show header and footer
					u.a.transition(page.hN, "none");
					u.ass(page.hN, {
						"opacity":0,
						"display":"block"
					});

					u.a.transition(page.fN, "none");
					u.ass(page.fN, {
						"opacity":0,
						"display":"block"
					});

					u.a.transition(page.hN, "all 0.5s ease-in");
					u.ass(page.hN, {
						"opacity":1,
					});

					u.a.transition(page.fN, "all 0.5s ease-in");
					u.ass(page.fN, {
						"opacity":1,
					});


//					window.scrollTo(0, 0);

					// make it known
					this.scene.intro_done = true;
					// arrived at new state, invoke renderControl
					this.scene.renderControl();

				}

				u.a.transition(this.intro, "all 0.3s linear")
				u.ass(this.intro, {
					"opacity":0
				});

			}
			// no intro 
			else {

				this.scene.intro_done = true;

				// arrived at new state, invoke renderControl
				this.scene.renderControl();
			}
		}


		// ARTICLE

		// start article animation playback
		scene.initArticle = function() {
//			 u.bug("initArticle")

			this.div_article_done = true;

			// does article exist
			if(this.div_article) {

				this.div_article.scene = this;

				u.ass(this.div_article, {
					"opacity":0,
					"display":"block"
				});
				var header = false;
				// prepare childnodes for animation
				var cn = u.cn(this.div_article);
				this.div_article.nodes = [];
				for(i = 0; node = cn[i]; i++) {
					if(u.gcs(node, "display") != "none") {
						u.ass(node, {
							"opacity":0,
						});

						// find element header
						if(!header && node.nodeName.match(/h1|h2|h3/i)) {
							header = node;
						}
						else {
							this.div_article.nodes.push(node);
						}
					}
				}

				// show article node
				u.ass(this.div_article, {
					"opacity":1,
				});


				// apply headline animation
				u._stepA1.call(header);

				// show remaining article elements
				for(i = 0; node = cn[i]; i++) {
					u.a.transition(node, "all 0.3s ease-in "+(100+(i*200))+"ms");
					u.ass(node, {
						"transform":"translate(0, 0)",
						"opacity":1
					});

				}
			}

			// arrived at new state, invoke renderControl
			this.renderControl();

		}



		// POSTS

		// start posts animation playback
		scene.initPosts = function() {
//			u.bug("initPosts")

			this.div_posts_done = true;

			if(this.div_posts) {
				this.div_posts.scene = this;

				u.ass(this.div_posts, {
					"opacity": 0,
					"display":"block"
				});

				u.a.transition(this.div_posts, "all 0.4s ease-in-out", "showPosts");
				u.ass(this.div_posts, {
					"opacity":1
				});

				this.div_posts.showPosts = function() {
					this._posts = u.qsa("li.item", this.div_posts);
					if(this._posts) {
						var i, node;
						for(i = 0; node = this._posts[i]; i++) {

							var header = u.qs("h2,h3", node);
							header.current_readstate = node.getAttribute("data-readstate");
							if(header.current_readstate) {
								u.addCheckmark(header);
//								u.as(node.checkmark, "top", (header.offsetTop + 3) + "px");
							}


							u.a.transition(node, "all 0.4s ease-in-out "+(100*i)+"ms", "done");
							u.ass(node, {
								"opacity": 1
							});

						}

					}
				} 
			}

			// arrived at new state, invoke renderControl
			this.renderControl();
			
		}


		// Map scene – page will call scene.ready
		page.cN.scene = scene;

	}

}
