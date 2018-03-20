{

	"active":{
					"table" : " status2 ",
    				"cond"  : " and type = 'active'",
    				"data"  : " value, name"
			},

    "user-level":{
                    "table" : " user_level ",
                    "cond"  : " and status = 1",
                    "data"  : " code value, name"
            },

    "category-product":{
                    "table" : " product_category ",
                    "cond"  : " and status = 1",
                    "data"  : " category_code value, category_name name"
            },
    "submenu-menuname":{
                    "table" : " submenuadmin ",
                    "cond"  : " and active = 'Y'",
                    "data"  : " menu value, submenuadminnm name"
            },
    "outlet-code":{
                    "table" : " outlet ",
                    "cond"  : " and (status = 1  or status = 99)",
                    "data"  : " code value, name name"
            },

    "product-id":{
                    "table" : " product_mst ",
                    "cond"  : " and status = 1",
                    "data"  : " id value, name name, price special"
            },
    "supplier-id":{
                    "table" : " supplier ",
                    "cond"  : " and status = 1",
                    "data"  : " id value, name name"
            }
}