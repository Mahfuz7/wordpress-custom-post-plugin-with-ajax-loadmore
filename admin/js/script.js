jQuery(document).ready(function($) {


	$('.load_more:not(.loading)').live('click',function(e){

		e.preventDefault();
		var $load_more_btn 	= $(this);
		var post_type 		= 'projects';
		var offset 			= $('#posts_list .single-article').length;
		var nonce 			= $load_more_btn.attr('data-nonce');

		$.ajax({
        	type : "post",
        	context: this,
         	dataType : "json",
         	url : headJS.ajaxurl,
			data : {

				action : "load_more",
				offset : offset,
				nonce : nonce,
				post_type : post_type,
				posts_per_page : headJS.posts_per_page

			},
         	beforeSend: function(data) {
				$load_more_btn.addClass('loading').html('Loading...');
         	},
         	success: function(response) {

				if ( response['have_posts'] == 1 ){

					$load_more_btn.removeClass('loading').html('Load More');
					var $newElems = $(response['html'].replace(/(\r\n|\n|\r)/gm, ''));
					$('#posts_list').append($newElems);

				} else {

					$load_more_btn.removeClass('loading').addClass('end_of_posts').html('<span>No more posts found!</span>').fadeOut(1000);

				}

         	}
      	});

	});

});