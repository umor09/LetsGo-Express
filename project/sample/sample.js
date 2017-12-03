//++++++++++++++++++++++++++++++++++++++++++++++++++++
//     #### Combobox Controler  ####


jQuery(document).ready(function($) {
	/**
	 * Basic
	 */
	 
	 		/**
	 * Select-only with Display Sub-info *
	 */

 $('#product_search').ajaxComboBox(
		'lib/jquery.ajax-combobox.php',
		{
			lang: 'en',
			primary_key: 'product_id',
			bind_to: 'foo',
			db_table: 'branch_store',
			field: 'style_no',
			sub_info: true,
			sub_as: {

				sale_rate: 'Sale Rate',
				product_name: 'Brand name',
			},
			
			
			show_field: 'sale_rate , product_name',
			select_only: true
		
		}
	)
	
/*	.bind('foo', function(){
    alert($(this).val() + ' is selected.');
  });*/
	.bind('foo', function(e, is_enter_key){
		//if(!is_enter_key){
			$("#product_src_form").submit();
		//}
	})
	
	
	
	
	 $('#salesman').ajaxComboBox(
		'lib/jquery.ajax-combobox.php',
		{
			lang: 'en',
			primary_key: 'id',
			bind_to: 'foo',
			db_table: 'sales_man',
			field: 'full_name',
			sub_info: true,
			sub_as: {
				designation: 'Designation',
				address: 'Address',
				phone: 'Phone'
			},
			show_field: 'designation, address, phone',
			select_only: true
		}
	)
	.bind('foo', function(e, is_enter_key){
			//if(!is_enter_key){
				$("#salesman_form").submit();
			//}
		})
	
	
	$('#customer').ajaxComboBox(
	'lib/jquery.ajax-combobox.php',
		{
		lang: 'en',
		//primary_key: 'id',
		//bind_to: 'foo',
		db_table: 'customer',
		field: 'name',
		sub_info: true,
		sub_as: {
			address :'Address',
			age: 'Age',
			gender: 'Gender',
			email:'Email',
			phone: 'Phone'
		},
		
		
		show_field: 'address,age,gender,phone,email',
		select_only: true
		
		}
	)
	
	
	 
    $('#ac08_08').ajaxComboBox(
    'lib/jquery.ajax-combobox.php',
    {
      lang: 'en',
      plugin_type: 'textarea',
      tags: [
        {
          pattern: [' ', '  '],
          db_table: 'default_advice',
		  field: 'advice',
		  search_field: 'advice, id'
        }
      ],
    }
  );

	// ページ内リンクのスクロール
	$('a[href^=#]').click(function() {
		var href= $(this).attr("href");
		var target = $(href == "#" || href == "" ? 'html' : href);
		var position = target.offset().top - 10;
		$('body,html').animate({scrollTop: position}, 200, 'swing');
		history.pushState('', '', $(this)[0].href);
		return false;
	});


}); // end of "jQuery(document).ready"

function displayResult(id) {
	alert(
		id + ': ' + $('#' + id).val() + '\n' +
		id + '_primary_key' + ': ' + $('#' + id + '_primary_key').val()
	);
}