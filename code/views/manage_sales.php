<?
//echo "---".$page; exit;
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}
//echo "<pre>"; print_r($data);
$i=1;
?>
<input type="hidden" name="edit_id" value="" id="edit_id" />

					<!-- Content -->
					<div id="content" class="clearfix">

                     <?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>
                        <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
                      <? }  else  if($notificationArray['type'] == "Failed") { ?>
                      <div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
                      <?   } } ?>
            
                       


                        <!-- Main Content -->
                        <div id="main-content">

                            <!-- All Sale -->
                            <h2>All Sale (<?=sizeof($data['allSales'])?>)</h2>
                            <a href="javascript:callPage('leads','show_add_sale');" class="for_links">Add Sale</a>
                            
                            <div class="body-con">     
                            <!-- Users table --> 
                            <table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">
                                <thead>
                                    <tr>
                                    	<th>Sr. No</th>
                                        <th style="text-align:left">Reciept No</th>
                                        <th>Sale Date</th>
                                        <th>Total Invoice Amount</th>
                                        <th>View Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?
									   foreach($data['allSales'] as $value)
									   {
										   ?>
										    <tr>
                                            	<td ><?=$i; ?></td>
												<td style="text-align:left" ><?=$value['reciept_no']; ?></td>
												<td><?=formatDate($value['sale_date']); ?></td>
												<td><?=$value['total_invoice_amount'] ?></td>
												<td><a href="javascript:openViewSale('<?=$value['sale_id']?>','leads','view_sale_details')" class="tiptip-top" title="View"><img src="img/icon_view.png" alt="view"></a>
												</td>
                                             
											</tr>								   
										   <?
										   $i++;
									   }
									  ?>	
                                </tbody>
                            </table>
                            <!-- END Sale table --> 
                            </div>                          
                        </div>
                        <!-- END Main Content -->
					</div>
					<!-- END Content -->