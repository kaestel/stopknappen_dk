<? $navigation = $this->navigation("main"); ?>
	</div>

	<div id="navigation">
		<ul class="navigation">
		<? if($navigation): ?>
			<? foreach($navigation["nodes"] as $node): ?>
			<?= $HTML->navigationLink($node); ?>
			<? endforeach; ?>
		<? endif; ?>
		</ul>
	</div>

	<div id="footer">
		<ul class="servicenavigation">
			<li class="terms"><a href="/vilkaar">Vilkår</a></li>
		</ul>

		<p><a href="https://think.dk">&lt;aliens&gt;we are all&lt;/aliens&gt;</a></p>
	</div>

</div>

</body>
</html>