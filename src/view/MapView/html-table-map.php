<?php
/**
 * @var array $headers
 * @var array $rows
 */
?>
<div class="palmtree-game-of-life">
	<table class="palmtree-game-of-life-table">
		<thead>
		<?php foreach ( $headers as $row ) { ?>
			<tr>
				<?php foreach ( $row as $column ) { ?>
					<td><?php echo $column; ?></td>
				<?php } ?>
			</tr>
		<?php } ?>
		</thead>
		<tbody>
		<?php foreach ( $rows as $row ) { ?>
			<tr>
				<?php foreach ( $row as $column ) { ?>
					<td><?php echo $column; ?></td>
				<?php } ?>
			</tr>
		<?php } ?>
		</tbody>
	</table>
</div>
<script>
	(function() {
		var conn = new WebSocket( 'ws://localhost:8000' );
		conn.onopen = function( e ) {
			console.log( 'Connection established!' );

			conn.send( 'update' );
		};

		conn.onmessage = function( e ) {
			var table = document.querySelector( '.palmtree-game-of-life-table' );

			if ( e.data.length ) {
				console.log( 'replacing' );
				table.parentNode.parentNode.replaceChild( createElement( e.data ), table.parentNode );
				conn.send( 'updating' );
			} else {
				conn.close();
				console.log('complete');
			}
		};

		function createElement( html ) {
			var div = document.createElement( 'div' );

			div.innerHTML = html;

			return div.firstChild;
		}
	})();
</script>
