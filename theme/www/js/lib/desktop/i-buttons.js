Util.Objects["buttons"] = new function() {
	this.init = function(scene) {
//		u.bug("scene init:" + u.nodeId(scene))
		

		scene.resized = function() {
//			u.bug("scene.resized:" + u.nodeId(this));

			if(this.intro) {

				u.ass(this.intro, {
					"height":page.available_height+"px"
				}, false);

				if(this.intro.is_ready) {

					// precalculate values
					this.intro.sto_w = this.intro.bn_stop.offsetWidth;
					this.intro.sta_w = this.intro.bn_start.offsetWidth;

					this.intro.txt_h = this.intro.bn_stop.offsetHeight;

					this.intro.mas_w = Math.round(this.intro.sta_w*1.3);
					this.intro.mas_h = this.intro.txt_h;
					this.intro.mas_o = -(Math.round(this.intro.mas_h / 3));

					this.intro.sla_box_h = this.intro.txt_h;
					this.intro.sla_box_w = Math.round(this.intro.sla_box_h*0.53);
					this.intro.sla_w = Math.round((this.intro.sta_w-this.intro.sto_w) / 3);

					// u.bug("wrapper_w:" + this.intro.wrapper.offsetWidth);
					// u.bug("sto_w:" + this.intro.sto_w);
					// u.bug("sta_w:" + this.intro.sta_w);
					// u.bug("txt_h:" + this.intro.txt_h);
					// u.bug("mas_w:" + this.intro.mas_w);
					// u.bug("mas_h:" + this.intro.mas_h);
					// u.bug("mas_o:" + this.intro.mas_o);
					// u.bug("sla_box_h:" + this.intro.sla_box_h);
					// u.bug("sla_box_w:" + this.intro.sla_box_w);
					// u.bug("sla_w:" + this.intro.sla_w);
					// u.bug("wrapper_o:" + this.intro.wrapper_o);
					// u.bug("browser_w:" + page.browser_w);

					// slash
					this.intro.slash_svg.setAttribute("width", this.intro.sla_box_w);
					this.intro.slash_svg.setAttribute("height", this.intro.sla_box_h);
					// resize slash
					this.intro.slash_shape.setAttribute("points", (this.intro.sla_box_w-this.intro.sla_w)+",0 "+this.intro.sla_box_w+",0 "+this.intro.sla_w+","+this.intro.sla_box_h+" 0,"+this.intro.sla_box_h);

					// mask
					this.intro.mask_svg.setAttribute("width", this.intro.mas_w);
					this.intro.mask_svg.setAttribute("height", this.intro.mas_h);
					// resize mask
					this.intro.mask_shape.setAttribute("points", "0,0 "+(this.intro.mas_w)+",0 "+((this.intro.mas_w-this.intro.sla_box_w)+this.intro.sla_w)+","+this.intro.mas_h+" 0,"+this.intro.mas_h);


					// adjust right alignment
					u.ass(this.intro.mask_svg, {
						"right":this.intro.mas_o + "px"
					}, false);

					u.ass(this.intro.slash_svg, {
						"right":this.intro.mas_o + "px"
					}, false);

					u.ass(this.intro.bn_start, {
						"right":this.intro.mas_o + "px"
					}, false);


					// calculate wrapper size
					this.intro.wrapper_height = this.intro.txt_h;
					this.intro.wrapper_width = this.intro.sto_w;

					// adjust if step 1 is complete
					if(this.intro.step_1) {
						this.intro.wrapper_o = (this.intro.sla_w - this.intro.mas_o);

						u.a.transition(this.intro.slash_svg, "none");
						u.ass(this.intro.slash_svg, {
							"transform":"translate("+this.intro.sla_w+ "px, 0px)",
						}, false);

					}

					// adjust if step 2 is complete
					if(this.intro.step_2) {
						this.intro.wrapper_o = -(this.intro.mas_o) + this.intro.sta_w;

						u.a.transition(this.intro.slash_svg, "none");
						u.ass(this.intro.bn_start, {
							"transform":"translate("+ (this.intro.sta_w)+"px, 0px)",
						}, false);
					}

					// adjust wrapper
					u.ass(this.intro.wrapper, {
						"width":this.intro.wrapper_width+"px",
						"height":this.intro.wrapper_height+"px",
						"top":Math.round(((page.available_height-60) - this.intro.wrapper_height) / 2) + "px",
						"left":Math.round((page.browser_w - (this.intro.wrapper_width + this.intro.wrapper_o)) / 2) + "px"
					}, false);

				}

			}

		}

		scene.renderControl = function() {
//			u.bug("renderControl:" + u.nodeId(this));

			// show terms
			if(this.intro_done && !this.terms) {
				this.terms = true;
				// accept cookies?
				page.acceptCookies();
			}

			// end intro if still running
			if(this.intro_done && !this.div_article_done) {
				this.initArticle();


				// enable footer
				u.a.transition(page.fN, "none");
				u.ass(page.fN, {
					"opacity":0,
					"display":"block"
				});

				// resize content for article+footer
				page.resized();

				// show footer
				u.a.transition(page.fN, "all 0.5s ease-in");
				u.ass(page.fN, {
					"opacity":1,
				});

			}

		}

		scene.ready = function() {
//			u.bug("scene.ready:" + u.nodeId(this));


			page.cN.scene = this;

			// get main elements
			this.intro = u.qs(".intro", this);
			this.div_article = u.qs("div.article", this);


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


			page.resized();
		}


		// INTRO

		// Prepare intro content for playback
		scene.initIntro = function() {
//			u.bug("initIntro")


			// if intro exists
			if(this.intro) {

				// map reference
				this.intro.scene = this;


				// inject intro elements
				this.intro.wrapper = u.ae(this.intro, "div", {"class":"wrapper"});
				this.intro.bn_stop = u.ae(this.intro.wrapper, "span", {"class":"stop", "html":"stop"});
				this.intro.bn_start = u.ae(this.intro.wrapper, "span", {"class":"start", "html":"start"});


				// apply text-scaling
				u.textscaler(this.intro.wrapper, {
					"min_height":400,
					"max_height":1000,
					"min_width":600,
					"max_width":1300,
					"unit":"rem",
					"span":{
						"min_size":4,
						"max_size":8
					}
				});



				// create svg's for animation
				this.intro.sto_w = this.intro.bn_stop.offsetWidth;
				this.intro.sta_w = this.intro.bn_start.offsetWidth;

				this.intro.txt_h = this.intro.bn_stop.offsetHeight;

				this.intro.mas_w = Math.round(this.intro.sta_w*1.3);
				this.intro.mas_h = this.intro.txt_h;
				this.intro.mas_o = Math.round(this.intro.mas_h / 3);

				this.intro.sla_box_h = this.intro.txt_h;
				this.intro.sla_box_w = Math.round(this.intro.sla_box_h*0.53);
				this.intro.sla_w = Math.round((this.intro.sta_w-this.intro.sto_w) / 3);
				this.intro.wrapper_o = 0;

				// create revealing mask
				this.intro.mask_svg = u.svg({
					"name":"mask",
					"node":this.intro.wrapper,
					"class":"mask",
					"width":this.intro.box_w,
					"height":this.intro.box_h,
				});
				this.intro.mask_shape = u.svgShape(this.intro.mask_svg, {
					"type": "polygon",
					"points": "0,0 "+(this.intro.mas_w)+",0 "+((this.intro.mas_w-this.intro.sla_box_w)+this.intro.sla_w)+","+this.intro.mas_h+" 0,"+this.intro.mas_h
				});

				// create slash
				this.intro.slash_svg = u.svg({
					"name":"slash",
					"node":this.intro.wrapper,
					"class":"slash",
					"width":this.intro.sla_box_w,
					"height":this.intro.sla_box_h,
				});
				this.intro.slash_shape = u.svgShape(this.intro.slash_svg, {
					"type": "polygon",
					"points": (this.intro.sla_box_w-this.intro.sla_w)+",0 "+this.intro.sla_box_w+",0 "+this.intro.sla_w+","+this.intro.sla_box_h+" 0,"+this.intro.sla_box_h
				});


				// enable intro cancellation
				u.e.click(this.intro);
				this.intro.clicked = function() {
					this.finishTimelineAtOnce();
				}

				this.intro.is_ready = true;

				// update dom before starting animation
				page.resized();


				// create timeline
				u.timeline(this.intro);
				var t = 0


				this.intro.atDo(t, function() {
					u.a.transition(this.bn_stop, "all 0.4s ease-in-out");
					u.ass(this.bn_stop, {
						"opacity":1
					});
					u.ass(this.mask_svg, {
						"opacity":1
					});

				});

				this.intro.atDo(t+=2000, function() {
					this.step_1 = true;
					this.wrapper_o = (this.sla_w - this.mas_o);
//					u.bug("this.wrapper_o:" + this.wrapper_o)


					u.ass(this.slash_svg, {
						"opacity":1
					});

					u.a.transition(this.slash_svg, "all 0.6s ease-in-out");
					u.ass(this.slash_svg, {
						"transform":"translate("+this.sla_w+ "px, 0px)",
					});

					u.a.transition(this.wrapper, "all 0.6s ease-in-out");
					u.ass(this.wrapper, {
						"left":Math.round((page.browser_w - (this.wrapper_width + this.wrapper_o)) / 2) + "px"
					});

				});

				this.intro.atDo(t+=600, function() {
					this.step_2 = true;
					this.wrapper_o = -(this.mas_o) + this.sta_w;

					u.ass(this.bn_start, {
						"opacity":1
					});

					u.a.transition(this.bn_start, "all 0.6s ease-in-out");
					u.ass(this.bn_start, {
						"transform":"translate("+ (this.sta_w)+"px, 0px)",
					});

					u.a.transition(this.wrapper, "all 0.6s ease-in-out");
					u.ass(this.wrapper, {
						"left":Math.round((page.browser_w - (this.wrapper_width + this.wrapper_o)) / 2) + "px"
					});

				});

				// wait before ending
				this.intro.atDo(t+=1800, function(){});

				this.intro.playTimeline();


				this.intro.timelineEnded = 	this.intro.timelineStopped = function() {
//					u.bug("intro done");
					this.scene.endIntro();

				}
			}
			// no intro
			else {

				this.intro_done = true;
				this.renderControl();
				
			}
		}


		// hide intro and continue to article
		scene.endIntro = function() {
//			u.bug("exit intro");

			// could also be called if no intro is present
			if(this.intro) {

				// intro hidden
				this.intro.transitioned = function() {

					this.scene.removeChild(this);
					delete this.scene.intro;

					// show article
					this.scene.intro_done = true;
					this.scene.renderControl();

					
				}

				// hide intro
				u.a.transition(this.intro, "all 0.3s ease-in-out");
				u.ass(this.intro, {
					"opacity": 0
				});

			}

			// intro does not exist
			else {

				// show article
				this.intro_done = true;
				this.renderControl();

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


				// enable article calculations
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


		// scene is ready
		scene.ready();
	}
}