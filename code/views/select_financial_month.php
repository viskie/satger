<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}
//print_r($_REQUEST); exit;
?>
<input type="hidden" name="edit_id" value="" id="edit_id" />

					<!-- Content -->
					<div id="content" class="clearfix">
					 <!-- Main Content -->
                        <div id="main-content-right" style="width: 65%;">
                        
                     <?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>
                        <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
                      <? }  else  if($notificationArray['type'] == "Failed") { ?>
                      <div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
                      <?   } } ?>
                           
                            <h3>Set Financial Month Start Date</h3>
                            <div class="body-con" id="set_month_div">
                            	
									<input type="radio" id="set_month" name="financial_month" value="1" <? if($data['get_default'] == 0) {?>checked="checked" <? } ?> />
                                    <label for="financial_month" style="width:70px;">Default Date</label>
                                    <br/>
									<input type="radio" id="set_month" name="financial_month" value="2" <? if($data['get_default'] != 0) {?>checked="checked" <? } ?>/>
                                    <label for="financial_month" style="width:70px;">Select Date</label>
                                    <input type="text" id="financial_month" name="month_start_date" style="width:18%; color: #f6931f; font-weight: bold;" onkeypress="return checkValue();" onkeyup="checkValueOnUp()"/>
                                     <span class="msg-form-info">Date should be number between 2 to 28</span>
									<br/>
                                    <div id="slider">
                                       
                                    </div>
                                    <br/>
									<input type="button" value="Update" class="green_button" onClick="setFinancialMonth('settings','update_financial_month')" />
                                    </p>
                            </div>
                          
                        </div>
                        <!-- END Main Content -->

					</div>
					<!-- END Content -->
<script type="text/javascript">

	$(document).ready( function () {
		//jQuery ('select').selectToUISlider();
		
		$( "#slider" ).slider({
			range: "max",
			min: 2,
			max: 28,
			value: <? if($data['get_default'] == '0') echo "2"; else echo $data['get_default']; ?>,
			
			slide: function( event, ui ) {
				$( "#financial_month" ).val( ui.value );
			}
		});
   
		$("#financial_month").val( "<? if($data['get_default'] == '0') echo "2"; else echo $data['get_default']; ?>" );	
	});
	
	function checkValue(){
		var key_code;
		key_code = window.event.keyCode;
		if(key_code < 48 || key_code > 58){
			return false;
		}
	}
	
	function checkValueOnUp(){
		var value = $('#financial_month').val();
		$( "#slider" ).slider({ value:value });
		if(parseInt(value) > 28 ){
			$('#financial_month').val("28");	
		}else if(parseInt(value) == 0) {
			$('#financial_month').val("2");		
		}
	}
</script>