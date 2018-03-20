var menus  = 
				{ 	
					json_post :
					{
						json_global : 'menus',
						cycle : 
							{
								name:'all_menu_filter',
								data:{
										where :[ 
													{
														fill 		: "date(createdtime)",
														operator 	:"between",
														data 		:['2016-05-14','2016-08-25']
													}
													
												]
									},
								param: 1
							}
					}

				};

var product  = 
				{ 	
					json_post :
					{
						json_global : 'menus',
						cycle : 
							{
								name:'all_menu_filter',
								data:{
										where :[ 
													{
														fill 		: "status",
														operator 	: "=",
														data 		: '1'
													}
													
												]
									},
								param: 1
							}
					}

				};


var category  = 
				{ 	
					json_post :
					{
						json_global : 'categorys',
						cycle : 
							{
								name:'all_category_filter',
								data:{	
										type  :'product',
										where :[ 
													{
														fill 		: "code",
														operator 	:"between",
														data 		:['2016-05-14','2016-08-25']
													}
													
												]
									},
								param: 1
							}
					}

				};				