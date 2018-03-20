{

	"active":{
					"table" : " status2 ",
    				"cond"  : " and type = 'active'",
    				"data"  : " value, name"
			},

    "gender":{
                    "table" : " status2 ",
                    "cond"  : " and type = 'gender'",
                    "data"  : " value, name"
            },

    "permission":{
                    "table" : " status2 ",
                    "cond"  : " and type = 'permission' ",
                    "data"  : " value, name"
            },

    "user-level":{
                    "table" : " user_level ",
                    "cond"  : " and status = 1",
                    "data"  : " code value, name, id special_value"
            },

    "category-product":{
                    "table" : " product_category ",
                    "cond"  : " and status = 1",
                    "data"  : " category_code value, category_name name"
            },

    "submenu-menuname":{
                    "table" : " submenuadmin ",
                    "cond"  : " and active = 'Y' order by submenuadminnm ASC",
                    "data"  : " menu value, submenuadminnm name"
            },

    "outlet-code":{
                    "table" : " outlet ",
                    "cond"  : " and (status = 1  or status = 99) and find_in_set(code,(select outlet_search from users where username = ?)) order by name ASC",
                    "data"  : " code value, name name"
            },

    "outlet-code-not-all":{
                    "table" : " outlet ",
                    "cond"  : " and code != 'all' and (status = 1  or status = 99) order by name ASC",
                    "data"  : " code value, name name"
            },

    "cassa-code":{
                    "table" : " cassa ",
                    "cond"  : " and (status = 1  or status = 99)",
                    "data"  : " code value, name name"
            },

    "product-id-price":{
                    "table" : " v_product ",
                    "cond"  : " ",
                    "data"  : " sku value, name name, price special"
            },

     "product-id-order":{
                    "table" : " v_product_price a inner join product_mst b on a.sku = b.sku ",
                    "cond"  : " ",
                    "data"  : " a.sku value, b.name name, a.price special"
            },
    "product-id-stock":{
                    "table" : " v_product a left join inventory b on a.sku = b.product_code ",
                    "cond"  : " and date(b.date) = date(now()) and track_inventory = 1 and find_in_set(?,outlet_search) group by a.sku",
                    "data"  : " a.sku value, a.name name, b.qty special"
            },
    "product-id-stock-trf":{
                    "table" : " v_product a left join inventory b on a.sku = b.product_code ",
                    "cond"  : " and date(b.date) = date(now()) and track_inventory = 1 and find_in_set(?,outlet_search) and find_in_set(?,outlet_search) group by a.sku",
                    "data"  : " a.sku value, a.name name, b.qty special"
            },
    "supplier-id":{
                    "table" : " supplier ",
                    "cond"  : " and status = 1",
                    "data"  : " id value, name name"
            },
    "supplier-code":{
                    "table" : " supplier ",
                    "cond"  : " and status = 1",
                    "data"  : " code value, name name"
            },
    "tax-amount":{
                    "table" : " tax ",
                    "cond"  : " and status = 1",
                    "data"  : " id value, concat(name,' ',amount,' ',if(type_tax=1,'%','Value')) name , type_tax, amount"
            },
    "customer-email":{
                    "table" : " customer ",
                    "cond"  : " and status = 1",
                    "data"  : " email value, name name"
            },
    "order-ref-return":{
                    "table" : " v_order ",
                    "cond"  : " and status = 1 ",
                    "data"  : " no_ref value, concat(ifnull(date(date_trans),' '),' ',no_ref,' ',ifnull(member_name,''),' ',ifnull(outlet_name,'')) name"
            },

    "purchase-ref-return":{
                    "table" : " v_purchase ",
                    "cond"  : " and status = 1 ",
                    "data"  : " no_ref value, concat(ifnull(date(date),' '),' ',no_ref,' ',ifnull(supplier_name,''),' ',ifnull(outlet_name,'')) name"
            },
    "package-mopos":{
                    "table" : " `pos_simple_register`.`extend_date` ",
                    "cond"  : "",
                    "data"  : " * "
            }
}