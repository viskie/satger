<?

if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)

{

	header("location: index.php");

	exit();

}

$path = PATH;







?>

<style>

td div.no_break{

	word-wrap:break-word;

	white-space:nowrap;

}

</style>

<script>



$(document).ready(function(e) {

	$( "#report_from_date" ).datepicker({

	

		dateFormat: "d-M-yy",

		altField: "#report_from_date_alt",

		altFormat: "yy-mm-dd",

		changeMonth: true,

		changeYear: true,

		onClose: function( selectedDate ) {

					$( "#report_to_date" ).datepicker( "option", "minDate", selectedDate );

					

				}

	});

	

	$( "#report_to_date" ).datepicker({

		dateFormat: "d-M-yy",

		altField: "#report_to_date_alt",

		altFormat: "yy-mm-dd",

		changeMonth: true,

		changeYear: true,

		onClose: function( selectedDate ) {

						$( "#report_from_date" ).datepicker( "option", "maxDate", selectedDate );

						

					}

	});

	

	

	$(".close_child_page,.open_child_page").click(function(){

			//$(this).parent().find(".list").slideToggle();

			$('#list').slideToggle();

			$(this).toggleClass("close_child_page");

			$(this).toggleClass("open_child_page");	

			

	

	 });

		 

	$("#switch_on").click(function(){

		var this_element=$(this);

		$("#list input.users").each(function() {

			$(this).attr('checked','checked').change();

		});

		

		$("ul li").removeClass("on");

		$(this_element).parent().addClass("on");

		return false;

	});

	$("#switch_off").click(function(){

		var this_element=$(this);

		$("#list input.users").each(function() {

			$(this).removeAttr('checked').change();

		});

		

		$("ul li").removeClass("on");

		$(this_element).parent().addClass("on");

		return false;

	});

	

	$("#list input.users").change(function(){

		if($("#list input.users:checked").length===$("#list input.users").length){

			$("#switch_on").parent(this).addClass("on");

			$("#switch_off").parent(this).removeClass("on");				

		}else if($("#list input.users:checked").length===0){

			$("#switch_off").parent(this).addClass("on");

			$("#switch_on").parent(this).removeClass("on");	

		}else{

			$("ul li").removeClass("on");

		}

	});

	

	<?

	if(isset($_REQUEST['is_post_back']) && $_REQUEST['is_post_back']=="TRUE"){

		?>

		if($("#list input.users:checked").length===0)

		{

			$("#switch_off").parent(this).addClass("on");

			$("#switch_on").parent(this).removeClass("on");

		}

		if($("#list input.users:checked").length!==0 && $("#list input.users:checked").length!==$("#list input.users").length)

		{

			$("#switch_off").parent(this).removeClass("on");

			$("#switch_on").parent(this).removeClass("on");

		}

		if($("#list input.users:checked").length===$("#list input.users").length){

			$("#switch_on").parent(this).addClass("on");

			$("#switch_off").parent(this).removeClass("on");				

		}

		<?

	}

	?>

	 <?	if(isset($start_date)){?>

			$("#report_from_date").datepicker('setDate', parseISO8601(<?= "\"".$start_date."\""?>));

	<?	} ?>

	

	<?	if(isset($end_date)){?>

			$("#report_to_date").datepicker('setDate', parseISO8601(<?= "\"".$end_date."\""?>));

	<?	} ?>

	

	<?	if(isset($alignment)){?>

			$("#alignment").val("<?=$alignment?>");

	<?	} ?>

	 $("#alignment").change();

	 

	

});

