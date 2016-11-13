Util.Objects["front"] = new function() {
	this.init = function(scene) {
//		u.bug("scene init:" + u.nodeId(scene))

		scene.resized = function(event) {
//			u.bug("scene.resized:" + u.nodeId(this));

			if(this.intro) {

				u.ass(this.intro, {
					"height":page.available_height+"px"
				});

				if(this.intro.is_ready) {
					

		//			var counter = 0;
					var center_x = this.intro.offsetWidth/2;
					var center_y = this.intro.offsetHeight/2;


//					u.bug("this.intro._i_think:" + ((page.cN.offsetHeight/2)-this.intro._i_think.offsetHeight) + ", " + this.intro._i_think.offsetHeight)

					// Position all content relatively to this._h1
					u.a.translate(this.intro._i_think, (center_x)-(this.intro._i_think.offsetWidth/2), (center_y)-(this.intro._i_think.offsetHeight))
					u.a.translate(this.intro._means, this.intro._i_think._x - this.intro._means.offsetWidth/3, this.intro._i_think._y+this.intro._i_think.offsetHeight*1.05);
					u.a.translate(this.intro._tyrant, this.intro._i_think._x + this.intro._i_think.offsetWidth/2, this.intro._i_think._y+this.intro._i_think.offsetHeight/1.1);
					u.a.translate(this.intro._safety, this.intro._tyrant._x - this.intro._tyrant.offsetHeight*0.85, this.intro._tyrant._y + this.intro._tyrant.offsetHeight/1.1);
					u.a.translate(this.intro._luxery, center_x - this.intro._luxery.offsetWidth/2, this.intro._safety._y + this.intro._safety.offsetHeight*1.2);
					u.a.translate(this.intro._bills, center_x - this.intro._bills.offsetWidth/2, this.intro._luxery._y + this.intro._bills.offsetHeight*1.1);
					u.a.translate(this.intro._to_think, center_x - this.intro._to_think.offsetWidth/2, this.intro._bills._y+this.intro._bills.offsetHeight);
					u.a.translate(this.intro._everything, center_x - this.intro._everything.offsetWidth/2, this.intro._to_think._y + this.intro._everything.offsetHeight/0.9);
					u.a.translate(this.intro._time, this.intro._means._x+this.intro._means.offsetWidth/9.9, this.intro._means._y+this.intro._means.offsetHeight);
					u.a.translate(this.intro._except, this.intro._i_think._x + this.intro._i_think.offsetWidth*0.97, this.intro._i_think._y + this.intro._except.offsetHeight*1.7);
					u.a.translate(this.intro._ability, this.intro._i_think._x + this.intro._i_think.offsetWidth*1.018, this.intro._i_think._y + this.intro._ability.offsetHeight*0.5);
					u.a.translate(this.intro._forgotten, this.intro._i_think._x - this.intro._forgotten.offsetWidth*0.9, this.intro._i_think._y + this.intro._forgotten.offsetHeight*1.9);
					u.a.translate(this.intro._content, this.intro._i_think._x - this.intro._content.offsetWidth*0.9, this.intro._i_think._y + this.intro._content.offsetHeight*0.7);
					u.a.translate(this.intro._idleness, this.intro._i_think._x - this.intro._idleness.offsetWidth/2, this.intro._i_think._y - this.intro._idleness.offsetHeight/1.5);
					u.a.translate(this.intro._long, this.intro._i_think._x + this.intro._long.offsetWidth/1.8, this.intro._i_think._y-this.intro._long.offsetHeight/1.5);
					u.a.translate(this.intro._realize, this.intro._i_think._x + this.intro._realize.offsetWidth*1.15, this.intro._i_think._y-this.intro._long.offsetHeight/2.3	);
					u.a.translate(this.intro._now, this.intro._realize._x + this.intro._realize.offsetWidth/2.4, this.intro._realize._y - this.intro._now.offsetHeight*1.3);
					u.a.translate(this.intro._nothing, this.intro._long._x*1.01, this.intro._long._y-this.intro._nothing.offsetHeight);
					u.a.translate(this.intro._busy, this.intro._idleness._x + this.intro._idleness.offsetWidth*0.05, this.intro._long._y-this.intro._busy.offsetHeight*1.1);
					u.a.translate(this.intro._sheep, this.intro._busy._x + this.intro._busy.offsetWidth*0.16, this.intro._busy._y-this.intro._sheep.offsetHeight*1.1);
					u.a.translate(this.intro._cost, this.intro._sheep._x + this.intro._sheep.offsetWidth*1.10, this.intro._nothing._y-this.intro._cost.offsetHeight*1.05);
					u.a.translate(this.intro._goal, this.intro._sheep._x + this.intro._goal.offsetWidth*0.2, this.intro._sheep._y - this.intro._goal.offsetHeight*1.1);
					u.a.translate(this.intro._wake, this.intro._goal._x + this.intro._goal.offsetWidth*1.35, this.intro._goal._y);

				}

			}
			

			if(this.div_article) {
				this.div_article_y = u.absY(this.div_article);
			}

			if(this.div_news) {
				this.div_news_y = u.absY(this.div_news);
			}

		}

		scene.scrolled = function(event) {
//			u.bug("scrolled:" + u.nodeId(this))

			this.renderControl();
		}

		scene.renderControl = function() {
//			u.bug("renderControl:" + u.nodeId(this));

			if(this.intro_done && !this.div_article_done && page.scrolled_y - 100 > this.div_article_y - page.browser_h) {
				this.initArticle();
			}
			else if(this.intro_done && this.div_article_done && !this.div_news_done && page.scrolled_y - 100 > this.div_news_y - page.browser_h) {
				this.initNews();
			}

			// show terms
			if(this.intro_done && !this.terms) {
				this.terms = true;
				// accept cookies?
				page.acceptCookies();
			}
			// end intro if still running
			else if(!this.intro_ended && page.scrolled_y > 40) {
				this.intro.clicked();
			}

		}


		scene.ready = function() {
//			u.bug("scene.ready:" + u.nodeId(this));

			page.cN.scene = this;

			// get main elements
			this.intro = u.qs(".intro", this);
			this.div_article = u.qs("div.article", this);
			this.div_news = u.qs("div.news", this);


			// required fonts loaded
			this.fontsLoaded = function() {

				page.resized();
				this.initIntro();
			}

			// preload fonts
			u.fontsReady(this, [
				{"family":"OpenSans", "weight":"normal", "style":"normal"},
				{"family":"OpenSans", "weight":"bold", "style":"normal"},
				{"family":"OpenSans", "weight":"normal", "style":"italic"},
				{"family":"PT Serif", "weight":"normal", "style":"normal"}
			]);

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
					"h2.i_think":{
						"min_size":4,
						"max_size":8
					},
					"h2":{
						"min_size":2,
						"max_size":4
					},
					"h2 span.s2":{
						"min_size":2.2,
						"max_size":4.4
					},
					"h3":{
						"min_size":1.4,
						"max_size":2.8
					},
					"p":{
						"min_size":1,
						"max_size":2
					},
					"p span.s2":{
						"min_size":1.4,
						"max_size":2.8
					}
				});


				// reference intro content
				this.intro._i_think = u.qs(".i_think", this.intro);
				this.intro._long = u.qs(".long", this.intro);
				this.intro._long._spans = u.qsa("span", this.intro._long);

				this.intro._now = u.qs(".now", this.intro);
				this.intro._time = u.qs(".time", this.intro);
				this.intro._time._spans = u.qsa("span", this.intro._time);
				this.intro._wake = u.qs(".wake", this.intro);
				this.intro._wake._spans = u.qsa("span", this.intro._wake);
				this.intro._realize = u.qs(".realize", this.intro);

				this.intro._means = u.qs(".means", this.intro);
				this.intro._tyrant = u.qs(".tyrant", this.intro);
				this.intro._tyrant._spans = u.qsa("span", this.intro._tyrant);

				this.intro._goal = u.qs(".goal", this.intro);
				this.intro._goal._spans = u.qsa("span", this.intro._goal);

				this.intro._forgotten = u.qs(".forgotten", this.intro);
				this.intro._bills = u.qs(".bills", this.intro);
				this.intro._bills._spans = u.qsa("span", this.intro._bills);
				this.intro._busy = u.qs(".busy", this.intro);
				this.intro._busy._spans = u.qsa("span", this.intro._busy);
				this.intro._idleness = u.qs(".idleness", this.intro);
				this.intro._idleness._spans = u.qsa("span", this.intro._idleness);

				this.intro._safety = u.qs(".safety", this.intro);
				this.intro._safety._spans = u.qsa("span", this.intro._safety);

				this.intro._luxery = u.qs(".luxery", this.intro);
				this.intro._luxery._spans = u.qsa("span", this.intro._luxery);

				this.intro._cost = u.qs(".cost", this.intro);
				this.intro._cost._spans = u.qsa("span", this.intro._cost);
				this.intro._everything = u.qs(".everything", this.intro);
				this.intro._content = u.qs(".content", this.intro);
				this.intro._sheep = u.qs(".sheep", this.intro);
				this.intro._sheep._spans = u.qsa("span", this.intro._sheep);

				this.intro._nothing = u.qs(".nothing", this.intro);
				this.intro._nothing._spans = u.qsa("span", this.intro._nothing);

				this.intro._except = u.qs(".except", this.intro);
				this.intro._ability = u.qs(".ability", this.intro);
				this.intro._to_think = u.qs(".to_think", this.intro);
				this.intro._to_think._spans = u.qsa("span", this.intro._to_think);

				// apply correct link handling
				var links = u.qsa("a", this.intro);
				for(i = 0; link = links[i]; i++) {
					link.intro = this.intro;
					u.ce(link);
					link.clicked = function() {
						if(this._active) {
							location.href = this.url;
						}
						else {
							this.intro.clicked();
						}
					}
				}


				this.intro.is_ready = true;

				// re-position the intro elements
				page.resized();

				u.timeline(this.intro);

				var t = 0;

				// start new event chain
				// u.eventChain(this.intro);
				// allow timeline test without removing eventchain code
				this.intro.addEvent = function() {}

				// show: jeg tror
				this.intro.atDo(t+=100, function() {this.show(this._i_think);});

				// hide: jeg tror
				this.intro.atDo(t+=1400, function() {this.hide(this._i_think);});

				// show: vi har
				this.intro.atDo(t+=400, function() {this.showSpan(this._long._spans[0], true);});

				// show: sovet
				this.intro.atDo(t+=100, function() {this.showSpan(this._long._spans[1]);});

				// show: længe nok
				this.intro.atDo(t+=500, function() {this.showSpan(this._long._spans[2]);});

				// hide: vi har
				this.intro.atDo(t+=300, function() {this.hide(this._long._spans[0]);});

				// hide: sovet
				this.intro.atDo(t+=200, function() {this.hide(this._long._spans[1]);});

				// hide: længe nok
				this.intro.atDo(t+=300, function() {this.hide(this._long._spans[2]);});

				// show: nu
				this.intro.atDo(t+=200, function() {this.show(this._now);});

				// hide: nu
				this.intro.atDo(t+=800, function() {this.hide(this._now);});

				// show: er det
				this.intro.atDo(t+=200, function() {this.showSpan(this._time._spans[0], true);});

				// show: på tide
				this.intro.atDo(t+=200, function() {this.showSpan(this._time._spans[1]);});

				// hide: er det
				this.intro.atDo(t+=900, function() {this.hide(this._time._spans[0]);});

				// hide: på tide
				this.intro.atDo(t+=100, function() {this.hide(this._time._spans[1]);});

				// show: at
				this.intro.atDo(t+=200, function() {this.showSpan(this._wake._spans[0], true);}, "at vågne");

				// show: vågne
				this.intro.atDo(t+=100, function() {this.showSpan(this._wake._spans[1]);});

				// hide: at
				this.intro.atDo(t+=900, function() {this.hide(this._wake._spans[0]);});

				// show: og
				this.intro.atDo(t+=0, function() {this.showSpan(this._wake._spans[2]);});

				// show: indse
				this.intro.atDo(t+=200, function() {this.show(this._realize);}, "indse");

				// hide: vågne
				this.intro.atDo(t+=100, function() {this.hide(this._wake._spans[1]);});


				// hide: og
				this.intro.atDo(t+=300, function() {this.hide(this._wake);});


				// hide: indse
 				this.intro.atDo(t+=800, function() {this.hide(this._realize);});

				// show: at midlet
				this.intro.atDo(t+=200, function() {this.show(this._means);}, "midlet");

				// hide: at midlet
				this.intro.atDo(t+=900, function() {this.hide(this._means);});

				// show: er blevet
				this.intro.atDo(t+=100, function() {this.showSpan(this._tyrant._spans[0], true);});

				// show: en tyran
				this.intro.atDo(t+=300, function() {this.showSpan(this._tyrant._spans[1]);}, "tyran");

				// hide: er blevet
 				this.intro.atDo(t+=600, function() {this.hide(this._tyrant._spans[0]);});

				// hide: en tyran
 				this.intro.atDo(t+=800, function() {this.hide(this._tyrant._spans[1]);});

				// show: og
				this.intro.atDo(t+=100, function() {this.showSpan(this._goal._spans[0], true);}, "målet");

				// show: målet
				this.intro.atDo(t+=100, function() {this.showSpan(this._goal._spans[1]);});

				// show: er
				this.intro.atDo(t+=300, function() {this.showSpan(this._goal._spans[2]);});

				// hide: og
				this.intro.atDo(t+=400, function() {this.hide(this._goal._spans[0]);});

				// hide: målet
				this.intro.atDo(t+=100, function() {this.hide(this._goal._spans[1]);});

				// hide: er
				this.intro.atDo(t+=100, function() {this.hide(this._goal._spans[2]);});

				// show: glemt
				this.intro.atDo(t+=100, function() {this.show(this._forgotten);});

				// hide: glemt
				this.intro.atDo(t+=700, function() {this.hide(this._forgotten);});

				// show: i stakken
				this.intro.atDo(t+=100, function() {this.showSpan(this._bills._spans[0], true);});

				// show: af
				this.intro.atDo(t+=100, function() {this.showSpan(this._bills._spans[1]);});

				// show: regninger
				this.intro.atDo(t+=200, function() {this.showSpan(this._bills._spans[2]);});

				// hide: i stakken
				this.intro.atDo(t+=1100, function() {this.hide(this._bills._spans[0]);});

				// hide: af
				this.intro.atDo(t+=100, function() {this.hide(this._bills._spans[1]);});

				// hide: regninger
				this.intro.atDo(t+=100, function() {this.hide(this._bills._spans[2]);});

				// show: vi har så
				this.intro.atDo(t+=500, function() {this.showSpan(this._busy._spans[0], true);}, "travlt");

				// show: travlt
				this.intro.atDo(t+=100, function() {this.showSpan(this._busy._spans[1]);});

				// hide: vi har så
				this.intro.atDo(t+=800, function() {this.hide(this._busy._spans[0]);});

				// hide: travlt
				this.intro.atDo(t+=100, function() {this.hide(this._busy._spans[1]);});

				// show: at stilstand
				this.intro.atDo(t+=300, function() {this.show(this._idleness);});

				// hide: at
				this.intro.atDo(t+=700, function() {this.hide(this._idleness._spans[0]);});

				// show: er tryghed
				this.intro.atDo(t+=0, function() {this.show(this._safety);});

				// hide: stilstand
				this.intro.atDo(t+=900, function() {this.hide(this._idleness._spans[1]);});

				// hide: er tryghed
				this.intro.atDo(t+=100, function() {this.hide(this._safety);});

				// show: og
				this.intro.atDo(t+=200, function() {this.showSpan(this._luxery._spans[0], true);});

				// show: tryghed
				this.intro.atDo(t+=100, function() {this.showSpan(this._luxery._spans[1]);});

				// show: er
				this.intro.atDo(t+=400, function() {this.showSpan(this._luxery._spans[2]);});

				// hide: og
				this.intro.atDo(t+=200, function() {this.hide(this._luxery._spans[0]);});

				// show: en luksus
				this.intro.atDo(t+=100, function() {this.showSpan(this._luxery._spans[3]);});

				// hide: tryghed
				this.intro.atDo(t+=1100, function() {this.hide(this._luxery._spans[1]);});

				// hide: er
				this.intro.atDo(t+=100, function() {this.hide(this._luxery._spans[2]);});

				// hide: en luksus
				this.intro.atDo(t+=100, function() {this.hide(this._luxery._spans[3]);});

				// show: der
				this.intro.atDo(t+=100, function() {this.showSpan(this._cost._spans[0], true);});

				// show: koster
				this.intro.atDo(t+=100, function() {this.show(this._cost._spans[1]);});

				// show: os
				this.intro.atDo(t+=100, function() {this.showSpan(this._cost._spans[2]);});

				// hide: der
				this.intro.atDo(t+=600, function() {this.hide(this._cost._spans[0]);});

				// hide: koster
				this.intro.atDo(t+=100, function() {this.hide(this._cost._spans[1]);});

				// show: alt
				this.intro.atDo(t+=100, function() {this.show(this._everything);});

				// hide: os
				this.intro.atDo(t+=100, function() {this.hide(this._cost._spans[2]);});

				// hide: alt
				this.intro.atDo(t+=1500, function() {this.hide(this._everything);});

				// show: tilfredse
				this.intro.atDo(t+=300, function() {this.show(this._content);}, "tilfredse");

				// show: som mættede
				this.intro.atDo(t+=800, function() {this.showSpan(this._sheep._spans[0], true);});

				// show: får
				this.intro.atDo(t+=100, function() {this.showSpan(this._sheep._spans[1]);});

				// hide: som mættede
				this.intro.atDo(t+=600, function() {this.hide(this._sheep._spans[0]);});

				// hide: tilfredse
				this.intro.atDo(t+=600, function() {this.hide(this._content);});

				// hide: får
				this.intro.atDo(t+=100, function() {this.hide(this._sheep._spans[1]);});

				// show: men
				this.intro.atDo(t+=200, function() {this.showSpan(this._nothing._spans[0], true);});

				// show: intet er vores
				this.intro.atDo(t+=400, function() {this.showSpan(this._nothing._spans[1]);});

				// hide: men
				this.intro.atDo(t+=100, function() {this.hide(this._nothing._spans[0]);});

				// hide: intet er vores
				this.intro.atDo(t+=800, function() {this.hide(this._nothing._spans[1]);});

				// show: bortset fra
				this.intro.atDo(t+=300, function() {this.show(this._except);});

				// show: evnen
				this.intro.atDo(t+=600, function() {this.show(this._ability);});

				// hide: bortset fra
				this.intro.atDo(t+=100, function() {this.hide(this._except);});

				// hide: evnen
				this.intro.atDo(t+=1000, function() {this.hide(this._ability);});

				// show: til at
				this.intro.atDo(t+=200, function() {this.showSpan(this._to_think._spans[0], true);});
				//
				// show: tænke
				this.intro.atDo(t+=100, function() {this.showSpan(this._to_think._spans[1]);});

				// show: selv
				this.intro.atDo(t+=100, function() {this.showSpan(this._to_think._spans[2]);});

				// hide: til at
				this.intro.atDo(t+=1500, function() {this.hide(this._to_think._spans[0]);});
				//
				// hide: tænke
				this.intro.atDo(t+=100, function() {this.hide(this._to_think._spans[1]);});

				// hide: selv
				this.intro.atDo(t+=100, function() {this.hide(this._to_think._spans[2]);});

				// wait before ending
				this.intro.atDo(t+=500, function(){});




				// show node
				this.intro.show = function(node) {
					node.transitioned = function() {
						var i, a, as = u.qsa("a", node);
						for(i = 0; a = as[i]; i++) {
							a._active = true;
							u.ac(a, "active");
						}
					}
					u.a.transition(node, "all 0.3s ease-in");
					u.a.setOpacity(node, 1);
				}

				// hide node
				this.intro.hide = function(node) {
					var i, a, as = u.qsa("a", node);
					for(i = 0; a = as[i]; i++) {
						a._active = false; 
						u.rc(a, "active");
					}
					u.a.transition(node, "all 0.2s ease-in");
					u.a.setOpacity(node, 0);
				}

				// show one span, and hide the rest for later
				this.intro.showSpan = function(span, show_node) {
					var i, _span;
					if(show_node) {
						for(i = 0; _span = span.parentNode._spans[i]; i++) {
							if(_span != span) {
								u.a.transition(_span, "none");
								u.a.setOpacity(_span, 0);
							}
						}
						this.show(span.parentNode);
					}
					else {
						this.show(span);
					}
				}

				// show all content - makes for a nice final splash
				this.intro.showAllContent = function() {
					var node, i, span;

					// show all spans
					var spans = u.qsa("span", this);
					for(i = 0; span = spans[i]; i++) {
						u.ass(span, {
							"opacity":1
						});
					}

					var nodes = u.qsa("p,h2,h3", this);
					var j = 0;
					for(i = 0; node = nodes[i]; i++) {
						node.transitioned = function() {
							var i, a, as = u.qsa("a", node);
							for(i = 0; a = as[i]; i++) {
								a._active = true;
								u.ac(a, "active");
							}
						}
						if(node._opacity != 1) {
							u.a.transition(node, "all 0.2s ease-in-out " + (j++)*50 + "ms");
							u.a.setOpacity(node, 1);
						}
					}

					// callback when all content is shown
					u.t.setTimer(this, "allContentShown", (j*50)+300);

				}


				// event chain ended
// 				this.intro.eventChainEnded = function() {
// //					u.bug("eventChainEnded")
//
// 					// make it known
// 					this.scene.intro_chain_ended = true;
//
// 					// hide intro
// 					this.scene.endIntro();
// 				}

				// start event chain playback
				//this.intro.play();
				this.intro.timelineEnded = this.intro.timelineStopped = function() {
//					u.bug("eventChainEnded")

					// make it known
					this.scene.intro_ended = true;

					// hide intro
					this.scene.endIntro();
				}

				this.intro.playTimeline({"start":0, "speed":1});
				
			}
			else {
				// hide intro
				this.scene.endIntro();
			}

		}

		// hide intro and continue to article
		scene.endIntro = function() {
//			u.bug("exit intro")

			// ensure correct rendering
			page.resized();

			// could also be called if no intro is present
			if(this.intro) {


				this.intro.allContentShown = function() {

					// make it known
					this.scene.intro_done = true;

					// arrived at new state, invoke renderControl
					this.scene.renderControl();

				}

				// show full intro
				this.intro.showAllContent();


			}
			// no intro 
			else {

				this.scene.intro_done = true;
				this.scene.intro_ended = true;

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



		// NEWS

		// start news animation playback
		scene.initNews = function() {
//			u.bug("initNews")

//			this._news = u.qs("div.news", this);
			this.div_news_done = true;

			if(this.div_news) {
				this.div_news.scene = this;

				u.ass(this.div_news, {
					"opacity": 0,
					"display":"block"
				});

				u.a.transition(this.div_news, "all 0.4s ease-in-out", "showPosts");
				u.ass(this.div_news, {
					"opacity":1
				});

				this.div_news.showPosts = function() {
					this._posts = u.qsa("li.item", this.div_news);
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



		// scene is ready
		scene.ready();

	}

}
