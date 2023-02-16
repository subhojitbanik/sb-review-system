<?php

function sb_show_review_form_fn(){
    $iRequest = $_POST['RequestId'];
    // $iStudent = $_POST['StudentId'];
    $iTutor   = $_POST['TutorId'];

        global $wpdb;
        if (is_user_logged_in()) {
            $user = wp_get_current_user();
            $role = $user->roles[0];
            
            if ($role == 'student') { ?>
                <?php
                      
                    if(isset($_POST['submit'])){
                        //$tutor_id = $iTutor;
                        $tutor_id = $_POST['tutor_id'];
                        $ratings = $_POST['ratings'];
                        $reviews = $_POST['reviews'];
                        $student_id = get_current_user_id();
                        $request_id = $_POST['request_id'];

                        $table_name = $wpdb->prefix . "reviews_table";
                        $sql = $wpdb->insert($table_name, array(
                            "review_content" => $reviews,
                            "review_ratings" => $ratings,
                            "student_id" => $student_id,
                            "tutor_id" => $tutor_id,
                            "request_id" => $request_id
                        ));

                    }
                    ob_start();  
                    echo 'hello world!';
                ?>
                <div class="review_form">
                    <?php 
                        // if($sql == 1) {
                        //     //do_action( 'after_sb_review_submit', $tutor_id,$student_id,$request_id );
                        //     echo'<h3>Review submitted succesfully!</h3>';
                            
                        // }
                        echo $sql;

                    ?>
                    <form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post">
                        <label for="">Select Ratings</label>
                        <select id="ratings" name="ratings" style="display:none;">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>

                        <section class='rating-widget'>
                        <!-- Rating Stars Box -->
                            <div class='rating-stars text-center'>
                                <ul id='stars'>
                                    <li class='star' title='Poor' data-value='1'>
                                        <i class='fa fa-star fa-fw'></i>
                                    </li>
                                    <li class='star' title='Satisfactory' data-value='2'>
                                        <i class='fa fa-star fa-fw'></i>
                                    </li>
                                    <li class='star' title='Fair' data-value='3'>
                                        <i class='fa fa-star fa-fw'></i>
                                    </li>
                                    <li class='star' title='Good' data-value='4'>
                                        <i class='fa fa-star fa-fw'></i>
                                    </li>
                                    <li class='star' title='Excellent' data-value='5'>
                                        <i class='fa fa-star fa-fw'></i>
                                    </li>
                                </ul>
                            </div>
                        </section>
                        
                        <style>

                            .new-react-version {
                            padding: 20px 20px;
                            border: 1px solid #eee;
                            border-radius: 20px;
                            box-shadow: 0 2px 12px 0 rgba(0,0,0,0.1);
                            
                            text-align: center;
                            font-size: 14px;
                            line-height: 1.7;
                            }

                            .new-react-version .react-svg-logo {
                            text-align: center;
                            max-width: 60px;
                            margin: 20px auto;
                            margin-top: 0;
                            }

                            /* Rating Star Widgets Style */
                            .rating-stars ul {
                            list-style-type:none;
                            padding:0;
                            
                            -moz-user-select:none;
                            -webkit-user-select:none;
                            }
                            .rating-stars ul > li.star {
                            display:inline-block;
                            
                            }

                            /* Idle State of the stars */
                            .rating-stars ul > li.star > i.fa {
                            font-size:1.5em; /* Change the size of the stars */
                            color:#ccc; /* Color on idle state */
                            }

                            /* Hover state of the stars */
                            .rating-stars ul > li.star.hover > i.fa {
                            color:#FFCC36;
                            }

                            /* Selected state of the stars */
                            .rating-stars ul > li.star.selected > i.fa {
                            color:#FF912C;
                            }

                        </style>
                        <script>
                            jQuery(document).ready(function($){
                                
                                /* 1. Visualizing things on Hover - See next part for action on click */
                                $('#stars li').on('mouseover', function(){
                                    var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
                                
                                    // Now highlight all the stars that's not after the current hovered star
                                    $(this).parent().children('li.star').each(function(e){
                                    if (e < onStar) {
                                        $(this).addClass('hover');
                                    }
                                    else {
                                        $(this).removeClass('hover');
                                    }
                                    });
                                    
                                }).on('mouseout', function(){
                                    $(this).parent().children('li.star').each(function(e){
                                    $(this).removeClass('hover');
                                    });
                                });
                                
                                
                                /* 2. Action to perform on click */
                                $('#stars li').on('click', function(){
                                    var onStar = parseInt($(this).data('value'), 10); // The star currently selected
                                    var stars = $(this).parent().children('li.star');
                                    
                                    for (i = 0; i < stars.length; i++) {
                                    $(stars[i]).removeClass('selected');
                                    }
                                    
                                    for (i = 0; i < onStar; i++) {
                                    $(stars[i]).addClass('selected');
                                    }
                                    
                                    // JUST RESPONSE (Not needed)
                                    var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
                                    
                                    $("#ratings").val(ratingValue);
                                    
                                });
                                
                                
                            });
                        </script>
	
                        <label for="">Reviews</label>
                        <textarea name="reviews" cols="30" rows="10"></textarea>
                        <input type="hidden" name="tutor_id" value="<?php _e($iTutor);?>">
                        <input type="hidden" name="request_id" value="<?php _e($iRequest);?>">
                        <input type="submit" name="submit" value="Submit">
                    </form>
                </div>
                <?php
                return ob_get_clean();
            }
            
        }
    
}
add_shortcode( 'sb_show_review_form', 'sb_show_review_form_fn' );


