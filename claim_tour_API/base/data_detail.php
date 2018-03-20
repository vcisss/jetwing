{
	"variant" : {
					"table"    : "product_det",
                    "index"    : "product_code",
    				"parent"   : "code"
				},

	"privilege" : {
					"table"    : "user_priv",
                    "index"    : "level",
    				"parent"   : "id"
				},
	"purchase" : {
					"table"    : "purchase_det",
                    "index"    : "no_ref",
    				"parent"   : "no_ref"
				},
	"order" : {
					"table"    : "trans_so_det",
                    "index"    : "noSo",
    				"parent"   : "noSo"
				},
	"delivery" : {
					"table"    : "delivery_det",
                    "index"    : "no_ref",
    				"parent"   : "no_ref"
				},
	"receive" : {
					"table"    : "receive_det",
                    "index"    : "no_ref",
    				"parent"   : "no_ref"
				},
	"adjust" : {
					"table"    : "adjust_det",
                    "index"    : "no_ref",
    				"parent"   : "no_ref"
				},
	"transfer" : {
					"table"    : "trf_stock_det",
                    "index"    : "no_ref",
    				"parent"   : "no_ref"
				},
	"productstock" : {
					"table"    : "product_stok_in",
                    "index"    : "id_product",
    				"parent"   : "id"
				},
	"productprice" : {
					"table"    : "product_price",
                    "index"    : "sku",
    				"parent"   : "sku"
				},
	"productalert" : {
					"table"    : "product_alert",
                    "index"    : "sku",
    				"parent"   : "sku"
				},
	"returnorder" : {
					"table"    : "return_order_det",
                    "index"    : "no_ref",
    				"parent"   : "no_ref"
				},
	"returnpurchase" : {
					"table"    : "return_purchase_det",
                    "index"    : "no_ref",
    				"parent"   : "no_ref"
				},
	"woo_order" : {
					"table"    : "woo_order_det",
                    "index"    : "id_order",
    				"parent"   : "id"
				}
}