<style>
.title{
	color:red;
}
</style>
<?php
$str =  "";
	
$str .= "<table border='1px'>
			
				<tr><td class='title'>Compulsory(must include)</td><td>class='validate[required]'</td></tr>
				<tr><td class='title'>Not Compulsory</td><td>class='validate[optional]'</td></tr>
				<tr><td class='title'>Email Id</td><td>class='validate[required,custom[email]]'</td></tr>
				<tr><td class='title'>Only Number</td><td>class='validate[required,custom[onlyNumber]]'</td></tr>
				<tr><td class='title'>Only Letter</td><td>class='validate[required,custom[onlyLetter]]'</td></tr>
				<tr><td class='title'>Only Number & Letter</td><td>class='validate[required,custom[onlyLetterNumber]]'</td></tr>
				<tr><td class='title'>Only Number with spaces</td><td>class='validate[required,custom[onlyNumberSp]]'</td></tr>
				<tr><td class='title'>Only AlphaNumeric</td><td>class='validate[required,custom[onlyAlphaNumeric]]'</td></tr>
				<tr><td class='title'>minimum & maximum length</td><td>class='validate[required,length[min,max]]'</td></tr>
				<tr><td class='title'>Phone number</td><td>class='validate[required,length[min,max],custom[phone]]'</td></tr>
				<tr><td class='title'>Integer & decimal number</td><td>class='validate[required,custom[decimalNumber]]'</td></tr>
				<tr><td class='title'>Maximum or Minimum size</td><td>class='validate[required,minSize[x]/maxSize[x]]'</td></tr>
				<tr><td class='title'>must be the same as password field</td><td>class='validate[required,equals[password]]'</td></tr>
				
				<tr><td class='title'>Integer (Year)</td><td>class='class='validate[required,custom[integer],minSize[4],max[2000],min[1900]]'</td></tr>
				<tr><td class='title'>Date Using Datepicker</td><td>class='class='validate[required] datepicker'</td></tr>
				
				<tr><td class='title'>checkbox (must tick two tick boxes)</td><td>class='validate[minCheckbox[2]]'</td></tr>
				<tr><td class='title'>Change position of message</td><td>class='(data-prompt-position=”bottomLeft:20,5″)'</td></tr>
			
		</table>";	
echo $str;		
?>