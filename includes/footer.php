		<footer class="footer">FOOTER</footer>
	</div>
	<?php include( ROOT_DIR . '/includes/debug-output.php'); ?>

<?php if( $logged_in_user ){ ?>
	<script>
		//like, unlike
		document.body.addEventListener( 'click', function( e ){
			if( e.target.className == 'heart-button' ){
				// console.log( e.target.dataset.postid );
				likeUnlike( e.target );
			}
		} );

		async function likeUnlike( el ){
			let postId = el.dataset.postid,
					userId = <?php echo $logged_in_user[ 'user_id' ]; ?>;
			//get the parent container so we can update the interface later
			let container = el.closest( '.likes' );

			let formData = new FormData();
											//name     value
			formData.append( 'postId', postId );
			formData.append( 'userId', userId );

			let response = await fetch( 'fetch-handlers/like-unlike.php', {
				method: 'POST',
				body: formData
			} );
			//feedback
			if( response.ok ){
				let result = await response.text();
				container.innerHTML = result;
			}else{
				console.log( response.status );
			}
		}
	</script>

	<script>
		//follow interaction
		document.body.addEventListener('click', function( e ){
			if( e.target.classList.contains( 'follow-button' ) ){
				follow( e.target );
			}
		} );

		async function follow( el ){
			let to = el.dataset.to;
			console.log(to);

			let data = new FormData();
			data.append( 'to', to );

			let response = await fetch( 'fetch-handlers/follow.php', {
				method: 'POST',
				body: data
			} );
			if( response.ok ){
				let output = await response.text();
				//update the container div
				document.getElementById( 'follow-info' ).innerHTML = output;
			}else{
				console.log( response.status );
			}
		}
	</script>
<?php } //end if logged in ?>
</body>
</html>