/*
function sb_review_fn(){
    ob_start();
    if (is_user_logged_in()) {
        $user = wp_get_current_user();
        $role = $user->roles[0];
        //echo SB_CHAT_PLUGIN_FILE;        
        //print_r($user) ;   
         $sender_id = $user->ID;
        // $receiver_id ='108';
        // $review='1';
        //sb_insert_review_fn($sender_id,$receiver_id,$review); 
		if ($role == "tutor") {?>
            <!-- <link href="https://s3.amazonaws.com/codecademy-content/projects/bootstrap.min.css" rel="stylesheet"> -->
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="review">
                            <div class="review-menu">
                                <?php 
                                    _e(do_shortcode('[sb_show_review]'));
                                ?>
                                <script>
									jQuery(document).ready(function($)
                                    {
                                        $('.btnreviews').change(function() 
                                        {
                                            var iId = ($(this).attr("id").replace("ddContent", ""));
											jQuery.ajax(
											{

												url: "<?php echo admin_url('admin-ajax.php'); ?>",

												method: "POST",

												data: {
													
													'action'  : 'review',
													'ReviewId': iId,
													'Status'  : $(this).val( )

												},

												success: function(resdata) {

													console.log(resdata);
                                                    location.reload(true);
													//window.location.href = "<?php echo home_url() ?>";

												},

												error: function(e) {

													console.log(resdata);

												},

											});
										});
									});
								
                                </script>
                            </div>
                        </div>
                    </div>    
                </div>
            </div>
            <?php
            return ob_get_clean();
        }
	}
} 
add_shortcode( 'sb_review', 'sb_review_fn' );
add_action('sb_review', 'sb_review_fn');


function sb_show_review_fn()
{
    global $wpdb;  
    $table_name = $wpdb->prefix . "reviews_table";

    if(is_user_logged_in()){
        $user = wp_get_current_user();
        
		$iTutorId = $user->ID;
		
       // $results = $wpdb->get_results("SELECT * FROM $table_name WHERE status='0' ORDER BY date_time DESC ");
        $results = $wpdb->get_results("SELECT * FROM $table_name WHERE tutor_id = $iTutorId ORDER BY date_time DESC ");
		//$results = $wpdb->get_results("SELECT * FROM $table_name WHERE tutor_id = $sb_users[0] AND status='0' ORDER BY date_time DESC ");
    
        //echo'<pre>';print_r($results); echo'</pre>';
        //$results = $wpdb->get_results("SELECT * FROM $table_name WHERE  status='0' ORDER BY date_time DESC ");
		?>
        <table class="table-bordered table-responsive">
            <thead>
                <th>Review Content</th>
                <th>Review Rating</th>
                <th>Status</th>
                <th>Action</th>
            </thead>
            <tbody>

                <?php
                if (!empty($results)) {
                    foreach($results as $result){
                        $user_info = get_user_meta($result->iTutorId);
                        //print_r($results);
                        $iReviewId      =  $result->review_ID;
                        $sReviewContent =  $result->review_content;
                        $sReviewRatings =  $result->review_ratings;
                        $iStudentId 	=  $result->student_id;
                        $iRequestId	 	=  $result->request_id;
                        $iStatus 	 	=  $result->status;
                
                        $sSelect =  "<select id=ddContent{$iReviewId} name=ddContent{$iReviewId} class='btnreviews' style='max-width:100%'><option value='1' ".(($iStatus == 1)? "selected" : "")." >Approve</option><option value='0' ".(($iStatus == 0)? "selected" : "").">Reject</option></select>";
                        
                        //$review = 'Review Content '.$sReviewContent.' Review Rating '.$sReviewRatings.' Status '.$iStatus. $sSelect.'</br><hr>';  
                        ?>
                        
                            <!-- <li><h3><?php echo $review; ?></h3> -->
                            <tr>
                                <td><?php echo $sReviewContent; ?></td>
                                <td><?php echo $sReviewRatings; ?></td>

                                <td><?php echo ($iStatus == 1) ? 'Public':'Private'; ?></td>

                                <td><?php echo $sSelect; ?></td>
                            </tr>
                        <?php
                        
                    }
                    
                }?>
        
            </tbody>
        </table>
        <?php
		
    }


}
add_shortcode( 'sb_show_review', 'sb_show_review_fn' );




function sb_show_reviews_public_fn(){

    $profile_id = get_the_ID();
    $sb_users = get_users( array(
        "meta_key" => "profile_id",
        "meta_value" => $profile_id,
        "fields" => "ID"
    ) );

    global $wpdb;
    $table_name = $wpdb->prefix . "reviews_table";

    $results = $wpdb->get_results("SELECT * FROM $table_name WHERE tutor_id = $sb_users[0] AND status='1' ORDER BY date_time DESC ");

    // echo'<pre>';print_r($results); echo'</pre>';
    
    ob_start();
    if (!empty($results)) { ?>
        <div class="slideshow-container your-class">
            <?php
            foreach($results as $result){
                $iReviewId      =  $result->review_ID;
                $sReviewContent =  $result->review_content;
                $sReviewRatings =  $result->review_ratings;
                $iStudentId 	=  $result->student_id;
                $iRequestId	 	=  $result->request_id;

                $stu_data = get_userdata( $iStudentId );
                
                $first_name = $stu_data->first_name;
                $last_name = $stu_data->last_name;

                // $review = 'Review Content '.$sReviewContent.' Review Rating '.$sReviewRatings.'</br><hr>';  
                ?>
                    <div class="mySlides">
                        <q><?php _e($sReviewContent) ;?></q>
                        <p>
                            <?php for($i=1; $i<= $sReviewRatings; $i++ ){
                                echo '<span class="fa fa-star checked"></span>';
                            } ?>
                        </p>
                        <p>Ratings: <?php echo $sReviewRatings; ?>/5</p>
                        <p class="author">- <?php echo $first_name .' '.$last_name; ?></p>
                    </div>
                    
                <?php
            }?>
        </div>
        <script type="text/javascript">
                jQuery(document).ready(function($){
                    $('.your-class').slick({
                        //setting-name: setting-value
                        infinite: true,
                        //variableWidth: true,
                        responsive: [
                                        {
                                        breakpoint: 1024,
                                            settings: {
                                                slidesToShow: 3,
                                                centerMode: true,
                                            }
                                        },
                                        {
                                        breakpoint: 600,
                                            settings: {
                                                slidesToShow: 2,
                                                slidesToScroll: 2,
                                                centerMode: true,
                                            }
                                        },
                                        {
                                        breakpoint: 480,
                                            settings: {
                                                slidesToShow: 1,
                                                slidesToScroll: 1,
                                                centerMode: true,
                                            }
                                        }
          
                                    ],
                        centerMode: true,
                        centerPadding: '60px',
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        autoplay: true,
                        autoplaySpeed: 2000,
                        arrows:false,
                    });
                });
            </script>
       <?php
    }else{
        echo '<h2 style="text-align: center;color: #042d59;">No reviews yet!</h2>';
    }

    return ob_get_clean();
}
add_shortcode( 'sb_show_reviews_public', 'sb_show_reviews_public_fn' );



add_action( 'wp_ajax_review', 'ReviewAjax' );
add_action( 'wp_ajax_nopriv_review', 'ReviewAjax' );

function ReviewAjax() 
{
	global $wpdb;
	
	if ( isset($_POST) ) 
	{
		$iReviewId = intval($_POST['ReviewId']);
		$iStatus   = $_POST['Status'];

        //print $iRequestId."==".$iStatus;
		if($iReviewId == 0) 
		{
			print "failed";
			
			return;
		}
		else
		{
			$sTable = $wpdb->prefix."reviews_table";
			
			//$rows   = $wpdb->update("UPDATE $sTable SET status='$iStatus' WHERE id = '$iReviewId'");
			
			$rows   = $wpdb->update($sTable, array( "status" => $iStatus), array('review_ID' => $iReviewId));
		
			if ($rows)
			{
				print "UPDATE $sTable SET status='$iStatus' WHERE review_ID = '$iReviewId'";
			}
			else
			{
				print "UPDATE $sTable SET status='$iStatus' WHERE review_ID = '$iReviewId'";
			}
		}
	die( );
	}
}
*/

/* 
 if (isset($_POST[remarks])) {

        global $wpdb;

        $table_name = $wpdb->prefix . "sb_video_app_details";

        $wpdb->update($table_name, array(

            "remarks" => $_POST[remarks],

        ), array('request_id' => $_SESSION['req_id']));

        do_action('sb_video_after_update_remark', $_POST['remarks'], $_SESSION['req_id']);

        die();

    } */