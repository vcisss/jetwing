[
    {
		"table"         : " `cassa` ",
        "cond"          : " and DATE_ADD(curdate(),interval 30 DAY) >= date_available",
		"data"          : " concat(DATEDIFF(timestamp(date_available),timestamp(now())),' Days') date_due,concat('Cassa ', name,' Used Left') show_fill",
        "colour"        : " info ",
        "icon"          : " fa fa-tablet ",
        "module_used"   : " billing.html ",
        "type"          : " expired "
     },
     {
        "table"         : " v_purchase ",
        "cond"          : " and DATEDIFF(exp_date,date(now())) <= exp_date_notif and status_pay != 'Paid' ",
        "data"          : " concat(DATEDIFF(exp_date,date(now())),' Days') date_due,if(DATEDIFF(exp_date,date(now())) <= 0,concat(no_ref,' due '),concat(no_ref,' almost due ')) show_fill",
        "colour"        : " warning ",
        "icon"          : " fa fa-shopping-cart ",
        "module_used"   : "  purchase.html ",
        "type"          : "  due_date "
     },
     {
        "table"         : " v_product a left join inventory b on a.sku = b.product_code ",
        "cond"          : " and b.qty <= b.qty_alert and date(b.date) = date(now()) and notif_alert = 1",
        "data"          : " b.outlet_code date_due,concat(a.name,' Invetory Left ',qty) show_fill",
        "colour"        : " warning ",
        "icon"          : " fa fa-barcode ",
        "module_used"   : "  inventory.html ",
        "type"          : "  inventory "
     }
]