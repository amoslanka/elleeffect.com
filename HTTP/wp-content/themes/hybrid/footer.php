			<?php hybrid_after_content(); // After content hook ?>

		</div>

		<?php hybrid_after_container(); // After container hook ?>

	</div>

	<div id="footer-container">

		<?php hybrid_before_footer(); // Before footer hook ?>

		<div id="footer">

			<?php hybrid_footer(); // Hybrid footer hook ?>

			<?php wp_footer(); // WordPress footer hook ?>

		</div>

		<?php hybrid_after_footer(); // After footer hook ?>

	</div>

</div>

</body>
</html>