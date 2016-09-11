<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}
$i=1;
//echo "<pre>"; print_r($data['available_leaves_array']); exit;
?>


					<!-- Content -->
					<div id="content" class="clearfix">

                        <!-- Main Content -->
                        <div id="main-content">
						   <h2>Available Leaves(<?=sizeof($data['available_leaves_array'])?>)</h2>
                           <div class="body-con">
                            <table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">
                                <thead>
                                    <tr>
                                    	<th>Sr. No</th>
                                        <th>Employee Name</th>
                                        <th>Sick Leaves</th>
                                        <th>Casual Leaves</th>
                                        <th>Paid Leaves</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?
								   		// $total_leaves = 0;
									   foreach($data['available_leaves_array'] as $key=>$value)
									   {
										   $total_leaves = 0;
										   ?>
										    <tr>
                                            	<td class="backcolor"><?=$i; ?></td>
												<td><?=$key?></td>
                                                <? if(isset($value['sick'])) {?>
                                                	<td><?=$value['sick']?></td>
                                                    <? $total_leaves = $total_leaves+ $value['sick']; ?>
                                                <? }
													else
													{ 
														echo "<td>".$value['sick']."</td>"; 
														$total_leaves = $total_leaves+ $value['sick'];
													}
												?>
                                                    
                                                <? if(isset($value['casual'])) {?>
                                                	<td><?=$value['casual']?></td>
                                                    <? $total_leaves = $total_leaves+ $value['casual']; ?>
                                                <? }
													else
													{ 
														echo "<td>".$value['casual']."</td>";
														$total_leaves = $total_leaves+ $value['casual'];
													}
												?>    
                                                
                                                <? if(isset($value['paid'])) {?>
                                                	<td><?=$value['paid']?></td>
                                                    <? $total_leaves = $total_leaves+ $value['paid']; ?>
                                                <? }
													else
													{ 
														echo "<td>".$value['paid']."</td>";
														$total_leaves = $total_leaves+ $value['paid'];
													}
												?>    
                                                <td><?=$total_leaves?></td>
											</tr>								   
										   <?
										   $i++;
									   }
									  ?>	
                                </tbody>
                            </table>
                            <!-- END Users table -->                           
                            </div>
                            
                        </div>
                        <!-- END Main Content -->

					</div>
					<!-- END Content -->
