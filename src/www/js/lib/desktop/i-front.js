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
					u.a.translate(this.intro._safety, this.intro._tyrant._x - this.intro._tyrant.offsetHeight*0.9, this.intro._tyrant._y + this.intro._tyrant.offsetHeight);
					u.a.translate(this.intro._luxery, center_x - this.intro._luxery.offsetWidth/2, this.intro._safety._y + this.intro._safety.offsetHeight*1.1);
					u.a.translate(this.intro._bills, center_x - this.intro._bills.offsetWidth/2, this.intro._luxery._y + this.intro._bills.offsetHeight*1.2);
					u.a.translate(this.intro._to_think, center_x - this.intro._to_think.offsetWidth/2, this.intro._bills._y+this.intro._bills.offsetHeight);
					u.a.translate(this.intro._everything, center_x - this.intro._everything.offsetWidth/2, this.intro._to_think._y + this.intro._everything.offsetHeight/1.1);
					u.a.translate(this.intro._time, this.intro._means._x+this.intro._means.offsetWidth/5, this.intro._means._y+this.intro._means.offsetHeight);
					u.a.translate(this.intro._except, this.intro._i_think._x + this.intro._i_think.offsetWidth*0.94, this.intro._i_think._y + this.intro._except.offsetHeight*1.7);
					u.a.translate(this.intro._ability, this.intro._i_think._x + this.intro._i_think.offsetWidth*1.015, this.intro._i_think._y + this.intro._ability.offsetHeight*0.3);
					u.a.translate(this.intro._forgotten, this.intro._i_think._x - this.intro._forgotten.offsetWidth*0.9, this.intro._i_think._y + this.intro._forgotten.offsetHeight*1.4);
					u.a.translate(this.intro._content, this.intro._i_think._x - this.intro._content.offsetWidth*0.9, this.intro._i_think._y + this.intro._content.offsetHeight*0.7);
					u.a.translate(this.intro._idleness, this.intro._i_think._x - this.intro._idleness.offsetWidth/2, this.intro._i_think._y - this.intro._idleness.offsetHeight/1.5);
					u.a.translate(this.intro._long, this.intro._i_think._x + this.intro._long.offsetWidth/1.8, this.intro._i_think._y-this.intro._long.offsetHeight/1.5);
					u.a.translate(this.intro._realize, this.intro._i_think._x + this.intro._realize.offsetWidth*1.15, this.intro._i_think._y-this.intro._long.offsetHeight/2.3	);
					u.a.translate(this.intro._now, this.intro._realize._x + this.intro._realize.offsetWidth/4.5, this.intro._realize._y - this.intro._now.offsetHeight*1.1);
					u.a.translate(this.intro._nothing, this.intro._long._x*1.01, this.intro._long._y-this.intro._nothing.offsetHeight);
					u.a.translate(this.intro._busy, this.intro._idleness._x + this.intro._idleness.offsetWidth*0.1, this.intro._long._y-this.intro._busy.offsetHeight*1.1);
					u.a.translate(this.intro._sheep, this.intro._busy._x + this.intro._busy.offsetWidth*0.16, this.intro._busy._y-this.intro._sheep.offsetHeight*1.2);
					u.a.translate(this.intro._cost, this.intro._sheep._x + this.intro._sheep.offsetWidth*1.05, this.intro._nothing._y-this.intro._cost.offsetHeight*1.15);
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
			else if(!this.intro_chain_ended && page.scrolled_y > 40) {
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
					if(typeof(this.stop) == "function") {
						// stop any playback
						this.stop();
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
				this.intro._busy = u.qs(".busy", this.intro);
				this.intro._idleness = u.qs(".idleness", this.intro);
				this.intro._idleness._spans = u.qsa("span", this.intro._idleness);

				this.intro._safety = u.qs(".safety", this.intro);
				this.intro._safety._spans = u.qsa("span", this.intro._safety);

				this.intro._luxery = u.qs(".luxery", this.intro);
				this.intro._luxery._spans = u.qsa("span", this.intro._luxery);

				this.intro._cost = u.qs(".cost", this.intro);
				this.intro._everything = u.qs(".everything", this.intro);
				this.intro._content = u.qs(".content", this.intro);
				this.intro._sheep = u.qs(".sheep", this.intro);
				this.intro._sheep._spans = u.qsa("span", this.intro._sheep);

				this.intro._nothing = u.qs(".nothing", this.intro);
				this.intro._nothing._spans = u.qsa("span", this.intro._nothing);

				this.intro._except = u.qs(".except", this.intro);
				this.intro._ability = u.qs(".ability", this.intro);
				this.intro._to_think = u.qs(".to_think", this.intro);

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


				// start new event chain
				u.eventChain(this.intro);


				// show: jeg tror
				this.intro._step1 = function() {this.show(this._i_think);};
				this.intro.addEvent(this.intro, this.intro._step1, 1200);

				// show: vi har
				this.intro._step2 = function() {this.showSpan(this._long._spans[0], true);};
				this.intro.addEvent(this.intro, this.intro._step2, 100);

				// show: sovet
				this.intro._step3 = function() {this.showSpan(this._long._spans[1]);};
				this.intro.addEvent(this.intro, this.intro._step3, 600);

				// hide: jeg tror
				this.intro._step4 = function() {this.hide(this._i_think);};
				this.intro.addEvent(this.intro, this.intro._step4, 200);

				// show: længe nok
				this.intro._step5 = function() {this.showSpan(this._long._spans[2]);};
				this.intro.addEvent(this.intro, this.intro._step5, 500);

				// hide: vi har
				this.intro._step6 = function() {this.hide(this._long._spans[0]);};
				this.intro.addEvent(this.intro, this.intro._step6, 200);

				// hide: sovet
				this.intro._step7 = function() {this.hide(this._long._spans[1]);};
				this.intro.addEvent(this.intro, this.intro._step7, 300);

				// show: nu
				this.intro._step8 = function() {this.show(this._now);};
				this.intro.addEvent(this.intro, this.intro._step8, 700);

				// hide: længe nok
				this.intro._step9 = function() {this.hide(this._long._spans[2]);};
				this.intro.addEvent(this.intro, this.intro._step9, 500);

				// show: er det på tide
				this.intro._step10 = function() {this.show(this._time);};
				this.intro.addEvent(this.intro, this.intro._step10, 600);

				// hide: nu
				this.intro._step11 = function() {this.hide(this._now);};
				this.intro.addEvent(this.intro, this.intro._step11, 500);

				// hide: er det på tide
				this.intro._step12 = function() {this.hide(this._time);};
				this.intro.addEvent(this.intro, this.intro._step12, 100);

				// show: at
				this.intro._step13 = function() {this.showSpan(this._wake._spans[0], true);};
				this.intro.addEvent(this.intro, this.intro._step13, 200);

				// show: vågne
				this.intro._step14 = function() {this.showSpan(this._wake._spans[1]);};
				this.intro.addEvent(this.intro, this.intro._step14, 800);

				// show: og
				this.intro._step15 = function() {this.showSpan(this._wake._spans[2]);};
				this.intro.addEvent(this.intro, this.intro._step15, 300);

				// hide: at
				this.intro._step16 = function() {this.hide(this._wake._spans[0]);};
				this.intro.addEvent(this.intro, this.intro._step16, 100);

				// hide: vågne
				this.intro._step17 = function() {this.hide(this._wake._spans[1]);};
				this.intro.addEvent(this.intro, this.intro._step17, 300);

				// show: indse
				this.intro._step18 = function() {this.show(this._realize);};
				this.intro.addEvent(this.intro, this.intro._step18, 500);

				// hide: og
				this.intro._step19 = function() {this.hide(this._wake);};
				this.intro.addEvent(this.intro, this.intro._step19, 800);

				// show: at midlet
				this.intro._step20 = function() {this.show(this._means);};
				this.intro.addEvent(this.intro, this.intro._step20, 300);

				// hide: indse
				this.intro._step21 = function() {this.hide(this._realize);};
				this.intro.addEvent(this.intro, this.intro._step21, 700);

				// show: er blevet en tyran
				this.intro._step22 = function() {this.show(this._tyrant);};
				this.intro.addEvent(this.intro, this.intro._step22, 400);

				// hide: at midlet
				this.intro._step23 = function() {this.hide(this._means);};
				this.intro.addEvent(this.intro, this.intro._step23, 500);

				// hide: er blevet
				this.intro._step24 = function() {this.hide(this._tyrant._spans[0]);};
				this.intro.addEvent(this.intro, this.intro._step24, 700);

				// hide: en tyran
				this.intro._step25 = function() {this.hide(this._tyrant._spans[1]);};
				this.intro.addEvent(this.intro, this.intro._step25, 100);

				// show: og målet er
				this.intro._step26 = function() {this.show(this._goal);};
				this.intro.addEvent(this.intro, this.intro._step26, 800);

				// show: glemt
				this.intro._step27 = function() {this.show(this._forgotten);};
				this.intro.addEvent(this.intro, this.intro._step27, 600);

				// hide: og målet er
				this.intro._step28 = function() {this.hide(this._goal);};
				this.intro.addEvent(this.intro, this.intro._step28, 300);

				// show: is stakken af regninger
				this.intro._step29 = function() {this.show(this._bills);};
				this.intro.addEvent(this.intro, this.intro._step29, 500);

				// hide: glemt
				this.intro._step30 = function() {this.hide(this._forgotten);};
				this.intro.addEvent(this.intro, this.intro._step30, 1300);

				// hide: i stakken af regninger
				this.intro._step31 = function() {this.hide(this._bills);};
				this.intro.addEvent(this.intro, this.intro._step31, 700);

				// show: vi har så travlt
				this.intro._step32 = function() {this.show(this._busy);};
				this.intro.addEvent(this.intro, this.intro._step32, 1000);

				// show: at stilstand
				this.intro._step33 = function() {this.show(this._idleness);};
				this.intro.addEvent(this.intro, this.intro._step33, 400);

				// hide: vi har så travlt
				this.intro._step34 = function() {this.hide(this._busy);};
				this.intro.addEvent(this.intro, this.intro._step34, 500);

				// show: er tryghed
				this.intro._step35 = function() {this.show(this._safety);};
				this.intro.addEvent(this.intro, this.intro._step35, 1000);

				// hide: at stilstand
				this.intro._step36 = function() {this.hide(this._idleness);};
				this.intro.addEvent(this.intro, this.intro._step36, 400);

				// hide: er tryghed
				this.intro._step37 = function() {this.hide(this._safety);};
				this.intro.addEvent(this.intro, this.intro._step37, 100);

				// show: og tryghed er
				this.intro._step38 = function() {this.showSpan(this._luxery._spans[0], true);};
				this.intro.addEvent(this.intro, this.intro._step38, 500);

				// show: en luksus
				this.intro._step39 = function() {this.showSpan(this._luxery._spans[1]);};
				this.intro.addEvent(this.intro, this.intro._step39, 900);

				// hide: og tryghed er
				this.intro._step40 = function() {this.hide(this._luxery._spans[0]);};
				this.intro.addEvent(this.intro, this.intro._step40, 300);

				// show: der koster os
				this.intro._step41 = function() {this.show(this._cost);};
				this.intro.addEvent(this.intro, this.intro._step41, 600);

				// hide: en luxus
				this.intro._step42 = function() {this.hide(this._luxery._spans[1]);};
				this.intro.addEvent(this.intro, this.intro._step42, 600);

				// hide: der koster os
				this.intro._step43 = function() {this.hide(this._cost);};
				this.intro.addEvent(this.intro, this.intro._step43, 100);

				// show: alt
				this.intro._step44 = function() {this.show(this._everything);};
				this.intro.addEvent(this.intro, this.intro._step44, 1600);

				// hide: alt
				this.intro._step45 = function() {this.hide(this._everything);};
				this.intro.addEvent(this.intro, this.intro._step45, 800);

				// show: tilfredse
				this.intro._step46 = function() {this.show(this._content);};
				this.intro.addEvent(this.intro, this.intro._step46, 700);

				// show: som mættede slaver
				this.intro._step47 = function() {this.showSpan(this._sheep._spans[0], true);};
				this.intro.addEvent(this.intro, this.intro._step47, 200);

				// show: som mættede slaver
				this.intro._step48 = function() {this.showSpan(this._sheep._spans[1]);};
				this.intro.addEvent(this.intro, this.intro._step48, 1000);

				// hide: som mættede
				this.intro._step49 = function() {this.hide(this._sheep._spans[0]);};
				this.intro.addEvent(this.intro, this.intro._step49, 800);

				// hide: tilfredse
				this.intro._step50 = function() {this.hide(this._content);};
				this.intro.addEvent(this.intro, this.intro._step50, 100);

				// hide: slaver
				this.intro._step51 = function() {this.hide(this._sheep._spans[1]);};
				this.intro.addEvent(this.intro, this.intro._step51, 400);

				// show: men
				this.intro._step52 = function() {this.showSpan(this._nothing._spans[0], true);};
				this.intro.addEvent(this.intro, this.intro._step52, 400);

				// show: intet er vores
				this.intro._step53 = function() {this.showSpan(this._nothing._spans[1]);};
				this.intro.addEvent(this.intro, this.intro._step53, 800);

				// hide: men
				this.intro._step54 = function() {this.hide(this._nothing._spans[0]);};
				this.intro.addEvent(this.intro, this.intro._step54, 100);

				// show: bortset fra
				this.intro._step55 = function() {this.show(this._except);};
				this.intro.addEvent(this.intro, this.intro._step55, 400);

				// hide: intet er vores
				this.intro._step56 = function() {this.hide(this._nothing._spans[1]);};
				this.intro.addEvent(this.intro, this.intro._step56, 500);

				// show: evnen
				this.intro._step57 = function() {this.show(this._ability);};
				this.intro.addEvent(this.intro, this.intro._step57, 900);

				// hide: bortset fra
				this.intro._step58 = function() {this.hide(this._except);};
				this.intro.addEvent(this.intro, this.intro._step58, 1000);

				// hide: evnen
				this.intro._step59 = function() {this.hide(this._ability);};
				this.intro.addEvent(this.intro, this.intro._step59, 400);

				// show: til at tænke selv
				this.intro._step60 = function() {this.show(this._to_think);};
				this.intro.addEvent(this.intro, this.intro._step60, 3000);

				// hide: til at tænke selv
				this.intro._step61 = function() {this.hide(this._to_think);};
				this.intro.addEvent(this.intro, this.intro._step61, 500);



				// show node
				this.intro.show = function(node) {
					node.transitioned = function() {
						var i, a, as = u.qsa("a", node);
						for(i = 0; a = as[i]; i++) {
							a._active = true;
							u.ac(a, "active");
						}
					}
					u.a.transition(node, "all 0.4s ease-in");
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
				this.intro.eventChainEnded = function() {
//					u.bug("eventChainEnded")

					// make it known
					this.scene.intro_chain_ended = true;

					// hide intro
					this.scene.endIntro();
				}

				// start event chain playback
				this.intro.play();
				
			}
			else {
				// hide intro
				this.scene.endIntro();
			}

		}

		// hide intro and continue to article
		scene.endIntro = function() {
//			u.bug("exit intro")

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
				this.scene.intro_chain_ended = true;

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
