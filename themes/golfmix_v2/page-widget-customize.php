<?php
/**
 * Template Name: Customize Widget
 *
 */

get_header(); ?>

		<div id="content">
      <div class="content-data" style="width:100%;">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<?php edit_post_link( __( 'Edit', 'twentyten' ), '<span class="edit-link">', '</span>' ); ?>

	<h1><?php the_title(); ?></h1>
				
	<div class="blog" style="width:500px;float:left">	
		<form id="search-widget">
          <h3>Find your Course</h3>
          <label><input class="text" type="text" size="50" id="sf_course"></label>

          <h3>Choose Widget Style</h3>
          <select id="sf_style" name="sf_style">
			  <option value="" selected="selected">Orange</option>
			  <option value="g">Grey</option>
		  </select>

          <h3>Choose Widget Type</h3>
          <select id="sf_type">
			  <option value="" selected="selected">Overall Star Rating</option>
			  <option value="all">All Star Ratings</option>
			  <option value="review">Highlighted Review</option>
		  </select>

          <h3>Highlighted Review ID</h3>
          <label><input class="text" type="text" size="4" id="sf_review" value=""></label>
          <span>(Optional)</span>

          <h3>Widget Dimensions</h3>
          <label><input class="text" type="text" size="4" id="sf_width" value="340"></label>
          <span>Width (in px)</span>

          <h3>Height Dimensions</h3>
          <label><input class="text" type="text" size="4" id="sf_height" value="195"></label>
          <span>Height (in px)</span>
          
          <div id="clear"></div>
          <input type="submit" value="Finish & Grab Code">
        </form>
	
		<br class="clear" />	
	 </div>
	 
	 <script>
	 $(document).ready(function() {	
	 		 					
		$("input#sf_course").keyup(function(){
		  var liveText = $(this).val();
		  var style = $("#sf_style option:selected").val();
		  var type = $("#sf_type option:selected").val();
		  var width = $("input#sf_width").val();
		  var height = $("input#sf_height").val();
		  var reviewID = $("input#sf_review").val();

		  $.ajax({
		  	   beforeSend: function(){ $('#loader_w').show(); },
			   type: "POST",
			   url: "<?php bloginfo('template_url');?>/find-course-id.php",
			   data: "s="+liveText+"&width="+width+"&height="+height+"&style="+style+"&type="+type+"&review="+reviewID,
			   success: function(html){
			     $("#results").html(html);
			     
			   },
			   complete: function(){ $('#loader_w').hide(); var newHeight = $(".gm_widget",top.document).contents().height(); $("input#sf_height").val(newHeight);}
		  });
		  
		  $("#code").hide();
		  		  
		});
		
		$("#sf_style").change(function(){
		  var style = $("#sf_style option:selected").val();
		  var type = $("#sf_type option:selected").val();
		  var width = $("input#sf_width").val();
		  var height = $("input#sf_height").val();
		  var postID = $(".gm_widget").attr("id");
		  var reviewID = $("input#sf_review").val();
		
		   $.ajax({
		  	   beforeSend: function(){ $('#loader_w').show(); },
			   type: "POST",
			   url: "<?php bloginfo('template_url');?>/find-course-id.php",
			   data: "width="+width+"&height="+height+"&id="+postID+"&style="+style+"&type="+type+"&review="+reviewID,
			   success: function(html){
			     $("#results").html(html);
			   },
			   complete: function(){ $('#loader_w').hide(); var newHeight = autoDetectHeight(); $("input#sf_height").val(newHeight);}
		  });
		  
		  $("#code").hide();
		  
		});

		$("#sf_type").change(function(){
		  var style = $("#sf_style option:selected").val();
		  var type = $("#sf_type option:selected").val();
		  var width = $("input#sf_width").val();
		  var height = $("input#sf_height").val();
		  var postID = $(".gm_widget").attr("id");
		  var reviewID = $("input#sf_review").val();
		
		  if(type == 'review') { 
		  	var reviewID = $("input#sf_review").val();
		  	if(reviewID == '') { alert('Please enter review ID'); return false; }	
		  }
			
		   $.ajax({
		  	   beforeSend: function(){ $('#loader_w').show(); },
			   type: "POST",
			   url: "<?php bloginfo('template_url');?>/find-course-id.php",
			   data: "width="+width+"&height="+height+"&id="+postID+"&style="+style+"&type="+type+"&review="+reviewID,
			   success: function(html){
			     $("#results").html(html);
			   },
			   complete: function(){ $('#loader_w').hide(); var newHeight = autoDetectHeight(); $("input#sf_height").val(newHeight);}
		  });
		  
		  $("#code").hide();
		  
		});
		
		$("input#sf_width").keyup(function(){
		  var style = $("#sf_style option:selected").val();
		  var type = $("#sf_type option:selected").val();
		  var width = $("input#sf_width").val();
		  var height = $("input#sf_height").val();
		  var postID = $(".gm_widget").attr("id");
		  var reviewID = $("input#sf_review").val();
		 
		   $.ajax({
		  	   beforeSend: function(){ $('#loader_w').show(); },
			   type: "POST",
			   url: "<?php bloginfo('template_url');?>/find-course-id.php",
			   data: "width="+width+"&height="+height+"&id="+postID+"&style="+style+"&type="+type+"&review="+reviewID,
			   success: function(html){
			     $("#results").html(html);
			     $("#results div").css('width',width+'px');
			   },
			   complete: function(){ $('#loader_w').hide(); }
		  });
		  
		  $("#code").hide();
		  
		});

		$("input#sf_height").keyup(function(){
		  var style = $("#sf_style option:selected").val();
		  var type = $("#sf_type option:selected").val();
		  var width = $("input#sf_width").val();
		  var height = $("input#sf_height").val();
		  var postID = $(".gm_widget").attr("id");
		  var reviewID = $("input#sf_review").val();
		 
		   $.ajax({
		  	   beforeSend: function(){ $('#loader_w').show(); },
			   type: "POST",
			   url: "<?php bloginfo('template_url');?>/find-course-id.php",
			   data: "width="+width+"&height="+height+"&id="+postID+"&style="+style+"&type="+type+"&review="+reviewID,
			   success: function(html){
			     $("#results").html(html);
			     $("#results div").css('width',width+'px');
			   },
			   complete: function(){ $('#loader_w').hide(); }
		  });
		  
		  $("#code").hide();
		 
		});
		
		$("input#sf_review").keyup(function(){
		  var style = $("#sf_style option:selected").val();
		  var type = $("#sf_type option:selected").val();
		  var width = $("input#sf_width").val();
		  var height = $("input#sf_height").val();
		  var postID = $(".gm_widget").attr("id");
		  var reviewID = $("input#sf_review").val();
		 
		   $.ajax({
		  	   beforeSend: function(){ $('#loader_w').show(); },
			   type: "POST",
			   url: "<?php bloginfo('template_url');?>/find-course-id.php",
			   data: "width="+width+"&height="+height+"&id="+postID+"&style="+style+"&type="+type+"&review="+reviewID,
			   success: function(html){
			     $("#results").html(html);
			   },
			   complete: function(){ $('#loader_w').hide(); var newHeight = autoDetectHeight(); $("input#sf_height").val(newHeight);}
		  });
		  
		  $("#code").hide();
		 
		});

			
		// so it won't submit
	    $("#search-widget").submit(function () { 
			var text = $("#results div").html();
			$("#code").text(text).show();	    	
			return false; 
	    }); 
	
	});
	</script>
	 
	 <div class="blog custom_widget">
		 <div id="loader_w"></div>
		 <div id="results"></div>
		 <div id="code"></div>	
	 </div>

<?php endwhile; // end of the loop. ?>
</div>


      <br class="clear" />
    </div>
    <!--/content-->

<?php get_footer(); ?>
