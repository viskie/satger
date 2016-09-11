<script src="js/DateTimePicker.js"></script>
<?
//echo "<pre>"; print_r($data);
 //var_dump($data['page_Details']);exit;
?>
<input type="hidden" name="edit_id" id="edit_id" value="<?=$data['attendance_id']?>" />
                        <!-- Main Content -->
						<div id="content" class="clearfix">
                        <div id="main-content" class="singlecolm_form">


                            <!-- Messages -->
                         
                            <h2>Edit Outtime</h2>
                            
                            <div class="body-con">

                                    <ul class="align-list">
                                     
                                     <li>
                                     <label for="out_time">New Out Time</label><span style="color:red">* </span>
                                    <input type="text" id="out_time" name="out_time" />
                                    </li>
                                    
                                      <li>
                                            <label></label>
                                         	<input type="submit" value="Update" onclick="return updateTime('<?=$data['attendance_id'] ?>','hrm','update_time')"/>
                                     		<input type="button" value="Cancel" class="green_button"  onclick="javascript:callPage('hrm','approve_attendance')" /> 
                                            <!--<button value="Submit" class="green"  onclick="javascript:chkProjectCategory()">Update</button> -->

                                        </li>
                                    </ul>
                                    
                           
                                <!-- END Add user form -->
                                
                            </div>
                            
                        </div>
						</div>
                        <!-- END Main Content -->
					<script type="text/javascript">
					
					
						$(document).ready( function () {
							$("#out_time").datetimepicker(
								{ dateFormat: 'yy-mm-dd', 
									timeFormat: 'hh:mm:ss'
								}
							); 
						});
                   </script>