</script>

					<!-- Content -->

					<div id="content" class="clearfix">



                     <?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>

                        <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  

                      <? }  else  if($notificationArray['type'] == "Failed") { ?>

                      <div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>

                      <?   } } ?>

                      

                      

                      

                        <!-- Main Content -->

                        <div id="main-content">



                            <!-- All Users -->

                            <h2>Attendance Reports</h2>

                            

                            <div class="body-con">

                                <div id="dates" style="float:left;text-align:center;width:35%;">

                                    <label class="up-align" style="max-width:50px;">From</label>

                                    <input type="text" id="report_from_date" style="max-width:120px;" />

                                    <input type="hidden" id="report_from_date_alt" name="start_date" />

                                    <label class="up-align" style="max-width:50px;">To</label>

                                    <input type="text" id="report_to_date" style="max-width:120px;" />

                                    <input type="hidden" id="report_to_date_alt" name="end_date" />

                                </div>

                                

                                <div id="report_alignment" style="float:left;text-align:center;width:28%;margin-left:1%">

                                    <label class="up-align" style="max-width:100px">Report Alignment</label>

                                    <select id="alignment" name="alignment" >

                                        

                                        <option value="Horizontal">Horizontal</option>

                                        <option value="Vertical">Vertical</option>

                                    </select>

                                </div>

                            	<div style="float:left;position:relative;text-align:center;width:27%;margin-left:1%">

                                    <div class="label_with_button" >

                                        <div style="float:left;">

                                        	<span  class="close_child_page" style="height:40px;margin-left: 25px;"></span>

                                        	<label class="up-align" style="max-width:50px;">Employee</label>

                                        </div>

                                        <div style="float:left;">

                                            <ul class="switch_container" id="on_off_btn" style="margin:0px">

                                                <li class="on"><a id="switch_off" href="#">None</a></li>

                                                <li ><a id="switch_on" href="#">All</a></li>

                                            </ul>

                                        </div>

                                        <div style="clear:both;"></div>

                                    </div>

                                    

                                    

                                    <div id="list" style="display:none">

                                    <?

                                    //var_dump($data['users']);exit;

                                    $users = $data['users'];

                                    //var_dump(count($users));exit;

                                    for($i=0;$i<count($users);$i++){?>

                                        <div style="float:left;min-width:170px;"><input type="checkbox" name="users[]" class="users" value="<?=$users[$i]['user_id'] ?>" 

                                        <?php 

                                        if(isset($data['requested_users']))

                                        {

                                            if(in_array($users[$i]['user_id'],$data['requested_users']))

                                            { echo "checked"; } 

                                            }

                                        ?> /><?=$users[$i]['name'] ?></div>

                                    <?	} ?>

                                    </div>

                                </div>



                                <div style="clear:both;"></div>

                           

                            <div>

								<div style="text-align:center;padding:4px;">

                                    <input type="hidden" name="is_post_back" id="is_post_back" value="FALSE" />

                                    <input type="submit" name='report_submit' value="Submit" id="report_submit" onclick="$('#is_post_back').val('TRUE');callPage('hrm','reports');" />

                                </div>

                                <div style="clear:both;"></div>

                            </div>                            

                            

                            <div class="tbreport">

                            <?

							

							//var_dump(count($data['requested_users']));exit;

							if(isset($data['alignment']))

							{

								if($data['alignment'] == 'Horizontal')

								{?>

                                	<div class="report_head">Report</div>

									<table cellpadding="0" cellspacing="0" border="0" width="100%" aria-describedby="example_info" style="width: 100%;">

                                    <tr>

									<td style="font-weight:bold">Users/Date</td>

									<?

									for($i=0;$i<count($data['dates']);$i++)

									{

										echo "<td style=font-weight:bold>".formatDate($data['dates'][$i])."</td>";

									}

									?>

                                    <td style="font-weight:bold">Total Time</td>

									</tr>

                                    

                                    <?

									$main_array = array();

									$approved_status = array();

									$in_times=array();

									$out_times=array();

									foreach($data['UsersLoginDetails'] as $record)

									{	

										//$seconds = getDateTimeDiff($record['out_time'] ,$record['in_time']);

										$main_array[$record['user_id']][date('Y-m-d',strtotime($record['in_time']))] = $record['seconds'];

										$approved_status[$record['user_id']][date('Y-m-d',strtotime($record['in_time']))] = $record['approved'];

										$in_times[$record['user_id']][date('Y-m-d',strtotime($record['in_time']))] = $record['in_time_only'];

										$out_times[$record['user_id']][date('Y-m-d',strtotime($record['in_time']))] = $record['out_time_only'];

									}

									

									for($i=0;$i<count($data['requested_users']);$i++)

									{	$total_time = 0;

									//var_dump($data['requested_users']);exit;

											echo "<tr>";

									

										echo "<td style=font-weight:bold>".$data['user_names'][$i]['name']."</td>";

										for($j=0;$j<count($data['dates']);$j++)

										{

											if(isset($main_array[$data['requested_users'][$i]][$data['dates'][$j]]))

											{	

												$new_diff = secondsToTime($main_array[$data['requested_users'][$i]][$data['dates'][$j]],true);

												$w_h =   $new_diff['h'].":". $new_diff['m'].":". $new_diff['s'];
												$format_in_time =  date('h:i A', strtotime($in_times[$data['requested_users'][$i]][$data['dates'][$j]]));
												$format_out_time =  date('h:i A', strtotime($out_times[$data['requested_users'][$i]][$data['dates'][$j]]));
												?>

                                                <td><?="<div class='no_break'>".$format_in_time."</div><div class='no_break'>".$format_out_time."</div><div>".$w_h."</div>"?><span id="working_hours" title="Sent for Approval" class="box_16px

                                                <? 

												if($new_diff['h']>10 && $approved_status[$data['requested_users'][$i]][$data['dates'][$j]]=='0')

												{echo " img_exclamation\"";

												}

												else

												{echo "\"";

												}

												?>

												></span></td>

                                                <?

												$total_time = $total_time + $main_array[$data['requested_users'][$i]][$data['dates'][$j]];

												//var_dump($total_time);exit;

											}

											else

											{

												echo "<td>-</td>";

												$total_time = $total_time + 0;

											}

										}

										$new_diff = secondsToTime($total_time,true);

										$w_h =   $new_diff['h'].":". $new_diff['m'].":". $new_diff['s'];

										echo "<td style=font-weight:bold>".$w_h."</td>";

										echo "</tr>";

									}

									

									?>

                                   

                                    

									</table>

                                    

								 <?

								 

								}

								

								/********* */

								

								if($data['alignment'] == 'Vertical')

								{?>

									<table cellpadding="0" cellspacing="0" border="0" width="100%" aria-describedby="example_info" style="width: 100%;">

									<tr>

									<td style="font-weight:bold">Date/Users</td>

									<?

									for($i=0;$i<count($data['requested_users']);$i++)

									{

										echo "<td style=font-weight:bold>".$data['user_names'][$i]['name']."</td>";

									}

									?>

                                    

									</tr>

                                    

                                    <?

									$main_array = array();

									$approved_status = array();

									$in_times=array();

									$out_times=array();

									foreach($data['UsersLoginDetails'] as $record)

									{	

										$main_array[date('Y-m-d',strtotime($record['in_time']))][$record['user_id']] = $record['seconds'];

										$approved_status[date('Y-m-d',strtotime($record['in_time']))][$record['user_id']] = $record['approved'];

										$in_times[date('Y-m-d',strtotime($record['in_time']))][$record['user_id']] = $record['in_time_only'];

										$out_times[date('Y-m-d',strtotime($record['in_time']))][$record['user_id']] = $record['out_time_only'];

									}

									

									for($i=0;$i<count($data['dates']);$i++)

									{	

										echo "<tr>";

										echo "<td style=font-weight:bold>".formatDate($data['dates'][$i])."</td>";

										for($j=0;$j<count($data['requested_users']);$j++)

										{	

											if(isset($main_array[$data['dates'][$i]][$data['requested_users'][$j]]))

											{	

												$new_diff = secondsToTime($main_array[$data['dates'][$i]][$data['requested_users'][$j]],true);

												$w_h =   $new_diff['h'].":". $new_diff['m'].":". $new_diff['s'];
												$format_in_time =  date('h:i A', strtotime($in_times[$data['dates'][$i]][$data['requested_users'][$j]]));
												$format_out_time =  date('h:i A', strtotime($out_times[$data['dates'][$i]][$data['requested_users'][$j]]));
												?>

                                                <td><?="<div class='no_break'>".$format_in_time."</div><div class='no_break'>".$format_out_time."</div><div>".$w_h."</div>"?><span id="working_hours" title="Sent for Approval" class="box_16px

                                                <? 

												if($new_diff['h']>10 && $approved_status[$data['dates'][$i]][$data['requested_users'][$j]]=='0')

												{echo " img_exclamation\"";

												}

												else

												{echo "\"";

												}

												?>

												></span></td>

                                                <?

											}

											else

											{echo "<td>-</td>";

											}

											

										}

										

										echo "</tr>";

									}

									echo "<tr><td style=font-weight:bold>Total Time</td>";

									

									for($j=0;$j<count($data['requested_users']);$j++)

										{	$status = '';

											foreach($data['UserwiseSeconds'] as $record)

											{

												if($data['requested_users'][$j]==$record['user_id'])

												{

													$new_diff = secondsToTime($record['seconds'],true);

													$w_h =   $new_diff['h'].":". $new_diff['m'].":". $new_diff['s'];

													$status =true;break;

												}

												else

												{	$status = false;

												}

											}

											if($status==true)

											{	echo "<td style=font-weight:bold>".$w_h."<span id=\"working_hours\" title=\"Sent for Approval\" class=\"box_16px\"></span></td>";

											}

											else

											{	echo "<td style=font-weight:bold>00:00:00</td>";

											}

										}

										echo "</tr>";

									?>

                                   </table>

                                 <?

								}

							}

							?>

                            	</div>

                             </div>

                        </div>

                        <!-- END Main Content -->



					</div>

					<!-- END Content -->