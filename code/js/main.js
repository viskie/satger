// JavaScript Document

var month=new Array();

month[0]="Jan";

month[1]="Feb";

month[2]="Mar";

month[3]="Apr";

month[4]="May";

month[5]="Jun";

month[6]="Jul";

month[7]="Aug";

month[8]="Sep";

month[9]="Oct";

month[10]="Nov";

month[11]="Dec";



var error = {

 	"User": {

		"user_name": "Please enter a user name!",

		"alpha_num": "Please enter alphanumeric characters only!",

		"email": "Please enter the email address!",

		"user": "Please enter a user name!",

		"password": "Please enter password!",

		"phone_no": "Please enter the user's phone number!",

		"valid_phone_no": "Please enter the valid phone number!",

		"deluser" : "Do you really want to delete the user :"	

	},

	"Group": {

		"group_name": "Please enter the group name!",

		"delgroup": "Do you really want to delete the group :"		

	},

	"Employee": {

		"user_name": "Please enter employee user name!",

		"alpha_num": "Please enter alphanumeric characters only!",

		"empname": "Please enter employee name!",

		"password_length": "Password should be at least 6 character in length!",

		"address": "Please enter permanent address!",

		"phone_no": "Please enter phone number!",

		"phone_valid": "Please enter valid phone number!",

		"phone_length": "Phone Number must be 10 digits in length!",

		"joining_date": "Please enter joining date!",

		"personal_email": "Please enter personal email address!",

		"personal_email_valid": "Please provide a valid email address!",

		"company_email": "Please provide a valid email address!",		

		"delemp" : "Do you really want to delete employee:  :",
		"delcandidate" : "Do you really want to delete candidate:  :",
		"candidate_name": "Please enter candidate name!",
		"experience": "Please enter permanent experince!",
		"previous_company": "Please enter previous company!",
		"candidate_remarks": "Please enter remarks!",

	},

	"Task":{

		"project" : "Please select project!",

		"manager" : "Please select manager!",
		"task_priority" : "Please select priority!",
		"deltask" : "Do you really want to delete task:",
		"markcomplete" : "Do you really want to complete this task!",
		"expected_complition_date" : "Please select expected completion date!",
	},

	"Reimbursement": {

		"sel_category": "Please select category!",

		"amount_inr": "Please enter amount INR!",

		"amount_valid": "Please enter valid amount in amount INR!",

		"paid_date": "Please enter paid date!",

		"remark": "Please enter remarks!",

		"mark_paid": "Do you really want to mark the reimbursement paid!",

		"delreimbursement": "Do you really want to delete the Reimbursement!"				

	},

	"Attendance" : {

		"leave_type"	: "Please select atleast one leave type!",

		"leave_from_date"	: "Please select from date!",

		"leave_to_date"	: "Please select to date!",

		"leave_reason"	: "Please write specific leave reason!",

		"out_time"	: "Please Enter Out Time!",

		"delleave"	: "Do you really want to delete this leave!"

	},

	"Product": {

		"product_name": "Please enter the product name!",

		"item_code": "Please enter the item code!",

		"basic_cost": "Please enter the basic cost!",

		"basic_cost_valid": "Please enter valid basic cost!",

		"delproduct" : "Do you really want to delete the Product:"					

	},

	"Client": {

		"client_biz_name": "Please enter the business name for the client!",

		"email": "Please enter the email for the client!",

		"email_valid": "Please enter valid email for the client!",

		"phone_no": "Please enter the phone number of the client!",

		"client_name": "Please enter a client name!",

		"delclient" : "Do you really want to delete the client:"

		

	},

	"Sale": {

		"reciept_no": "Please enter the reciept no!",

		"sel_warehouse": "Please select warehouse from list!",

		"sel_item": "Please select atleast one item!",

		"tax_valid": "Please enter valid tax!",

		"discount_valid": "Please enter valid discount!",

		"inv_amount": "Please enter the total invoice amount!",

		"client": "Please select the client !",

					

	},

	"Lead":{

		"initial_contact_date" : "Please enter initial contact date!",

		"followup_date" : "Please enter followup date!",

		"sel_status" : "Please select status!",

		"dellead" : "Do you really want to delete this lead!",
		
		"lead_phone" : "Please enter phone!",
		
		"number_of_meeting" : "Number of meeting must be number!",
		
		"archivelead" : "Do you really want to do this action!"

	},

	"Order": {

		"reciept_no" : "Please enter the receipt no!",

		"sel_warehouse" : "Please select warehouse from list!",

		"sel_client" : "Please select client from list!",

		"sel_item" : "Please select atleast one item!",

		"tax_valid" : "Please Enter valid tax!",

		"discount_valid" : "Please enter valid discount!",

		"inv_amount" : "Please enter the total invoice amount!",

		"reciept_no_exist" : "Receipt no. already exist!",

		"delorder" : "Do you really want to delete this order!",

		"restore" : "Status order restored successfully"

	},

	"Project" : {

		"project_name" : "Please enter the project name!",

		"sel_project_category" : "Please select the project category!",

		"project_cost_inr" : "Please enter valid project cost INR!",

		"project_cost_inr_valid" : "Please enter valid project cost INR!",

		"sel_client" : "Please select the client!",

		"delproject" : "Do you really want to delete the project:",
		"sel_employee" : "Please select the manager for this project!",	

	},

	"Account" : {

		"sel_category" : "Please select category!",

		"amount_usd" : "Please enter valid amount in amount USD!",

		"conversion_rate_valid" : "Please enter valid conversion rate!",

		"amount_inr" : "Please enter amount INR!",

		"amount_inr_valid" : "Please enter valid amount in amount INR!",

		"payment_recived_date" : "Please enter payment recived date!",

		"sel_remarks" : "Please enter remarks!",

		"markaspaid" : "Do you really want to mark this expense as a paid ?",

		"delincome"	: "Do you really want to delete the income!",

		"delexpense" : "Do you really want to delete the logged expense!",

		"delexpexpense" : "Do you really want to delete the expected expense!"

	},

	"Purchase" : {

		"reciept_no" : "Please enter the reciept no!",

		"tax_valid" : "Please enter valid tax!",

		"discount_valid" : "Please enter valid discount!",

		"inv_amount" : "Please enter the total invoice amount!",

		"sel_category" : "Please select category!"

	},

	"Supplier" : {

		"supplier_name" : "Please enter the name!",

		"email" : "Please enter the email address!",

		"email_valid" : "Please provide valid email address!",

		"address" : "Please enter the address!",

		"city" : "Please enter the city!",

		"state" : "Please enter the state!",

		"country" : "Please enter the country!",

		"zipcode" : "Please enter the zip code!",

		"phone" : "Please enter the phone number!",

		"phone_valid" : "Please enter valid phone number!",

		"phone_length" : "Phone number must be 10 digits in length!",

		"currency" : "Please enter the currency!",

		"reciept_no" : "Please enter the reciept no!",

		"delsuppl"	: "Do you really want to delete supplier : "		

	},

	"Material" : {

		"material_name" : "Please enter the material name.!",

		"item_code" : "Please enter the item code!",

		"material_cost" : "Please enter the basic cost!",

		"material_cost_valid" : "Please enter valid basic cost!",

		"delmaterial" : "Do you really want to delete material : "

	},

	"Inventory" : {

		"sel_product" : "Please select the Product!",

		"sel_warehouse" : "Please select the Warehouse!",

		"basic_cost" : "Please enter the basic cost for inventory!",

		"basic_cost_valid" : "Please enter valid basic cost!",

		"units" : "Please enter the units!",

		"material_name" : "Please enter the material name!",

		"delinventory" : "Do you really want to delete Inventory ? "

	},

	"Warehouse" : {

		"warehouse_code" : "Please enter the code!",

		"name" : "Please enter the name!",

		"address" : "Please enter the address!",

		"city" : "Please enter the city!",

		"state" : "Please enter the State!",

		"country" : "Please enter the country!",

		"zip" : "Please enter the zip code!",

		"delwarehouse" : "Do you really want to delete Warehouse : ",

		"franchise": "Please select the Franchise !"		

	},

	"Franchise" : {

		

		"code" : "Please enter the code!",

		"name" : "Please enter the franchise name!",

		"region" : "Please select the franchise region!",

		"type" : "Please select the franchise type!",

		"email" : "Please enter valid email address!",

		"owner" : "Please enter the owner!",		

	},

	"Setting" : {

		"project_category_name" : "Please enter the project category name!",

		"delcategory" 	: "Do you really want to delete the project category: ",

		"payment_category_name" : "Please enter the payment category name!",

		"payment_category_type" : "Please enter payment category type!",

		"delpaymentcategory" : "Do you really want to delete the project payment category: ",

		"status_name" : "Please enter the status name!",

		"delstatus" : "Do you really want to delete the status: ",

		"substatus_name" : "Please enter the substatus name!",

		"delsubstatus" : "Do you really want to delete the substatus: ",

		"function_name" : "Please enter the function name!",

		"function_friendly_name" : "Please enter the function friendly name!",

		"sel_mainfunction" : "Please select main function!",

		"delfunction" : "Do you really want to delete the function: ",

		"page_description" : "Please enter the description!",

		"page_module_name" : "Please enter the module name!",

		"page_module_name_valid" : "Please enter valid module name\n should start with alphabet only \n should not have space!",

		"page_title" : "Please enter the title!",

		"page_file" : "Please select the module image!",

		"delpage" : "Do you really want to delete the page!",

		"status_name" : "Please enter the status name!",

		"status_order" : "Please enter the order no!",

		"status_order_valid" : "Please enter valid order number!",

		"delorderstatus" : "Do you really want to delete this status!",

		"leave_sick_leave" : "Please enter sick leave!",

		"leave_sick_leave_valid" : "Please enter valid sick leave!",

		"leave_casual_leave" : "Please enter casual leave!",

		"leave_casual_leave_valid" : "Please enter valid casual leave!",

		"leave_paid_leave" : "Please enter paid leave!",

		"leave_paid_leave_valid" : "Please enter valid paid leave!",

		"leave_setting_change" : "Confirm settings change! incorrect settings will cause with incorrect result!",

		"leave_paid_leave_valid" : "Please enter valid paid leave!",

		"status_name" : "Please enter the status name!",

		"source" : "Please select the source !",

		"delsource" : "Do you really want to delete the source:",

		"financial_month" : "Date should be number between 2 to 28. If you want to set financial date as 1 then please select defalut date.",

		"source_name" : "Please enter the source name!",

		"task_status_name" : "Please enter the task status name!",

		"deletetaskstatus" : "Do you really want to delete this task status: ",
		"priority_value" : "Please enter priority value!",
		"priority_order" : "Please enter priority order!",

	},

	"Restore" : "Do you really want to restore this entry",

	"Delete" : "Do you really want to delete this entry",

	"invalid_email" : "Please enter valid email address",

	"invalid_phone" : "Please enter valid Phone number",

};



function show_records(setval, page, func)

	{

		//alert(setval);

		$("#show_status").val(setval);

		//alert($("#show_status").val());

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}



function showForm(id,page,func)

{

	$("#edit_id").val(id);

	$('#page').val(page);

	$('#function').val(func);

	$('#mainForm').submit();	

}



function deleteRecord(id,title,page,func)

