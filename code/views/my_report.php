<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}


?>
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
	 
	 <?	if(isset($start_date)){?>
			$("#report_from_date").datepicker('setDate', parseISO8601(<?= "\"".$start_date."\""?>));
	<?	} ?>
	
	<?	if(isset($end_date)){?>
			$("#report_to_date").datepicker('setDate', parseISO8601(<?= "\"".$end_date."\""?>));
	<?	} ?>
	
	
	  
		$( ".opener_in" ).click(function() {
			
				$(this).closest("tr").find(".dialog_in").fadeToggle();
		
		});
				
		$( ".opener_out" ).click(function() {
			
				$(this).closest("tr").find(".dialog_out").fadeToggle();
		
		});
	 
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
<div id="main-content" >

                            <!-- All Users -->
                            <h2>Report Overview</h2>
                            <div class="body-con">
                            
                            <label class="up-align" style="max-width:50px;">From</label>
                            <input type="text" id="report_from_date" style="max-width:120px;" />
                            <input type="hidden" id="report_from_date_alt" name="start_date" />
                            <label class="up-align" style="max-width:50px;">To</label>
                            <input type="text" id="report_to_date" style="max-width:120px;" />
                            <input type="hidden" id="report_to_date_alt" name="end_date" />
							
                            <input type="hidden" name="is_post_back" id="is_post_back" value="FALSE" />
                            <input type="submit" name='report_submit' value="Submit" id="report_submit" onclick="$('#is_post_back').val('TRUE');callPage('hrm','my_report');" />
                           
                                
                            <!-- Users table --> 
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" aria-describedby="example_info" style="width: 100%;">
                                
                               <tr><td style="font-weight:bold">Date</td><td style="font-weight:bold">In Time<span id="working_hours" class="box_16px"></span></td><td style="font-weight:bold">Out Time<span id="working_hours" class="box_16px"></span></td><td style="font-weight:bold">Working Hours</td></tr>
                                <?
								for($i=0;$i<count($data['report_details']);$i++)
								{
									?>
                                    <tr>
                                    <td><?=formatDate(date('Y-m-d',strtotime($data['report_details'][$i]['in_time']))) ?></td>
                                    <td>
										
									<?
                                    echo "".date('H:i:s',strtotime($data['report_details'][$i]['in_time']))."";
									if($data['report_details'][$i]['in_notes']!='')
									{
										?>
                                        <span id="working_hours" title="Intime Note" class="box_16px img_chat opener_in" style="position:relative;">
	                                  	    <div class="dialog_in" title="Notes" >
                                                <p><?=$data['report_details'][$i]['in_notes']?></p>
                                            </div>
                                        </span>
                                        <!--<img class="opener_in" src="img/chat.png" style="float:left; margin-left:5px;">-->
                                        
                                        <?
									}
									else
									{?>
                                       <span id="working_hours" class="box_16px"></span>
                                      <?
									}
									  ?>
                                      	
                                    </td>
                                    <td>
										
									<?
                                    echo "".date('H:i:s',strtotime($data['report_details'][$i]['out_time']))."";
									if($data['report_details'][$i]['out_notes']!='')
									{
										?>
                                        <span id="working_hours" title="Outtime Note" class="box_16px img_chat opener_out" style="position:relative;">
                                        	<div class="dialog_out" title="Notes" >
                                                <p><?=$data['report_details'][$i]['out_notes']?></p>
                                            </div>
                                        </span>
                                        
                                        <?
									}
									else
									{?>
                                       <span id="working_hours" class="box_16px"></span>
                                      <?
									}
									  ?>
                                      	
                                    </td>
                                    
                                    
                                    <?
									//$diff = date_diff(new DateTime($data['report_details'][$i]['out_time']),new DateTime($data['report_details'][$i]['in_time']));
									$diff = getDateTimeDiff($data['report_details'][$i]['out_time'],$data['report_details'][$i]['in_time'],true,true);
									
									/*if(strlen($diff->h)==1)
									{
										$diff->h = "0".$diff->h;
										
									}
									echo("<td>".str_pad((int) $diff->h,2,"0",STR_PAD_LEFT).":".str_pad((int) $diff->i,2,"0",STR_PAD_LEFT).":".str_pad((int) $diff->s,2,"0",STR_PAD_LEFT)."</td>");
									*/
									//var_dump($diff);exit;
									if($data['report_details'][$i]['out_time']=='0000-00-00 00:00:00')
									{
										echo "<td>Still not Log Out</td>";
									}
									else
									{
									echo "<td>".$diff['h'].":".$diff['m'].":".$diff['s']."</td>";
									}
									 ?>
                                     
                                    </tr>
                                    <?
								}
								?>
                            </table>
                            <!-- END Users table -->                           
                          	</div>
                            
                        </div>
                        <!-- END Main Content -->

					</div>
					<!-- END Content -->