{

	if(confirm(error.Delete+" "+title))

	{	$('#edit_id').val(id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

}



function restoreEntry(id,page,func)

{

	if(confirm(error.Restore)){

		$('#edit_id').val(id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

}



function validateFormFields(id,page,func)

{

	if(typeof CKEDITOR !== "undefined")	{

		if(CKEDITOR.instances['ckeditor-instance']){

			var value = CKEDITOR.instances['ckeditor-instance'].getData();

			$("#ckeditor-instance").val(value);

		}

	}

	$('#mainForm').validationEngine();

	showForm(id,page,func);	

	

}





function showFormFranchise(id,page,func)

{	

	var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;



	if($("#franchise_username").val()=='')

	{	alert(error.User.user_name);				

		$('#franchise_username').focus();

		return false;

	}

	else if($("#franchise_password").val()=='')

	{	alert(error.User.password);				

		$('#franchise_password').focus();

		return false;

	}

	else if($("#franchise_code").val()=='')

	{	alert(error.Franchise.code);				

		$('#franchise_code').focus();

		return false;

	}

	else if($("#franchise_name").val()=='')

	{	alert(error.Franchise.name);				

		$('#franchise_name').focus();

		return false;

	}

	else if($("#franchise_region").val()=='0')

	{	alert(error.Franchise.region);				

		$('#franchise_region').focus();

		return false;

	}

	else if($("#franchise_type").val()=='0')

	{	alert(error.Franchise.type);				

		$('#franchise_type').focus();

		return false;

	}

	else if($("#phone_main").val()=='')

	{	alert(error.User.phone_no);				

		$('#phone_main').focus();

		return false;

	}

	else if(isNaN($("#phone_main").val()))

	{	alert(error.User.valid_phone_no);				

		$('#phone_main').focus();

		return false;

	}

	else if($("#phone_main").val().length<10)

	{	alert(error.User.valid_phone_no);				

		$('#phone_main').focus();

		return false;

	}

	else if($("#email").val()=='')

	{	alert(error.User.email);				

		$('#email').focus();

		return false;

	}

	else if(!filter.test($('#email').val()))

	{	alert(error.Franchise.email);				

		$('#email').focus();

		return false;

	}

	else if($("#owner").val()=='')

	{	alert(error.Franchise.owner);				

		$('#owner').focus();

		return false;

	}

	$("#edit_id").val(id);

	$('#page').val(page);

	$('#function').val(func);

	$('#mainForm').submit();	

}



function updateClock (){

	var d=new Date();

	var n = month[d.getMonth()]; 

	

	var currentTime = new Date ( );

	

	var currentHours = currentTime.getHours ( );

	var currentMinutes = currentTime.getMinutes ( );

//	var currentSeconds = currentTime.getSeconds( );

	

	var currentDate = currentTime.getDate( );

	var currentMonth = currentTime.getMonth( );

	var currentYear = currentTime.getFullYear();

	

	// Pad the minutes and seconds with leading zeros, if required

	currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;

//	currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;

	

	// Choose either "AM" or "PM" as appropriate

	var timeOfDay = ( currentHours < 12 ) ? "AM" : "PM";

	

	// Convert the hours component to 12-hour format if needed

	currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;

	

	// Convert an hours component of "0" to "12"

	currentHours = ( currentHours == 0 ) ? 12 : currentHours;

	

	// Compose the string for display

	var currentTimeString =currentDate +"-"+ n +"-" + currentYear+"   "+currentHours + ":" + currentMinutes +" " + timeOfDay;

	

	// Update the time display

	document.getElementById("clock").firstChild.nodeValue = currentTimeString;

	var attendance_clock=document.getElementById("clock1");

	if(attendance_clock){

		attendance_clock.firstChild.nodeValue = currentTimeString;

	}

}

function startClock(){

	setInterval('updateClock()', 60000);

}





function submitenter(myfield,e)

{

	var keycode;

	if (window.event) keycode = window.event.keyCode;

	else if (e) keycode = e.which;

	else return true;

	

	if (keycode == 13)

	   {

	   myfield.form.submit();

	   return false;

	   }

	else

	   return true;

}



function callPage(page,function_name)

{

	if(page != "")

	{

		document.getElementById('page').value = page;

		if(function_name==""){

			document.getElementById('function').value = "view";

		}else{

			document.getElementById('function').value = function_name;

		}

		$("#show_status").val('1');
		
		document.getElementById('mainForm').submit();

	}



}


function downloadFile(resume,page,func){
	$('#edit_id').val(resume);
	$('#page').val(page);
	$('#function').val(func);
	$('#mainForm').submit();
}

function updateTime(id,page,func)

{

	if($("#out_time").val()=='')

	{

		alert(error.Attendance.out_time);				

		$('#out_time').focus();

		return false;

	}

	else

	{

	$('#edit_id').val(id);

	$('#page').val(page);

	$('#function').val(func);

	$('#mainForm').submit();

	}

}

function updateApprove(id,page,func)

{	$('#edit_id').val(id);

	$('#page').val(page);

	$('#function').val(func);

	$('#mainForm').submit();

}



function updateAttendance(page,func)

{

	

	$('#page').val(page);

	$('#function').val(func);

	$('#mainForm').submit();

}



function openEditReimbursement(id,page,func)

{

	$('#edit_id').val(id);

	$('#page').val(page);

	$('#function').val(func);

	$('#mainForm').submit();

}

function addCandidate(page, func)
{
	if($('#name').val() == '')
	{
		alert(error.Employee.candidate_name);				
		$('#name').focus();
		return false;
	}
	else if($('#experience').val() == '')
	{
		alert(error.Employee.experience);				
		$('#experience').focus();
		return false;
	}
	else if($('#previous_company').val() == '')
	{
		alert(error.Employee.previous_company);				
		$('#previous_company').focus();
		return false;
	}
	/*else if($('#remarks').val() == '')
	{
		alert(error.Employee.candidate_remarks);				
		$('#remarks').focus();
		return false;
	}*/
	else if($('#resume').val() == ''){
		alert("Please select Resume!");				
		$('#resume').focus();
		return false;
	}
	else {
		var file_name = $('#resume').val();
		var fileNameIndex = file_name.lastIndexOf("\\") + 1;
		var filename = file_name.substr(fileNameIndex);
		
		var extIndex = filename.lastIndexOf(".") + 1;
		var ext = filename.substr(extIndex);
		
		if(ext != 'doc' && ext != 'docx' && ext != 'pdf')
		{
			alert("File extention must be .doc, .docx, .pdf");
			return false;
		}
		else
		{
			$('#page').val(page);
			$('#function').val(func);
			$('#mainForm').submit();
		}
	}
}
function updateCandidate(id,page, func)
{
	if($('#name').val() == '')
	{
		alert(error.Employee.candidate_name);				
		$('#name').focus();
		return false;
	}
	else if($('#experience').val() == '')
	{
		alert(error.Employee.experience);				
		$('#experience').focus();
		return false;
	}
	else if($('#previous_company').val() == '')
	{
		alert(error.Employee.previous_company);				
		$('#previous_company').focus();
		return false;
	}
	/*else if($('#remarks').val() == '')
	{
		alert(error.Employee.candidate_remarks);				
		$('#remarks').focus();
		return false;
	}*/
	else {
		var file_name = $('#resume').val();
		if(file_name != ''){
			var fileNameIndex = file_name.lastIndexOf("\\") + 1;
			var filename = file_name.substr(fileNameIndex);
			
			var extIndex = filename.lastIndexOf(".") + 1;
			var ext = filename.substr(extIndex);
			
			if(ext != 'doc' && ext != 'docx' && ext != 'pdf')
			{
				alert("File extention must be .doc, .docx, .pdf");
				return false;
			}
		}
		$('#page').val(page);
		$('#function').val(func);
		$('#edit_id').val(id);
		$('#mainForm').submit();
	}
}

function addReimbursement(page, func)

	{		

		if($('#category_id').val() == '0')

		{

        	alert(error.Reimbursement.sel_category);				

			$('#category_id').focus();

		}

		else if($('#amount_inr').val() == "")

		{

        	alert(error.Reimbursement.amount_inr);	

			$('#amount_inr').focus();

		}

		else if(isNaN($('#amount_inr').val()))

		{

        	alert(error.Reimbursement.amount_valid);

			$('#amount_inr').focus();	

		}

		else if($('#paid_date').val() == "")

		{

        	alert(error.Reimbursement.paid_date);

			$('#paid_date').focus();	

		}

		else if($('#remark').val() == "")

		{

        	alert(error.Reimbursement.remark);

			$('#remark').focus();		

		}

		else

		{

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}

	}

	

	function updateStatusPermissions(page,func)

	{

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

	

	function updateReimbursement(id,page, func)

	{

		if($('#amount_inr').val() == "")

		{

			alert(error.Reimbursement.amount_inr);

			$('#amount_inr').focus();		

		}

		else if(isNaN($('#amount_inr').val()))

		{

			alert(error.Reimbursement.amount_valid);

			$('#amount_inr').focus();		

		}

		else if($('#paid_date').val() == "")

		{

			alert(error.Reimbursement.paid_date);

			$('#paid_date').focus();	

		}

		else if($('#remark').val() == "")

		{

			alert(error.Reimbursement.remark);	

			$('#remark').focus();	

		}

		else

		{

			$('#edit_id').val(id);

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}

	}

	

	function openDeleteReimbursement(id,page,func)

	{

		if(confirm(error.Reimbursement.delreimbursement))

		{	$('#edit_id').val(id);

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}

	}

	

	function openPaidReimbursement(id,page,func)

	{	

		if(confirm(error.Reimbursement.mark_paid))

		{	$('#edit_id').val(id);

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}

	}



	function addPurchase(page, func)

	{

		if($('#reciept_no').val() == "")

		{

			alert(error.Purchase.reciept_no);

			$('#reciept_no').focus();

		}

		else if(isNaN($('#tax').val()))

		{

			alert(error.Purchase.tax_valid);

			$('#tax').focus();

		}

		else if(isNaN($('#discount').val()))

		{

			alert(error.Purchase.discount_valid);

			$('#discount').focus();

		}

		else if(isNaN($('#total_invoice_amount').val()))

		{

			alert(error.Purchase.inv_amount);

			$('#total_invoice_amount').focus();

		}

		else

		{

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}

		return false;

	}



function addSale(page, func)

{

	if($('#reciept_no').val() == "")

	{

		alert(error.Sale.reciept_no);				            

		$('#reciept_no').focus();

	}

	else if($('#warehouse_id').val() == 0)

	{

		alert(error.Sale.sel_warehouse);				            

		$('#warehouse_id').focus();

	}

	else if($('#client').val() == 0)

	{

		alert(error.Sale.client);				            

		$('#client').focus();

	}

	else if(unique_exclude_product.length == "0")

	{

		alert(error.Sale.sel_item);				                

		$('#product_id').focus();

		return false;

	}

	else if(isNaN($('#tax').val()))

	{	

		alert(error.Sale.tax_valid);				            

		$('#tax').focus();

	}

	else if(isNaN($('#discount').val()))

	{	

		alert(error.Sale.discount_valid);				            

		$('#discount').focus();

	}

	else if(isNaN($('#total_invoice_amount').val()))

	{

		alert(error.Sale.inv_amount);				                        

		$('#total_invoice_amount').focus();

	}

	else

	{


		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

	return false;

}



function openViewPurchase(id,page,func)

{

	$('#edit_id').val(id);

	$('#page').val(page);

	$('#function').val(func);

	$('#mainForm').submit();

}



function openViewSale(id,page,func)

{

	$('#edit_id').val(id);

	$('#page').val(page);

	$('#function').val(func);

	$('#mainForm').submit();

}



function openEditPage(page_id,page,func)

{

	$('#edit_id').val(page_id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

}



function deletePage(id,title,page,func)

{

	if(confirm(error.Setting.delpage+" "+title))

	{	$('#edit_id').val(id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

}



function restoreEntry(id,page,func)

{

	if(confirm(error.Restore)){

		$('#edit_id').val(id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

}



function restoreLeadEntry(id,page,func,hidden)

{

	if(confirm("Do you really want to restore this entry")){

		if(hidden == "status")

			$('#statusid').val(id);

		else if(hidden == "sub_status")

			$('#sub_status_id').val(id);

		else

			$('#source_id').val(id);		

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

}



function addPage(page, func)

{

	var v=/^[A-Za-z][A-Za-z0-9]*(?:_[A-Za-z0-9]+)*$/;

	//var v=/^[a-zA-Z0-9_]*$/;

	if($('#description').val() == "")

	{

    	alert(error.Setting.page_description);			

		$('#description').focus();

		return false;

	}

	else if($('#module_name').val() == "")

	{

    	alert(error.Setting.page_module_name);			

		$('#module_name').focus();

		return false;

	}

	else if($('#module_name').val().search(v)==-1)

	{	

    	alert(error.Setting.page_module_name_valid);			

    	$('#module_name').focus();

		return false;

	}

	else if($('#title').val() == "")

	{

    	alert(error.Setting.page_title);			

		$('#title').focus();

		return false;

	}

	else if($('#file').val() == "")

	{

    	alert(error.Setting.page_file);			

		$('#file').focus();

		return false;

	}

	else

	{

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

	

}



function updatePage(id,page,func)

{	

	

	var v=/^[A-Za-z][A-Za-z0-9]*(?:_[A-Za-z0-9]+)*$/;

	//var v=/^[a-zA-Z0-9_]*$/;

	if($('#description').val() == "")

	{

		alert(error.Setting.page_description);		

		$('#description').focus();

		return false;

	}

	else if($('#module_name').val() == "")

	{

		alert(error.Setting.page_module_name);	

		$('#module_name').focus();

		return false;

	}

	else if($('#module_name').val().search(v)==-1)

	{	

		alert(error.Setting.page_module_name_valid);

		$('#module_name').focus();

		return false;

	}

	else if($('#title').val() == "")

	{

    	alert(error.Setting.page_title);			

		$('#title').focus();

		return false;

	}

	else

	{

		$('#edit_id').val(id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

}



function openEditInventory(inventory_id,page,func)

{

	$('#edit_id').val(inventory_id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

}



function openDeleteInventory(id,page,func)

{

	if(confirm(error.Inventory.delinventory))

	{	$('#edit_id').val(id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

}



function addInventory(page, func)

{

	if($('#product_id').val() == "0")

	{

    	alert(error.Inventory.sel_product);

		$('#product_id').focus();

	}

	else if($('#warehouse_id').val() == "0")

	{

    	alert(error.Inventory.sel_warehouse);

		$('#warehouse_id').focus();

	}

	else if($('#basic_cost').val() == "")

	{

    	alert(error.Inventory.basic_cost);

		$('#basic_cost').focus();

	}

	else if(isNaN($('#basic_cost').val()))

	{	

    	alert(error.Inventory.basic_cost_valid);

    	$('#basic_cost').focus();

	}

	else if($('#units').val() == "")

	{

    	alert(error.Inventory.units);

		$('#units').focus();

	}

	else

	{

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

	return false;

}	



function addApplyLeave(page,func)

{

	if($('#leave_type').val() == 0)

	{

    	alert(error.Attendance.leave_type);	

		$('#leave_type').focus();			

	}

	else if($('#leave_from_date').val() == "")

	{

    	alert(error.Attendance.leave_from_date);			

		$('#leave_from_date').focus();

	}

	else if($('#leave_to_date').val() == "")

	{

    	alert(error.Attendance.leave_to_date);			

		$('#leave_to_date').focus();

	}

	else if($('#leave_reason').val() == "")

	{

    	alert(error.Attendance.leave_reason);			

		$('#leave_reason').focus();

	}

	else

	{

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();	

	}

	return false;

}



function updateInventory(id,page,func)

{	 if($('#basic_cost').val() == "")

	{

		alert(error.Inventory.basic_cost);

		$('#basic_cost').focus();

	}

	else if(isNaN($('#basic_cost').val()))

	{	

    	alert(error.Inventory.basic_cost_valid);

		$('#basic_cost').focus();

	}

	else if($('#units').val() == "")

	{

		alert(error.Inventory.units);

		$('#units').focus();

	}

	else

	{

		$('#edit_id').val(id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

}

function openEditGroup(group_id,page,func)

{

	$('#edit_id').val(group_id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

}



function openEditSupplier(supplier_id,page,func)

{

	$('#edit_id').val(supplier_id);

	$('#page').val(page);

	$('#function').val(func);

	$('#mainForm').submit();

}



function editAppliedLeave(id,page,func)

{

	$('#edit_id').val(id);

	$('#page').val(page);

	$('#function').val(func);

	$('#mainForm').submit();

}



function deleteGroup(id,uname,page,func)

{

	if(confirm(error.Group.delgroup+" "+uname))

	{	$('#edit_id').val(id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

}



function addGroup(page, func)

{

	if($('#group_name').val() == "")

	{

    	alert(error.Group.group_name);		

		$('#group_name').focus();

	}

	else

	{

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

	return false;

}



function saveGroup(page,func)

{	 

	if($('#group_name').val()=="")

	{

		alert(error.Group.group_name);			

		$('#group_name').focus();

	}

	else

	{

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

}



function updateGroup(id,page,func)

{	 if($('#group_name').val()=="")

		{

        	alert(error.Group.group_name);			

			$('#group_name').focus();

		}

		else

		{

			$('#edit_id').val(id);

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}

}



function addUser(page, func)

{

	var r = "^[a-zA-Z0-9]*$";

	

	if($('#user_name').val() == "")

	{

    	alert(error.User.user_name);

		$('#user_name').focus();		

	}

	else if($('#user_name').val().search(r)==-1)

	{

    	alert(error.User.alpha_num);

		$('#user_name').focus();		

	}

	else if($('#user_email').val() == "")

	{

    	alert(error.User.email);

		$('#user_email').focus();		

	}

	else if($('#name').val() == "")

	{

    	alert(error.User.user);

		$('#name').focus();	

	}

	else if($('#user_password').val() == "")

	{

	   	alert(error.User.password);

		$('#user_password').focus();	

	}

	else if($('#user_phone').val() == "")

	{

    	alert(error.User.phone_no);

		$('#user_phone').focus();

	}

	else if(isNaN($('#user_phone').val()) )

	{

    	alert(error.User.valid_phone_no);

		$('#user_phone').focus();

	}

	else if($('#user_phone').val().length < 10 )

	{

    	alert(error.User.valid_phone_no);

		$('#user_phone').focus();

	}

	else

	{

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

	return false;

}



function validateProfileDetails(page, func)

{

	var r = "^[a-zA-Z0-9]*$";

	

	if($('#user_email').val() == "")

	{

    	alert(error.User.email);

		$('#user_email').focus();		

	}

	else if($('#name').val() == "")

	{

    	alert(error.User.user);

		$('#name').focus();	

	}

	else if($('#user_password').val() == "")

	{

	   	alert(error.User.password);

		$('#user_password').focus();	

	}

	else if($('#user_phone').val() == "")

	{

    	alert(error.User.phone_no);

		$('#user_phone').focus();

	}

	else if(isNaN($('#user_phone').val()) )

	{

    	alert(error.User.valid_phone_no);

		$('#user_phone').focus();

	}

	else if($('#user_phone').val().length < 10 )

	{

    	alert(error.User.valid_phone_no);

		$('#user_phone').focus();

	}

	else

	{

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

	return false;

}





function addLead(page,func)

{

	var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

	

	if($('#client').val() == 0)

	{

    	alert(error.Sale.client);

		$('#client').focus();					

	}

	else if($('#product').val() == 0)

	{

    	alert(error.Product.product_name);

		$('#product').focus();					

	}

	else if($('#source').val() == 0)

	{

    	alert(error.Setting.source);

		$('#source').focus();					

	}

	if($('#initial_contact_date').val() == "")

	{

    	alert(error.Lead.initial_contact_date);

		$('#initial_contact_date').focus();						

	}

	else if($('#followup_date').val() == "")

	{

    	alert(error.Lead.followup_date);

		$('#followup_date').focus();					

	}

	else if($('#status').val() == 0)

	{

    	alert(error.Lead.sel_status);

		$('#status').focus();					

	}

	else if($('#lead_email').val() == "")

	{

		alert(error.Lead.email_empty);

		$('#lead_email').focus();

	}

	else if(!filter.test($('#lead_email').val()))

	{

    	alert(error.invalid_email);	

		$('#lead_email').focus();

	}

	else if($('#lead_phone').val()=="")

	{

    	alert(error.Lead.phone_empty);			

		$('#lead_phone').focus();

	}

	else if(isNaN($('#lead_phone').val()))

	{

    	alert(error.invalid_phone);			

		$('#lead_phone').focus();

	}

	else if($('#lead_phone').val().length < 10)

	{

    	alert(error.invalid_phone);	

		$('#lead_phone').focus();

	}
	else if(isNaN($('#number_of_meeting').val()))

	{

    	alert(error.number_of_meeting);			

		$('#number_of_meeting').focus();

	}
	else

	{

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

}



function addWarehouse(page,func)

{

	if($('#warehouse_code').val()=="")

	{

    	alert(error.Warehouse.warehouse_code);

		$('#warehouse_code').focus();

		return false;

	}

	else if($('#name').val()=="")

	{

    	alert(error.Warehouse.name);

		$('#name').focus();

		return false;

	}

	else if($('#address').val()=="")

	{

    	alert(error.Warehouse.address);

		$('#address').focus();

		return false;

	}

	else if($('#franchise_id').val()=="")

	{

    	alert(error.Warehouse.franchise);

		$('#franchise_id').focus();

		return false;

	}

	else if($('#city').val()=="")

	{

    	alert(error.Warehouse.city);

		$('#city').focus();

		return false;

	}

	else if($('#state').val()=="")

	{

    	alert(error.Warehouse.state);

		$('#state').focus();


		return false;

	}

	else if($('#country').val()=="")

	{

    	alert(error.Warehouse.country);

		$('#country').focus();

		return false;

	}

	else if($('#zip').val()=="")

	{

    	alert(error.Warehouse.zip);

		$('#zip').focus();

		return false;

	}

	else{

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

}

	

function clearUserFields(header)

{

	$('#popHeaderSpn').html(header);

	$('#user_name').val("");

	$('#full_name').val("");

	$('#user_id').val("");

	$('#email').val("");

	$('#user_phone_number').val("");

	document.getElementById('editUser').style.display = "none";

	document.getElementById('addUser').style.display = "";	

}



function clearPhoneFields(header)

{

	$('#popHeaderSpn').html(header);

	$('#phone_number').val("");

	document.getElementById('editNumber').style.display = "none";

	document.getElementById('addNumber').style.display = "";	

}



function setEditAssignedEmployee(id,ph_number,user)

{

	$('#phone_number').val(ph_number);

	$('#on_call_emp').val(user);

	$('#ph_id').val(id);

}



function setEditUser(id, uname, full_name, email, phone)

{

	$('#popHeaderSpn').html('Edit User Details');

	$('#user_name').val(uname);

	$('#full_name').val(full_name);

	$('#user_id').val(id);

	$('#email').val(email);

	$('#user_phone_number').val(phone);

	document.getElementById('addUser').style.display = "none";

	document.getElementById('editUser').style.display = "";

}



function setEditPhone(id,ph_number,text_message)

{	

	$('#popHeaderSpn').html('Edit Phone Settings');

	$('#phone_number').val(ph_number);

	$('#text_message').val(text_message);

	

	$('#ph_id').val(id);

	document.getElementById('addNumber').style.display = "none";

	document.getElementById('editNumber').style.display = "";

}



function editUser(page, func)

{

	var r = "^[a-zA-Z0-9]*$";

	if($('#user_name').val() == "")

	{

    	alert(error.User.user_name);

		$('#user_name').focus();		

	}

	else if($('#user_name').val().search(r)==-1)

	{

    	alert(error.User.alpha_num);

		$('#user_name').focus();	

	}

	else if($('#user_email').val() == "")

	{

    	alert(error.User.email);

		$('#user_email').focus();			

	}

	else if($('#user_password').val() == "")

	{

    	alert(error.User.password);	

		$('#user_password').focus();	

	}

	else if($('#name').val() == "")

	{

    	alert(error.User.user);

		$('#name').focus();

	}	

	else if($('#user_phone').val() == "")

	{

    	alert(error.User.phone_no);

		$('#user_phone').focus();

	}

	else if(isNaN($('#user_phone').val()) )

	{

    	alert(error.User.valid_phone_no);

		$('#user_phone').focus();

	}

	else if($('#user_phone').val().length < 10 )

	{

    	alert(error.User.valid_phone_no);

		$('#user_phone').focus();

	}

	else

	{

    	$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

}





function openEditStatus(status_id,page,func)

{

		$('#statusid').val(status_id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

}



function openDeleteStatus(id,cname,page,func)

{

	if(confirm(error.Setting.delstatus+" "+cname))

	{	$('#statusid').val(id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

}



function deleteTaskStatus(id,name,page,func)

{

	if(confirm(error.Setting.deletetaskstatus+" "+name))

	{	$('#edit_id').val(id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

}



function openDeleteTask(tname,id,page,func)

{

	if(confirm(error.Task.deltask+" "+tname))

	{	

		$('#edit_id').val(id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

}



function openMarkAsComplete(id,page,func)

{

	if(confirm(error.Task.markcomplete))

	{	

		$('#edit_id').val(id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

}



function openDeleteLead(id,page,func)

{

	if(confirm(error.Lead.dellead))

	{	

		$('#edit_id').val(id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

}


function openArchiveLead(id,page,func)

{

	if(confirm(error.Lead.archivelead))

	{	

		$('#edit_id').val(id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

}




function openDeleteSupplier(id,sname,page,func)

{

	if(confirm(error.Supplier.delsuppl+" "+sname))

	{	$('#edit_id').val(id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

}



function addStatus(page,func)

	{

		if($('#status_name').val()=="")

		{

			alert(error.Setting.status_name);

			$('#status_name').focus();

			return false;

		}

		

		else

		{

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}

	}



function updateStatus(id,page,func)

	{	 if($('#status_name').val()=="")

		{

			alert(error.Setting.status_name);

			$('#status_name').focus();

			return false;

		}

		

		else

		{

			$('#edit_id').val(id);

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}

	}



function openEditSubStatus(substatus_id,page,func)

{

	$('#sub_status_id').val(substatus_id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

}



function openDeleteSubStatus(id,cname,page,func)

	{

		if(confirm(error.Setting.delsubstatus+" "+cname))

		{	$('#sub_status_id').val(id);

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}

	}



function addSubstatus(page,func)

	{

		if($('#substatus_name').val()=="")

		{

			alert(error.Setting.substatus_name);	

			$('#substatus_name').focus();

			return false;

		}

		

		else

		{

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}

	}



function updateSubstatus(id,page,func)

	{	 if($('#substatus_name').val()=="")

		{

			alert(error.Setting.substatus_name);

			$('#substatus_name').focus();

			return false;

		}

		

		else

		{

			$('#edit_id').val(id);

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}

	}



function openEditSource(source_id,page,func)

{

	$('#source_id').val(source_id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

}



function openDeleteSource(id,cname,page,func)

	{

		if(confirm(error.Setting.delsource+" "+cname))

		{	$('#source_id').val(id);

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}

	}



function addSource(page,func)

	{

		if($('#source_name').val()=="")

		{

        	alert(error.Setting.source_name);

			$('#source_name').focus();

			return false;

		}

		

		else

		{

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}

	}

	

	function updateSource(id,page,func)

	{	 if($('#source_name').val()=="")

		{

			alert(error.Setting.source_name);

			$('#source_name').focus();

			return false;

		}

		

		else

		{

			$('#edit_id').val(id);

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}

	}



function deleteUser(id,uname,page,func)

{

	if(confirm(error.User.deluser+" "+uname))

	{	$('#edit_id').val(id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

}



function deleteEmployee(id,uname,page,func)

{

	if(confirm(error.Employee.delemp+" "+uname))

	{	$('#edit_id').val(id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

}



function deleteProduct(id,pname,page,func)

{

	if(confirm(error.Product.delproduct+" "+pname))

	{	$('#edit_id').val(id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

}



function deleteProjectCategory(id,uname,page,func)

{

	if(confirm(error.Setting.delcategory+" "+uname))

	{	$('#edit_id').val(id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

}



function deleteFunction(id,fname,page,func)

{

	if(confirm(error.Setting.delfunction+" "+fname))

	{	

		$('#edit_id').val(id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

}



function deletePaymentCategory(id,name,page,func)

{

	if(confirm(error.Setting.delpaymentcategory+" "+name))

	{	$('#edit_id').val(id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

}



function deleteProject(id,pname,page,func)

{

	if(confirm(error.Project.delproject+" "+pname))

	{	$('#edit_id').val(id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

}



function addProduct(page,func)

	{

		if($('#product_name').val()=="")

		{

        	alert(error.Product.product_name);		

			$('#product_name').focus();

			return false;

		}

		else if($('#item_code').val()=="")

		{

        	alert(error.Product.item_code);	

			$('#item_code').focus();

			return false;

		}

		else if($('#basic_cost').val()=="")

		{

        	alert(error.Product.basic_cost);	

			$('#basic_cost').focus();

			return false;

		}

		else if(isNaN($('#basic_cost').val()))

		{	

        	alert(error.Product.basic_cost_valid);				

			$('#basic_cost').focus();

			return false;

		}

		else

		{

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}

	}

	

function addTask(page,func)

{

	if($('#project').val()=="0")
	{
		alert(error.Task.project);		
		$('#project').focus();
		return false;
	}
	else if($('#task_priority').val()=="0")
	{
		alert(error.Task.task_priority);	
		$('#task_priority').focus();
		return false;
	}

	else

	{

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();	

	}

}

	

function addTaskStatus(page,func)

	{

		

		 if($('#task_status_name').val() == "")

		{

        	alert(error.Setting.task_status_name);			

			$('#task_status_name').focus();

			return false;

		}

		else

		{

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}

	}

	

function addMaterial(page,func)

{

	if($('#material_name').val()=="")

	{

    	alert(error.Material.material_name);			

		$('#material_name').focus();

		return false;

	}

	else if($('#material_code').val()=="")

	{

    	alert(error.Material.item_code);			

		$('#material_code').focus();

		return false;

	}

	else if($('#material_cost').val()=="")

	{

    	alert(error.Material.material_cost);			

		$('#material_cost').focus();

		return false;

	}

	else if(isNaN($('#material_cost').val()))

	{	

    	alert(error.Material.material_cost_valid);			

		$('#material_cost').focus();

		return false;

	}

	else

	{

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

}	



function addSupplier(page, func)

{

	var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

	if($('#supplier_name').val()=="")

	{

    	alert(error.Supplier.supplier_name);	

		$('#supplier_name').focus();

		return false;

	}

	else if($('#email').val()=="")

	{

    	alert(error.Supplier.email);	

		$('#email').focus();

		return false;

	}

	else if(!filter.test($('#email').val()))

	{

    	alert(error.Supplier.email_valid);	

		$('#email').focus();

		return false;

	}

	else if($('#address').val()=="")

	{

    	alert(error.Supplier.address);	

		$('#address').focus();

		return false;

	}

	else if($('#city').val()=="")

	{

    	alert(error.Supplier.city);	

		$('#city').focus();

		return false;

	}

	else if($('#state').val()=="")

	{

    	alert(error.Supplier.state);	

		$('#state').focus();

		return false;

	}

	else if($('#country').val()=="")

	{

    	alert(error.Supplier.country);	

		$('#country').focus();

		return false;

	}

	else if($('#zip').val()=="")

	{

    	alert(error.Supplier.zipcode);	

		$('#zip').focus();

		return false;

	}

	else if($('#phone1').val()=="")

	{

    	alert(error.Supplier.phone);			

		$('#phone1').focus();

		return false;

	}

	else if(isNaN($('#phone1').val()))

	{

    	alert(error.Supplier.phone_valid);			

		$('#phone1').focus();

		return false;

	}

	else if($('#phone1').val().length < 10)

	{

    	alert(error.Supplier.phone_length);	

		$('#phone1').focus();

		return false;

	}

	else if(($('#phone2').val() != "") && (isNaN($('#phone2').val())))

	{

    	alert(error.Supplier.phone_valid);	

		$('#phone2').focus();

		return false;

	}

	else if(($('#phone2').val() != "") && ($('#phone2').val().length < 10))

	{

    	alert(error.Supplier.phone_length);			

		$('#phone2').focus();

		return false;

	}

	else if($('#currency').val()=="")

	{

    	alert(error.Supplier.currency);			

		$('#currency').focus();

		return false;

	}

	else

	{

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();	

	}	

}



function viewHistory(id,page,func)

{

		$('#ph_history').val(id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

}



function userLogout()

{

	$('#page').val('home');

	$('#function').val('logout');

	$('#mainForm').submit();

}



function changeLanguage()

{

	$('#page').val('home.php');

	$('#function').val('language_change');

	$('#mainForm').submit();

}



function updateSettings(page, func)

{

	if(confirm(error.Setting.leave_setting_change))

	{	

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

}



function updateProjectCategory(id,page, func)

{

		if($('#project_category_name').val() == "")

		{

			alert(error.Setting.project_category_name);	

			$('#project_category_name').focus();

			return false;

			

		}

		else

		{

		$('#edit_id').val(id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

		}

		

}

function updateTaskStatus(id,page, func)

{

		if($('#task_status_name').val() == "")

		{

			alert(error.Setting.task_status_name);	

			$('#task_status_name').focus();

			return false;

			

		}

		else

		{

			$('#edit_id').val(id);

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}

		

}



function updateTask(id,page,func)
{
	if($('#project').val()=="0")
	{
		alert(error.Task.project);		
		$('#project').focus();
		return false;
	}
	else if($('#task_status').val() == 3 && ($('#task_start_date').val() == "" || $('#task_start_date').val() == '0000-00-00 00:00:00')){
		alert("Please select start date!");
		$('#task_start_date').focus();	
		return false;
	}
	else if($('#task_status').val() == 3 && ($('#expected_complition_date').val() == "" || $('#expected_complition_date').val() == '0000-00-00 00:00:00')){
		alert("Please select expected end date!");
		$('#expected_complition_date').focus();	
		return false;
	}
	else if($('#task_priority').val()=="0")
	{
		alert(error.Task.task_priority);	
		$('#task_priority').focus();
		return false;
	}
	else
	{
		$('#edit_id').val(id);
		$('#page').val(page);
		$('#function').val(func);
		$('#mainForm').submit();	
	}
}



function updateFunction(id,page,func)

{

	 if($('#function_name').val() == "")

	{

		alert(error.Setting.function_name);	

		$('#function_name').focus();

		return false;

	}

	else if($('#friendly_name').val() == "")

	{

		alert(error.Setting.function_friendly_name);	

		$('#friendly_name').focus();

		return false;

	}

	else if($('#page_id').val() == "")

	{

		alert(error.Setting.page_module_name);	

		$('#page_id').focus();

		return false;

	}

	else

	{	$('#edit_id').val(id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

}



function save_subfunction(page,func)

{

	if($('#function_id').val() == "0")

	{

		alert(error.Setting.sel_mainfunction);	

		return false;

	}

	else if($('#function_name').val() == "")

	{

		alert(error.Setting.function_name);	

		return false;

	}

	else if($('#friendly_name').val() == "")

	{

		alert(error.Setting.function_friendly_name);	

		return false;

	}

	else

	{

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

}



function updateEmployee(id,page, func)

{

		var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

		var r = "^[a-zA-Z0-9]*$";

		//alert(page);

		 if($('#employee_user_name').val() == "")

		 {

         	alert(error.Employee.user_name);	

			$('#employee_user_name').focus();

			return false;

		 }

		  else if($('#employee_user_name').val().search(r) == -1)

		 {

         	alert(error.Employee.alpha_num);				

			$('#employee_user_name').focus();

			return false;

		 }

		  if($('#employee_name').val() == "")

		{

        	alert(error.Employee.empname);			

			$('#employee_name').focus();

			return false;

		}

		else if($("#employee_password").val().length < 6 )

		{

        	alert(error.Employee.password_length);	

			$('#employee_password').focus();

			return false;		

		}

		else if($('#per_address').val() == "")

		{

        	alert(error.Employee.address);	

			$('#per_address').focus();

			return false;

		}

		else if($('#phone_number').val() == "")

		{

        	alert(error.Employee.phone_no);	

			$('#phone_number').focus();

			return false;

		}

		else if(isNaN($('#phone_number').val()))

		{

        	alert(error.Employee.phone_valid);	

			$('#phone_number').focus();

			return false;

		}

		else if($('#phone_number').val().length < 10 )

		{

        	alert(error.Employee.phone_length);	

			$('#phone_number').focus();

			return false;

		}

		else if($('#joining_date').val() == "")

		{

        	alert(error.Employee.joining_date);				

			$('#joining_date').focus();

			return false;

		}

		else if($('#personal_email').val() == "")

		{

        	alert(error.Employee.personal_email);				

			$('#personal_email').focus();

			return false;

		}

		else if (!filter.test($('#personal_email').val())) 

		{

        	alert(error.Employee.personal_email_valid);	    		

			$('#personal_email').focus();

			return false;

 		}

		else if ($('#company_email').val()!="" && !filter.test($('#company_email').val())) 

		{

        	alert(error.Employee.company_email);	

			$('#company_email').focus();

			return false;

		}

		else

		{

		$('#edit_id').val(id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

		}

		

}



function updateSupplier(id, page, func)

{

	var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

	if($('#supplier_name').val()=="")

	{

		alert(error.Supplier.supplier_name);	

		$('#supplier_name').focus();

		return false;

	}

	else if($('#email').val()=="")

	{

		alert(error.Supplier.email);	

		$('#email').focus();

		return false;

	}

	else if(!filter.test($('#email').val()))

	{

		alert(error.Supplier.email_valid);	

		$('#email').focus();

		return false;

	}

	else if($('#address').val()=="")

	{

		alert(error.Supplier.address);	

		$('#address').focus();

		return false;

	}

	else if($('#city').val()=="")

	{

		alert(error.Supplier.city);	

		$('#city').focus();

		return false;

	}

	else if($('#state').val()=="")

	{

		alert(error.Supplier.state);	

		$('#state').focus();

		return false;

	}

	else if($('#country').val()=="")

	{

		alert(error.Supplier.country);	

		$('#country').focus();

		return false;

	}

	else if($('#zip').val()=="")

	{

		alert(error.Supplier.zipcode);	

		$('#zip').focus();

		return false;

	}

	else if($('#phone1').val()=="")

	{

		alert(error.Supplier.phone);	

		$('#phone1').focus();

		return false;

	}

	else if(isNaN($('#phone1').val()))

	{

		alert(error.Supplier.phone_valid);	

		$('#phone1').focus();

		return false;

	}

	else if($('#phone1').val().length < 10)

	{

		alert(error.Supplier.phone_length);	

		$('#phone1').focus();

		return false;

	}

	else if(($('#phone2').val() != "") && (isNaN($('#phone2').val())))

	{

		alert(error.Supplier.phone_valid);	

		$('#phone2').focus();

		return false;

	}

	else if(($('#phone2').val() != "") && ($('#phone2').val().length < 10))

	{

		alert(error.Supplier.phone_length);	

		$('#phone2').focus();

		return false;

	}

	else if($('#currency').val()=="")

	{

		alert(error.Supplier.currency);	

		$('#currency').focus();

		return false;

	}

	else

	{

		$('#edit_id').val(id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();	

	}

}



function updatePaymentCategory(page, func)

{

	if($('#payment_category_name').val() == "")

	{

		 alert(error.Setting.payment_category_name);

		 $('#payment_category_name').focus();	

	}

	else

	{

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

	return false;

}



function updateWarehouse(id,page,func)

{

	if($('#warehouse_code').val()=="")

	{

		alert(error.Warehouse.warehouse_code);

		$('#warehouse_code').focus();

		return false;

	}

	else if($('#name').val()=="")

	{

		alert(error.Warehouse.name);

		$('#name').focus();

		return false;

	}

	else if($('#address').val()=="")

	{

		alert(error.Warehouse.address);

		$('#address').focus();

		return false;

	}

	else if($('#franchise_id').val()=="0")

	{

    	alert(error.Warehouse.franchise);

		$('#franchise_id').focus();

		return false;

	}

	else if($('#city').val()=="")

	{

		alert(error.Warehouse.city);

		$('#city').focus();

		return false;

	}

	else if($('#state').val()=="")

	{

		alert(error.Warehouse.state);

		$('#state').focus();

		return false;

	}

	else if($('#country').val()=="")

	{

		alert(error.Warehouse.country);

		$('#country').focus();

		return false;

	}

	else if($('#zip').val()=="")

	{

		alert(error.Warehouse.zip);

		$('#zip').focus();

		return false;

	}

	else{

		$('#edit_id').val(id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

}



function updateAppliedLeave(id,page,func)

{

	if($('#leave_type').val() == 0)

	{

		 alert(error.Attendance.leave_type);

		 $('#leave_type').focus();

	}

	else if($('#leave_from_date').val() == "")

	{

		 alert(error.Attendance.leave_from_date);

		$('#leave_from_date').focus();

	}

	else if($('#leave_to_date').val() == "")

	{

		 alert(error.Attendance.leave_to_date);

		$('#leave_to_date').focus();

	}

	else if($('#leave_reason').val() == "")

	{

		 alert(error.Attendance.leave_reason);

		$('#leave_reason').focus();

	}

	else

	{

		$('#edit_id').val(id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();	

	}

	return false;

}



function openEditProduct(id,page,func)

	{

		$('#edit_id').val(id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}



function openEditUser(user_id,page,func)

{

	$('#edit_id').val(user_id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

}



function openEditTask(id,page,func)

{

	$('#edit_id').val(id);

	$('#page').val(page);

	$('#function').val(func);

	$('#mainForm').submit();

}

function openEditTaskStatus(task_status_id,page,func)

{	

	$('#edit_id').val(task_status_id);

	$('#page').val(page);

	$('#function').val(func);

	$('#mainForm').submit();

}

function openEditProjectCategory(project_category_id,page,func)

{	//alert("hii");

	$('#edit_id').val(project_category_id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

}



function openEditFunction(function_id,page,func)
{	

	$('#edit_id').val(function_id);

	$('#page').val(page);

	$('#function').val(func);

	$('#mainForm').submit();

}



function openEditPaymentCategory(payment_category_id,page,func)

{	

	$('#edit_id').val(payment_category_id);

	$('#page').val(page);

	$('#function').val(func);

	$('#mainForm').submit();

}



function openEditIncome(user_id,page,func)

{

	$('#edit_id').val(user_id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

}



function openEditExpense(user_id,page,func)

{

	$('#edit_id').val(user_id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

}



function openEditWarehouse(id,page,func)

{

	$('#edit_id').val(id);

	$('#page').val(page);

	$('#function').val(func);

	$('#mainForm').submit();

}



function openEditExpectedExpense(id,page,func)

{

	$('#edit_id').val(id);

	$('#page').val(page);

	$('#function').val(func);

	$('#mainForm').submit();

}



function setTranscription(value)

{

	$('#callTranscriptionDiv').html(value);

}



function phoneMgmtChng(page, func)

{

	var phone_num = $('#phone_number').val();

	var user =  $('#admin_user').val();

	

	var url = page + "?func="+func+"&phone_number="+phone_num+"&admin_user="+user;

	

	getData(url, 'phoneAdminsSpn');

	

}



function ajaxFileUpload()

	{

		$.ajaxFileUpload

		(

			{

				url:'doajaxfileupload.php',

				secureuri:false,

				fileElementId:'fileToUpload',

				dataType: 'json',

				data:{name:'logan', id:'id'},

				success: function (data, status)

				{

					if(typeof(data.error) != 'undefined')

					{

						if(data.error != '')

						{

							alert(data.error);

						}else

						{

							alert(data.msg);

						}

					}

				},

				error: function (data, status, e)

				{

					alert(e);

				}

			}

		)

		

		return false;



	}

	

	function addExpectedExpense(page, func)

	{

		

		if($('#category_id').val() == '0')

		{

			alert(error.Account.sel_category);

			$('#category_id').focus();		

		}

		else if($('#amount_inr').val() == "")

		{

			alert(error.Account.amount_inr);

			$('#amount_inr').focus();	

		}

		else if(isNaN($('#amount_inr').val()))

		{

			alert(error.Account.amount_inr_valid);

			$('#amount_inr').focus();

		}

		else if($('#expected_payment_date').val() == "")

		{

			alert(error.Account.payment_recived_date);

			$('#expected_payment_date').focus();	

		}

		else if($('#remark').val() == "")

		{

			alert(error.Account.sel_remarks);

			$('#remark').focus();	

		}

		else

		{

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}

	}

	

	function addClient(page,func)

	{	var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

	

		if($('#client_biz_name').val() == "")

		{

        	alert(error.Client.client_biz_name);

			$('#client_biz_name').focus();				

		}

		else if($('#client_name').val() == "")

		{

        	alert(error.Client.client_name);

			$('#client_name').focus();				

		}

		else if($('#client_email').val() == "")

		{

        	alert(error.Client.email);

			$('#client_email').focus();	

		}

		else if(!filter.test($('#client_email').val())) 

		{

			alert(error.Client.email_valid);

			$('#client_email').focus();	

		}

		else if($('#client_phone').val() == "")

		{

        	alert(error.Client.phone_no);

			$('#client_phone').focus();	

		}

		else if(isNaN($('#client_phone').val()) )

		{

			alert(error.User.valid_phone_no);

			$('#client_phone').focus();

		}

		else if($('#client_phone').val().length < 10 )

		{

			alert(error.User.valid_phone_no);

			$('#client_phone').focus();

		}

		else

		{

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}

	}

	

	function addProject(page,func)

	{

		if($('#project_name').val()=="")

		{

        	alert(error.Project.project_name);				

			$('#project_name').focus();

			return false;

		}

		else if($('#client').val()=="0")

		{

        	alert(error.Project.sel_client);				

			$('#client').focus();

			return false;

		}
		else if($('#employee_id').val()=="0")
		{
        	alert(error.Project.sel_employee);				
			$('#employee_id').focus();
			return false;
		}
		else if($('#project_category_id').val()=="0")

		{

        	alert(error.Project.sel_project_category);				

			$('#project_category_id').focus();

			return false;

		}

		else if(isNaN($('#project_cost_INR').val()))

		{

        	alert(error.Project.project_cost_inr);				

			$('#project_cost_INR').focus();

			return false;

		}

		else if(isNaN($('#project_cost_INR').val()))

		{

        	alert(error.Project.project_cost_inr_valid);		

			$('#project_cost_INR').focus();

			return false;

		}

		else if(isNaN($('#project_expense').val()))

		{	

        	alert(error.Project.expense_valid);							

			$('#project_expense').focus();

			return false;

		}

	   	else if($('#client').val() == "")

		{

        	alert(error.Project.sel_client);

			$('#client').focus();				

			return false;

		}		

		else

		{

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}

	}

	
	

	function addIncome(page, func)

	{

		

		if($('#category_id').val() == '0')

		{

        	alert(error.Account.sel_category);

			$('#category_id').focus();					

		}

		else if(isNaN($('#amount_usd').val()))

		{

        	alert(error.Account.amount_usd);

			$('#amount_usd').focus();		

		}

		else if(isNaN($('#conversion_rate').val()))

		{

        	alert(error.Account.conversion_rate_valid);	

			$('#conversion_rate').focus();	

		}

		else if($('#amount_inr').val() == "")

		{

        	alert(error.Account.amount_inr);

			$('#amount_inr').focus();		

		}

		else if(isNaN($('#amount_inr').val()))

		{

        	alert(error.Account.amount_inr_valid);

			$('#amount_inr').focus();		

		}

		else if($('#payment_recived_date').val() == "")

		{

        	alert(error.Account.sel_category);

			$('#payment_recived_date').focus();		

		}

		else if($('#remark').val() == "")

		{

        	alert(error.Account.sel_remarks);

			$('#remark').focus();					

		}else {
			var file_name = $('#invoice').val();
			if(file_name != ''){
				var fileNameIndex = file_name.lastIndexOf("\\") + 1;
				var filename = file_name.substr(fileNameIndex);
				
				var extIndex = filename.lastIndexOf(".") + 1;
				var ext = filename.substr(extIndex);
				
				if(ext != 'doc' && ext != 'docx' && ext != 'pdf')
				{
					alert("File extention must be .doc, .docx, .pdf");
					return false;
				}
			}
			$('#page').val(page);
			$('#function').val(func);
			$('#mainForm').submit();
		}

		return false;

	}

	

	function addExpense(page, func)

	{		

		if($('#category_id').val() == '0')

		{

        	alert(error.Account.sel_category);

			$('#category_id').focus();		

		}

		else if($('#amount_inr').val() == "")

		{

        	alert(error.Account.amount_inr);

			$('#amount_inr').focus();		

		}

		else if(isNaN($('#amount_inr').val()))

		{

        	alert(error.Account.amount_inr_valid);

			$('#amount_inr').focus();		

		}

		else if($('#payment_recived_date').val() == "")

		{

        	alert(error.Account.payment_recived_date);

			$('#payment_recived_date').focus();		

		}

		else if($('#remark').val() == "")

		{

        	alert(error.Account.sel_remarks);

			$('#remark').focus();		

		}
		else {
			var file_name = $('#invoice').val();
			if(file_name != ''){
				var fileNameIndex = file_name.lastIndexOf("\\") + 1;
				var filename = file_name.substr(fileNameIndex);
				
				var extIndex = filename.lastIndexOf(".") + 1;
				var ext = filename.substr(extIndex);
				
				if(ext != 'doc' && ext != 'docx' && ext != 'pdf')
				{
					alert("File extention must be .doc, .docx, .pdf");
					return false;
				}
			}
			$('#page').val(page);
			$('#function').val(func);
			$('#mainForm').submit();
		}

	}

	

	function updateExpectedExpense(id,page, func)

	{

		if($('#amount_inr').val() == "")

		{

			alert(error.Account.amount_inr);

			$('#amount_inr').focus();

		}

		else if(isNaN($('#amount_inr').val()))

		{

			alert(error.Account.amount_inr_valid);

			$('#amount_inr').focus();

		}

		else if($('#expected_payment_date').val() == "")

		{

			alert(error.Account.payment_recived_date);

			$('#expected_payment_date').focus();	

		}

		else if($('#remark').val() == "")

		{

			alert(error.Account.sel_remarks);

			$('#remark').focus();

		}
		else {
				var file_name = $('#invoice').val();
				if(file_name != ''){
					var fileNameIndex = file_name.lastIndexOf("\\") + 1;
					var filename = file_name.substr(fileNameIndex);
					
					var extIndex = filename.lastIndexOf(".") + 1;
					var ext = filename.substr(extIndex);
					
					if(ext != 'doc' && ext != 'docx' && ext != 'pdf')
					{
						alert("File extention must be .doc, .docx, .pdf");
						return false;
					}
				}
				$('#page').val(page);
				$('#function').val(func);
				$('#edit_id').val(id);
				$('#mainForm').submit();
			}

	}



	function updateProduct(id,page,func)

	{	

		if($('#product_name').val()=="")

		{

			alert(error.Product.product_name);		

			$('#product_name').focus();

			return false;

		}

		else if($('#item_code').val()=="")

		{

			alert(error.Product.item_code);	

			$('#item_code').focus();

			return false;

		}

		else if($('#basic_cost').val()=="")

		{

			alert(error.Product.basic_cost);

			$('#basic_cost').focus();

			return false;

		}

		else if(isNaN($('#basic_cost').val()))

		{	

			alert(error.Product.basic_cost_valid);	

			$('#basic_cost').focus();

			return false;

		}

		else

		{

			$('#edit_id').val(id);

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}

	}

	

	function updateExpense(id,page, func)

	{

    	if($('#category_id').val() == '0')

		{

        	alert(error.Account.sel_category);

			$('#category_id').focus();	

		}

		else if($('#amount_inr').val() == "")

		{

			alert(error.Account.amount_inr);

			$('#amount_inr').focus();	

		}

		else if(isNaN($('#amount_inr').val()))

		{

			alert(error.Account.amount_inr_valid);

			$('#amount_inr').focus();	

		}

		else if($('#payment_recived_date').val() == "")

		{

			alert(error.Account.payment_recived_date);

			$('#payment_recived_date').focus();		

		}

		else if($('#remark').val() == "")

		{

			alert(error.Account.sel_remarks);

			$('#remark').focus();		

		}

		else {
			var file_name = $('#invoice').val();

			if(file_name != ''){
				var fileNameIndex = file_name.lastIndexOf("\\") + 1;
				var filename = file_name.substr(fileNameIndex);
				
				var extIndex = filename.lastIndexOf(".") + 1;
				var ext = filename.substr(extIndex);
				
				if(ext != 'doc' && ext != 'docx' && ext != 'pdf')
				{
					alert("File extention must be .doc, .docx, .pdf");
					return false;
				}
			}
			$('#page').val(page);
			$('#function').val(func);
			$('#edit_id').val(id);
			$('#mainForm').submit();
		}

		return false;

	}



	function markAsPaidExpectedExpense(id,page,func)

	{

		if(confirm(error.Account.markaspaid)){

			$('#edit_id').val(id);

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}

	}

	

	function addProjectCategory(page,func)

	{

		

		 if($('#project_category_name').val() == "")

		{

        	alert(error.Setting.project_category_name);			

			$('#project_category_name').focus();

			return false;

		}

		else

		{

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}

	}

	

	function addFunction(page,func)

	{

		//alert(page);

		  if($('#function_name').val() == "")

		{

			alert(error.Setting.function_name);			

			$('#function_name').focus();

			return false;

		}

		else if($('#friendly_name').val() == "")

		{

			alert(error.Setting.function_friendly_name);				

			$('#friendly_name').focus();

			return false;

		}

		else if($('#page_id').val() == "0")

		{

			alert(error.Setting.page_module_name);				

			$('#page_id').focus();

			return false;

		}

		else

		{

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}

	}

	

	function addEmployee(page,func)

	{	

		var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

		var r = "^[a-zA-Z0-9]*$";

		

		 if($('#employee_user_name').val() == "")

		 {

         	alert(error.Employee.user_name);	

			$('#employee_user_name').focus();

			return false;

		 }

		  else if($('#employee_user_name').val().search(r) == -1)

		 {

         	alert(error.Employee.alpha_num);				

			$('#employee_user_name').focus();

			return false;

		 }

		  if($('#employee_name').val() == "")

		{

        	alert(error.Employee.empname);			

			$('#employee_name').focus();

			return false;

		}

		else if($("#employee_password").val().length < 6 )

		{

        	alert(error.Employee.password_length);	

			$('#employee_password').focus();

			return false;		

		}

		else if($('#per_address').val() == "")

		{

        	alert(error.Employee.address);	

			$('#per_address').focus();

			return false;

		}

		else if($('#phone_number').val() == "")

		{

        	alert(error.Employee.phone_no);	

			$('#phone_number').focus();

			return false;

		}

		else if(isNaN($('#phone_number').val()))

		{

        	alert(error.Employee.phone_valid);	

			$('#phone_number').focus();

			return false;

		}

		else if($('#phone_number').val().length < 10 )

		{

        	alert(error.Employee.phone_length);	

			$('#phone_number').focus();

			return false;

		}

		else if($('#joining_date').val() == "")

		{

        	alert(error.Employee.joining_date);				

			$('#joining_date').focus();

			return false;

		}

		else if($('#personal_email').val() == "")

		{

        	alert(error.Employee.personal_email);				

			$('#personal_email').focus();

			return false;

		}

		else if (!filter.test($('#personal_email').val())) 

		{

        	alert(error.Employee.personal_email_valid);	    		

			$('#personal_email').focus();

			return false;

 		}

		else if ($('#company_email').val()!="" && !filter.test($('#company_email').val())) 

		{

        	alert(error.Employee.company_email);	

			$('#company_email').focus();

			return false;

		}

		else

		{

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}		

	}

	

	function setFinancialMonth(page,func)

	{

		//alert(1);

		if($('#financial_month').val() < 2 || $('#financial_month').val() > 29)

		{

			alert(error.Setting.financial_month);

		}

		else

		{

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}

		return false;

	}

	

	function chkProjectCategory()

	{

		//alert(page);

		 if($('#project_category_name').val() == "")

		{

			 alert(error.Setting.project_category_name);

			$('#project_category_name').focus();

			return false;

		}

		else

		{

			updateProjectCategory('settings.php','edit_project_category_entry');

		}

		

	}

	

	function openEditClient(id,page,func)

	{

		$('#edit_id').val(id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

	

	function openEditProject(id,page,func)

	{

		$('#edit_id').val(id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

	function openEditCandidate(id,page,func)

	{

		$('#edit_id').val(id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

	function openEditLead(lead_id,page,func)

	{	

		$('#edit_id').val(lead_id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

	

	function openEditEmployee(employee_id,page,func)

	{	//alert("hii");

	$('#edit_id').val(employee_id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

	

	function openEditMaterial(id,page,func)

	{

		$('#edit_id').val(id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

	

	function openDeleteClient(id,cname,page,func)

	{

		if(confirm(error.Client.delclient+" "+cname))

		{	$('#edit_id').val(id);

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}

	}
	
	function openDeleteCandidate(id,cname,page,func)

	{

		if(confirm(error.Employee.delcandidate+" "+cname))

		{	$('#edit_id').val(id);

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}

	}

	

	function openDeleteExpectedExpense(id,page,func)

	{

		if(confirm(error.Account.delexpexpense))

		{	$('#edit_id').val(id);

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}

	}

	

	function openDeleteIncome(id,page,func)

	{

		if(confirm(error.Account.delincome))

		{	$('#edit_id').val(id);

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}

	}

	

	function openDeleteExpense(id,page,func)

	{

		if(confirm(error.Account.delexpense))

		{	$('#edit_id').val(id);

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}

	}

	

	function openDeleteMaterial(id,mname,page,func)

	{

		if(confirm(error.Account.delmaterial+" "+mname))

		{	$('#edit_id').val(id);

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}

	}



	function openDeleteWarehouse(id,wname,page,func)

	{

		if(confirm(error.Warehouse.delwarehouse+" "+wname))

		{	$('#edit_id').val(id);

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}

	}

	

	function deleteAppliedLeave(id,page,func)

	{

		if(confirm(error.Attendance.delleave))

		{	$('#edit_id').val(id);

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}

	}

	

	function updateClient(id,page,func)

	{

		var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

	

		if($('#client_biz_name').val() == "")

		{

        	alert(error.Client.client_biz_name);

			$('#client_biz_name').focus();				

		}

		else if($('#client_name').val() == "")

		{

        	alert(error.Client.client_name);

			$('#client_name').focus();				

		}

		else if($('#client_email').val() == "")

		{

        	alert(error.Client.email);

			$('#client_email').focus();	

		}

		else if(!filter.test($('#client_email').val())) 

		{

			alert(error.Client.email_valid);

			$('#client_email').focus();	

		}

		else if($('#client_phone').val() == "")

		{

        	alert(error.Client.phone_no);

			$('#client_phone').focus();	

		}

		else if(isNaN($('#client_phone').val()) )

		{	alert(error.User.valid_phone_no);

			$('#client_phone').focus();

		}

		else if($('#client_phone').val().length < 10 )

		{	alert(error.User.valid_phone_no);

			$('#client_phone').focus();

		}

		else

		{

			$('#edit_id').val(id);

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}

	}

	

	function updateIncome(id,page,func)

	{

		if($('#category_id').val() == '0')

		{

        	alert(error.Account.sel_category);

			$('#category_id').focus();				

		}

		else if(isNaN($('#amount_usd').val()))

		{

        	alert(error.Account.amount_usd);

			$('#amount_usd').focus();		

		}

		else if(isNaN($('#conversion_rate').val()))

		{

        	alert(error.Account.conversion_rate_valid);	

			$('#conversion_rate').focus();

		}

		else if($('#amount_inr').val() == "")

		{

        	alert(error.Account.amount_inr);

			$('#amount_inr').focus();	

		}

		else if(isNaN($('#amount_inr').val()))

		{

        	alert(error.Account.amount_inr_valid);

			$('#amount_inr').focus();		

		}

		else if($('#payment_recived_date').val() == "")

		{

        	alert(error.Account.sel_category);

			$('#payment_recived_date').focus();		

		}

		else if($('#remark').val() == "")

		{

        	alert(error.Account.sel_remarks);

			$('#remark').focus();				

		}
		else {
			var file_name = $('#invoice').val();
			if(file_name != ''){
				var fileNameIndex = file_name.lastIndexOf("\\") + 1;
				var filename = file_name.substr(fileNameIndex);
				
				var extIndex = filename.lastIndexOf(".") + 1;
				var ext = filename.substr(extIndex);
				
				if(ext != 'doc' && ext != 'docx' && ext != 'pdf')
				{
					alert("File extention must be .doc, .docx, .pdf");
					return false;
				}
			}
			$('#page').val(page);
			$('#function').val(func);
			$('#edit_id').val(id);
			$('#mainForm').submit();
		}
		return false;

	}

	

	function updateLead(id,page,func){

		var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

	//alert($('#lead_email').val());

		if($('#client').val() == 0)

		{

			alert(error.Sale.client);

			$('#client').focus();					

		}

		else if($('#product').val() == 0)

		{

			alert(error.Product.product_name);

			$('#product').focus();					

		}

		else if($('#source').val() == 0)

		{

			alert(error.Setting.source);

			$('#source').focus();					

		}

		else if($('#initial_contact_date').val() == "")

		{

			alert(error.Lead.initial_contact_date);

			$('#initial_contact_date').focus();						

		}

		else if($('#followup_date').val() == "")

		{

			alert(error.Lead.followup_date);

			$('#followup_date').focus();					

		}

		else if($('#status').val() == 0)

		{

			alert(error.Lead.sel_status);

			$('#status').focus();					

		}

		else if($('#lead_email').val() == " ")

		{

			alert(error.Lead.email_empty);

			$('#lead_email').focus();

		}

		else if(!filter.test($('#lead_email').val()))

		{

			alert(error.invalid_email);	

			$('#lead_email').focus();

		}

		else if($('#lead_phone').val()==" ")

		{

			alert(error.Lead.phone_empty);			

			$('#lead_phone').focus();

		}

		else if(isNaN($('#lead_phone').val()))

		{

			alert(error.invalid_phone);			

			$('#lead_phone').focus();

		}

		else if($('#lead_phone').val().length < 10)

		{

			alert(error.invalid_phone);	

			$('#lead_phone').focus();

		}
		else if(isNaN($('#number_of_meeting').val()))
		{
	
			alert(error.number_of_meeting);			
	
			$('#number_of_meeting').focus();
	
		}
		else

		{

			$('#edit_id').val(id);

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}

	}

	

	function updateMaterial(id,page,func)

	{

		if($('#material_name').val()=="")

		{

			alert(error.Material.material_name);

			$('#material_name').focus();

			return false;

		}

		else if($('#material_code').val()=="")

		{

			alert(error.Material.item_code);

			$('#material_code').focus();

			return false;

		}

		else if($('#material_cost').val()=="")

		{

			alert(error.Material.material_cost);

			$('#material_cost').focus();

			return false;

		}

		else if(isNaN($('#material_cost').val()))

		{	

			alert(error.Material.material_cost_valid);

			$('#material_cost').focus();

			return false;

		}

		else

		{

			$('#edit_id').val(id);

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}

	}

	

	function addPaymentCategory(page, func)

	{

		if($('#payment_category_name').val() == "")

		{

			alert(error.Setting.payment_category_name);

			$('#payment_category_name').focus();	

		}

		else if($('#payment_category_type').val() == "")

		{

			alert(error.Setting.payment_category_type);

			$('#payment_category_type').focus();

		}

		else

		{

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}

	}

	

	function updateProject(id,page,func)

	{	 if($('#project_name').val()=="")

		{

        	alert(error.Project.project_name);				

			$('#project_name').focus();

			return false;

		}

		else if($('#client').val()=="0")

		{

        	alert(error.Project.sel_client);				

			$('#client').focus();

			return false;

		}
		else if($('#employee_id').val()=="0")
		{
        	alert(error.Project.sel_employee);				
			$('#employee_id').focus();
			return false;
		}
		else if($('#project_category_id').val()=="0")

		{

        	alert(error.Project.sel_project_category);				

			$('#project_category_id').focus();

			return false;

		}

		else if(isNaN($('#project_cost_INR').val()))

		{

        	alert(error.Project.project_cost_inr);				

			$('#project_cost_INR').focus();

			return false;

		}

		else if(isNaN($('#project_cost_INR').val()))

		{

        	alert(error.Project.project_cost_inr_valid);		

			$('#project_cost_INR').focus();

			return false;

		}

		else if(isNaN($('#project_expense').val()))

		{	

        	alert(error.Project.expense_valid);							

			$('#project_expense').focus();

			return false;

		}

	   	else if($('#client').val() == "")

		{

        	alert(error.Project.sel_client);

			$('#client').focus();				

			return false;

		}

		else

		{

			$('#edit_id').val(id);

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}

	}

	

	function updateGraph(page,year)

	{

		$('#year').val(year);

		$('#page').val(page);

		$('#function').val('view');

		$('#mainForm').submit();

	}

	

	function updateLeaveSettings(page, func)

	{

		if($('#sick_leave').val() == "")

		{

        	alert(error.Setting.leave_sick_leave);			

			$('#sick_leave').focus();

		}

		else if(isNaN($('#sick_leave').val()))

		{	

        	alert(error.Setting.leave_sick_leave_valid);			

			$('#sick_leave').focus();

			return false;

		}

		else if($('#casual_leave').val() == "")

		{

        	alert(error.Setting.leave_casual_leave);			

			$('#casual_leave').focus();

		}

		else if(isNaN($('#casual_leave').val()))

		{	

        	alert(error.Setting.leave_casual_leave_valid);			

			$('#casual_leave').focus();

			return false;

		}

		else if($('#paid_leave ').val() == "")

		{

        	alert(error.Setting.leave_paid_leave);			

			$('#paid_leave').focus();

		}

		else if(isNaN($('#paid_leave').val()))

		{	

        	alert(error.Setting.leave_paid_leave_valid);			

			$('#paid_leave').focus();

			return false;

		}

		else if(confirm(error.Setting.leave_setting_change))

		{

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}

	}

	

	function parseISO8601(dateStringInRange) {

		var isoExp = /^\s*(\d{4})-(\d\d)-(\d\d)\s*$/,

			date = new Date(NaN), month,

			parts = isoExp.exec(dateStringInRange);

	

		if(parts) {

		  month = +parts[2];

		  date.setFullYear(parts[1], month - 1, parts[3]);

		  if(month != date.getMonth() + 1) {

			date.setTime(NaN);

		  }

		}

		return date;

	}

	

	function getSubStatusOfLead(page_name,fun,status_selected){

		$.ajax({

				url:"ajax.php",

				type:"POST",

				data:"page="+page_name+"&function="+fun+"&status_id="+status_selected,

				success:function(resp){

					var substatus_select='';

					for(var i=0; i<resp.length; i++){

						substatus_select+="<option value="+resp[i].substatus_id+">"+resp[i].substatus_name+"</option>";

					}

					$("#sub-status-select").html(substatus_select);

					$("#sub-status-select").change();	

				}

			});

	}

	

	function getProductsOfWarehouse(page_name,fun,warehouse_selected){

		$.ajax({

				url:"ajax.php",

				type:"POST",

				data : {

						'page'	: page_name,

						'function'	: fun,

						'warehouse_id'	: warehouse_selected

						},				

				success:function(resp){

					var product_select='<option value="0">Please Select</option>';

					for(var i=0; i<resp.length; i++)

					{	

						var disable = '';

						product_select+="<option value="+resp[i].product_id+" "+disable+">"+resp[i].product_name+"</option>";

					}

					product_combobox="<select id='product_id' class='product_dropdown' name='product_id[]' onchange='change_product_dropdown(this)'>"+product_select+"</select><div class='avail_qnty'>Available :<div class='qntity'></div></div>"; 

					$("#sale_lines select").html(product_select);

					$("#sale_lines input[type='text']").val("");

					$("#tax,#discount,#total_invoice_amount").val("0.0");

					$("#sale_lines select").change();	

				}

			});

	}

	

	

	$(function() {	

			

		$( "#leave_from_date" ).datepicker({

			dateFormat: "d-M-yy",

			altField: "#leave_from_date_alt",

			changeMonth: true,

			changeYear: true,

      		altFormat: "yy-mm-dd",

			minDate : 0+1,

			onSelect: function(selected) {

	          $("#leave_to_date").datepicker("option","minDate", selected)

	   		}

		});

		

		$( "#leave_to_date" ).datepicker({

			dateFormat: "d-M-yy",

			altField: "#leave_to_date_alt",

			changeMonth: true,

			changeYear: true,

      		altFormat: "yy-mm-dd",

			minDate : 0+1,

			onSelect: function(selected) {

	           $("#leave_from_date").datepicker("option","maxDate", selected)

        }



		});

		$( "#paid_date" ).datepicker({

			dateFormat: "d-M-yy",

			altField: "#paid_date_alt",

			changeMonth: true,

			changeYear: true,

      		altFormat: "yy-mm-dd"

		});

		

		$( "#expected_payment_date" ).datepicker({

			dateFormat: "d-M-yy",

			altField: "#expected_payment_date_alt",

			changeMonth: true,

			changeYear: true,

      		altFormat: "yy-mm-dd"

		});

		

		$( "#initial_contact_date" ).datepicker({

			dateFormat: "d-M-yy",

			altField: "#initial_contact_date_alt",

			changeMonth: true,

			changeYear: true,

      		altFormat: "yy-mm-dd"

		});

		$( "#followup_date" ).datepicker({

			dateFormat: "d-M-yy",

			altField: "#followup_date_alt",

			changeMonth: true,

			changeYear: true,

      		altFormat: "yy-mm-dd"

		});

		$( "#conversion_date" ).datepicker({

			dateFormat: "d-M-yy",

			altField: "#conversion_date_alt",

			changeMonth: true,

			changeYear: true,

      		altFormat: "yy-mm-dd"

		});

		$( "#initial_meeting_date" ).datepicker({

			dateFormat: "d-M-yy",

			altField: "#initial_meeting_date_alt",

			changeMonth: true,

			changeYear: true,

      		altFormat: "yy-mm-dd"

		});

		$( "#month_start_date" ).datepicker({

			dateFormat: "d-M-yy",

			altField: "#selected_month_alt",

			changeMonth: true,

			changeYear: true,

      		altFormat: "yy-mm-dd"

		});

		

    	$( "#datepicker" ).datepicker({

			dateFormat: "d-M-yy",

			altField: "#sent_alt",

			changeMonth: true,

			changeYear: true,

      		altFormat: "yy-mm-dd"

		});

		$( "#datepicker1" ).datepicker({

			dateFormat: "d-M-yy",

			altField: "#recived_alt",

			changeMonth: true,

			changeYear: true,

      		altFormat: "yy-mm-dd"

		});

	

		$( "#start_date" ).datepicker({

					

					dateFormat: "d-M-yy",

					altField: "#start_alt",

      				altFormat: "yy-mm-dd",

	  				defaultDate: "+1w",

      				changeMonth: true,

					changeYear: true,

      				numberOfMonths: 1,

      				onClose: function( selectedDate ) {

        			$( "#end_date,#expected_end_date" ).datepicker( "option", "minDate", selectedDate );

      								}

    	});

    

		$( "#expected_end_date" ).datepicker({

					dateFormat: "d-M-yy",

					altField: "#expected_end_alt",

      				altFormat: "yy-mm-dd",

	 				defaultDate: "+1w",

      				changeMonth: true,

					changeYear: true,

      				numberOfMonths: 1,

      				onClose: function( selectedDate ) {

        			$( "#start_date" ).datepicker( "option", "maxDate", selectedDate );

      								}

   		 });

		

	

		$( "#end_date" ).datepicker({

      				dateFormat: "d-M-yy",

					altField: "#end_alt",

      				altFormat: "yy-mm-dd",

	 				defaultDate: "+1w",

      				changeMonth: true,

					changeYear: true,

      				numberOfMonths: 1,

      				onClose: function( selectedDate ) {

        			$( "#start_date" ).datepicker( "option", "maxDate", selectedDate );

      								}

   		 });	

		 

		 $( "#date_of_birth" ).datepicker({

					

      				dateFormat: "d-M-yy",

					altField: "#dob_alt",

      				altFormat: "yy-mm-dd",

	  				defaultDate: "+1w",

      				changeMonth: true,

					changeYear: true,

      				numberOfMonths: 1,

					yearRange: "-100:+0",

      				onClose: function( selectedDate ) {

        			$( "#joining_date" ).datepicker( "option", "minDate", selectedDate );

      								}

    	});

    

		$( "#joining_date" ).datepicker({

      				dateFormat: "d-M-yy",

					altField: "#jd_alt",

      				altFormat: "yy-mm-dd",

	 				defaultDate: "+1w",

      				changeMonth: true,

					changeYear: true,

      				numberOfMonths: 1,

      				onClose: function( selectedDate ) {

        			$( "#date_of_birth" ).datepicker( "option", "maxDate", selectedDate );

      								}

   		 });

		 

  	});

	

	

	$(document).ready( function () {

		$(".addByDate").mouseenter(function(e){
			$(this).find(".added_modified_date").css("display","block");
		});
		
		$(".addByDate").mouseleave(function(e){
			$(this).find(".added_modified_date").css("display","none");
		});
		
		$(".modifiedByDate").mouseenter(function(e){
			$(this).find(".added_modified_date").css("display","block");
		});
		
		$(".modifiedByDate").mouseleave(function(e){
			$(this).find(".added_modified_date").css("display","none");
		});

		$("select.less_width").closest('.selector').addClass('small_sel');

		

		updateClock();		

		var curr_time=new Date();

		setTimeout('startClock()',(60-curr_time.getSeconds())*1000);

		

		$('.data-table').dataTable({

			"iDisplayLength": 15,

			"aLengthMenu": [[15,30,100,-1], [15,30,100,"All"]],

			"sPaginationType": "full_numbers",

			"oLanguage": {"sLengthMenu": "Show:_MENU_"}

		});

		

		$('.user-table').dataTable({

			"iDisplayLength": 10,

			"aLengthMenu": [[10,20,100,-1], [10,20,100,"All"]],

			"sPaginationType": "full_numbers",

		});

		

		$('#set_month_div input:radio').click(function() {

			if ($(this).val() === '1') {

				$('#month_start_date').val('');	

				$( "#slider" ).slider({ disabled: true });

				$('#financial_month').attr("disabled", true);

			} else if ($(this).val() === '2') {

			  	$('#month_start_date').show();

				$( "#slider" ).slider({ disabled: false });

				$('#financial_month').attr("disabled", false);

			} 

		  });

		  

		$('select').change(function(){

			var this_select=$(this);

			if($(this).parent().hasClass('selector')){

				$(this_select).parent().find('span').html($(this).find(':selected').html());

			}

		}); 



		$('input:checkbox').change(function(){

			var this_check=$(this);

			if($(this_check).is(':checked')){

				if(!$(this_check).parent().hasClass('checked')){

					$(this_check).parent().addClass('checked');

				}

			}else{

				if($(this_check).parent().hasClass('checked')){

					$(this_check).parent().removeClass('checked');

				}

			}

		});

		

		var tabindex_val = $("#tabindex_val").val();

		$('a[tabindex="'+parseInt(tabindex_val)+'"]').focus();

	});



	function addOrderStatus(page,func)

	{

		if($('#txtstatus').val() == "")

		{

        	alert(error.Setting.status_name);	

			$('#txtstatus').focus();

			return false; 			

		}

		else if($('#txtorder').val() == "")

		{

        	alert(error.Setting.status_order);	

			$('#txtorder').focus();

			return false; 

		}

		else if (isNaN($('#txtorder').val()))

		{

        	alert(error.Setting.status_order_valid);	

			$('#txtorder').focus();

			return false; 

		}

		else

		{

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}

		return false;

	}

	

	function editOrderStatus(id, page, func)

	{	

		$('#edit_id').val(id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

	function deleteOrderStatus(id, page, func)

	{

		if(confirm(error.Setting.delorderstatus))

		{	

			$('#edit_id').val(id);

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}	

	}

	function updatePermission(page, func)

	{

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

	function save_order(page, func)

	{

		//var quantity = $(this).closest('tr').find('.quantity').html(); 

		var edit_id = $("#edit_id").val();

		var recno = $('#txtrecieptno').val();

		var exist = 0;

		if(recno == "")

		{

        	alert(error.Order.reciept_no);

			$('#txtrecieptno').focus();

			return false;

		}		

		else if($('#warehouse_id').val() == "0")

		{

        	alert(error.Order.sel_warehouse);

			$('#warehouse_id').focus();

			return false;

		}

		else if($('#client').val() == "0")

		{

        	alert(error.Order.sel_client);

			$('#client').focus();

			return false;

		}

		else if(edit_id == '' && unique_exclude_product.length == "0")

		{

        	alert(error.Order.sel_item);

			$('#product_id').focus();

			return false;

		}

		else if(isNaN($('#tax').val()))

		{	

        	alert(error.Order.tax_valid);

        	$('#tax').focus();

			return false;

		}

		else if(isNaN($('#discount').val()))

		{	

        	alert(error.Order.discount_valid);

        	$('#discount').focus();

			return false;

		}

		else if(isNaN($('#total_invoice_amount').val()))

		{

        	alert(error.Order.inv_amount);

			$('#total_invoice_amount').focus();

			return false;

		}

		else

		{

			$.ajax({

				url:"ajax.php",

				type:"POST",

				data:"page=leads&function=check_receipt_exist&reciept_no="+recno+"&edit_id="+edit_id,

				success:function(resp){ 

					if(resp == 'exist')

					{

						alert(error.Order.reciept_no_exist);

						$('#txtrecieptno').val('');

						$('#txtrecieptno').focus();

						return false;

					}

					else

					{

						$('#page').val(page);

						$('#function').val(func);

						$('#mainForm').submit();

					}

					

				}

			});					

		}		

		return false;	

	}	

	function deleteOrder(id, page, func)

	{	

		if(confirm(error.Order.delorder))

		{	

			$('#edit_id').val(id);

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}	

	}

	function restoreOrder(id, page, func)

	{

		

		if(confirm(error.Order.restore))

		{	

			$('#edit_id').val(id);

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}	

	}

	function editOrder(id, page, func)

	{	

		$('#edit_id').val(id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

	function show_records(setval, page, func)

	{

		//alert(setval);

		$("#show_status").val(setval);

		//alert($("#show_status").val());

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}

	

	function show_lead_configuration(setval, page, func, hidden)

	{

		if(hidden == "status"){

			$("#show_lead_status").val(setval);

			$("#hidden").val(hidden);

		}

		else if(hidden == "sub_status"){

			$("#show_substatus").val(setval);

			$("#hidden").val(hidden);

		}

		else{

			$("#show_source").val(setval);

			$("#hidden").val(hidden);

		}

		//alert($("#show_status").val());

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

	}



	var unique_exclude_product = [];

function change_product_dropdown(element)

{	

	

	var exclude_product = [];

	var current_selected = $(element).val();

	

	$('select.product_dropdown').each(function() 

	{   

		if($(this).val() != 0)

		{

			exclude_product.push($(this).val());		

		}		

	});

	unique_exclude_product = [];

	$.each(exclude_product, function(i,v){

	   if ($.inArray(v, unique_exclude_product) == -1) unique_exclude_product.push(v);

	});

	

	$('select.product_dropdown').each(function() 

	{   

		select_elem = $(this);

		var arr_temp= $.grep(unique_exclude_product, function(value) {

			  return value != select_elem.val();

			});

			

		$(this).find('option').each(function() 

		{    		

			if(arr_temp.indexOf($(this).val()) !== -1) 

			{

				if(select_elem.find(":selected").val()!==$(this).val())

				{

					$(this).attr('disabled', true);

					$(this).css({backgroundColor: '#EAEAEA'});

				}

			}

			else

			{

				$(this).removeAttr('disabled');

				$(this).css({backgroundColor: '#FFFFFF'});

			}

		});		

	});

	

	if(current_selected != '0')

	{

		$(element).closest('tr').find('.quantity').focus();

	}

	getUnitsForProduct("leads","get_units_ajax",current_selected,element);

	

}

function getUnitsForProduct(module_name,fun,product_id,drp_object)

{	

	$.ajax({

			url:"ajax.php",

			type:"POST",

			data:"page="+module_name+"&function="+fun+"&product_id="+product_id,

			success:function(resp){

				 units = resp;

				 //$(drp_object).closest("tr").find(".quantity").val(resp);

				 

				 $(drp_object).closest("tr").find(".qntity").html(resp);

				 $(drp_object).closest("tr").find(".qntity").attr("original_value",resp);	 

				

			}

		});		

}

function openColorbox(id)

	{

		$.colorbox({opacity:"0.5",width:"18%",html:"<span>Please specify the reason for rejection</span><textarea id='reject_reason'></textarea><input type='button' value='OK' onclick='rejectAppliedLeave("+id+",\"hrm\",\"reject_applied_leave_ajax\")' />"});	

	}

	

function rejectAppliedLeave(id,page,func){

	reason = $('#reject_reason').val();

	reason = escape(reason);

	

	$.ajax({

			url:"ajax.php",

			type:"POST",

			data:"page="+page+"&function="+func+"&leave_id="+id+"&reject_reason="+reason,

			success:function(resp){

				$('#reject_'+id).hide();

				$(window).colorbox.close();

			}

		});

}



function approveAppliedLeave(id,page,func){

	$.ajax({

			url:"ajax.php",

			type:"POST",

			data:"page="+page+"&function="+func+"&leave_id="+id,

			success:function(resp){

				alert("Leave approved successfully");

				$('#approve_'+id).hide();

				//$('#reject_'+id).show();

			}

		});

}



function menu_callPage(page,function_name)

{	

	if(page != "")

	{

		document.getElementById('page').value = page;

		if(function_name==""){

			document.getElementById('function').value = "view";

		}else{

			document.getElementById('function').value = function_name;

		}

		$("#show_status").val('1');

		$('#from_menu').val('function'); //alert (('#from_menu').val()); 

		document.getElementById('mainForm').submit();

	}



}
function save_priority(page,func)
{
	if($('#value').val() == "")
	{
		alert(error.Setting.priority_value);	
		return false;
	}
	else if($('#priority_order').val() == "")
	{
		alert(error.Setting.priority_order);	
		return false;
	}
	else
	{
		$('#page').val(page);
		$('#function').val(func);
		$('#mainForm').submit();
	}
}
	
	function updatePosition(id,page, func)

	{	if($('#position_name').val() == "")

		{	alert(error.Setting.project_category_name);	

			$('#position_name').focus();

			return false;
		}

		else

		{

		$('#edit_id').val(id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

		}
	
	}
	
	function addPosition(page,func)

	{	if($('#position_name').val() == "")

		{
			alert(error.Setting.position_name);			

			$('#position_name').focus();

			return false;

		}

		else

		{

			$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}

	}
	
	function updatestatus(id,page, func)

	{	if($('#status_name').val() == "")

		{	alert(error.Setting.status_name);	

			$('#status_name').focus();

			return false;
		}

		else

		{

		$('#edit_id').val(id);

		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();

		}
	
	}
	
	function addstatus(page,func)

	{	if($('#status_name').val() == "")

		{
			alert(error.Setting.status_name);			

			$('#status_name').focus();

			return false;

		}

		else

		{	$('#page').val(page);

			$('#function').val(func);

			$('#mainForm').submit();

		}

	}
	
	function openEditEntry(position_id,page,func)

	{	$('#edit_id').val(position_id);
	
		$('#page').val(page);

		$('#function').val(func);

		$('#mainForm').submit();
	
	}
	
	
	
	function deleteEntry(id,uname,page,func)

	{	if(confirm("Do you want to delete Entry"+" "+uname))
	
		{	$('#edit_id').val(id);
	
			$('#page').val(page);
	
			$('#function').val(func);
	
			$('#mainForm').submit();
	
		}
	
	}
	
