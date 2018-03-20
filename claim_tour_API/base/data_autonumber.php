{
    "purchase-purchase":{
        "table"         : "purchase_hd",
        "cond"          : " and year(date)  = year(curdate()) and month(date) = month(curdate())",
        "format"        : "string,connection,date,connection,dateRomanic,connection,autonumber",
        "attr"          :   {
                                "connection"    : "/",
                                "string"        : "PO",
                                "date"          : "Y",
                                "dateRomanic"   : "m"
                            },
        "autonumber"    : " LPAD((ifnull(MAX(SUBSTRING(no_ref, -3, 3)),0) +1), 3,'0') no "
    },
    "order-order":{
        "table"         : "order_hd",
        "cond"          : " and year(date_trans)  = year(curdate()) and month(date_trans) = month(curdate())",
        "format"        : "string,connection,date,connection,dateRomanic,connection,autonumber",
        "attr"          :   {
                                "connection"    : "/",
                                "string"        : "TRX",
                                "date"          : "Y",
                                "dateRomanic"   : "m"
                            },
        "autonumber"    : " LPAD((ifnull(MAX(SUBSTRING(no_ref, -3, 3)),0) +1), 3,'0') no "
    },
    "payment-payment":{
        "table"         : "payment_hd",
        "cond"          : " and year(date)  = year(curdate()) and month(date) = month(curdate())",
        "format"        : "string,connection,date,connection,dateRomanic,connection,autonumber",
        "attr"          :   {
                                "connection"    : "/",
                                "string"        : "PAY",
                                "date"          : "Y",
                                "dateRomanic"   : "m"
                            },
        "autonumber"    : " LPAD((ifnull(MAX(SUBSTRING(no_ref, -3, 3)),0) +1), 3,'0') no "
    },
    "delivery-delivery":{
        "table"         : "delivery_hd",
        "cond"          : " and year(date)  = year(curdate()) and month(date) = month(curdate())",
        "format"        : "string,connection,date,connection,dateRomanic,connection,autonumber",
        "attr"          :   {
                                "connection"    : "/",
                                "string"        : "DEV",
                                "date"          : "Y",
                                "dateRomanic"   : "m"
                            },
        "autonumber"    : " LPAD((ifnull(MAX(SUBSTRING(no_ref, -3, 3)),0) +1), 3,'0') no "
    },
    "return-order":{
        "table"         : "return_order_hd",
        "cond"          : " and year(date)  = year(curdate()) and month(date) = month(curdate())",
        "format"        : "string,connection,date,connection,dateRomanic,connection,autonumber",
        "attr"          :   {
                                "connection"    : "/",
                                "string"        : "RO",
                                "date"          : "Y",
                                "dateRomanic"   : "m"
                            },
        "autonumber"    : " LPAD((ifnull(MAX(SUBSTRING(no_ref, -3, 3)),0) +1), 3,'0') no "
    },
    "return-purchase":{
        "table"         : "return_purchase_hd",
        "cond"          : " and year(date)  = year(curdate()) and month(date) = month(curdate())",
        "format"        : "string,connection,date,connection,dateRomanic,connection,autonumber",
        "attr"          :   {
                                "connection"    : "/",
                                "string"        : "RP",
                                "date"          : "Y",
                                "dateRomanic"   : "m"
                            },
        "autonumber"    : " LPAD((ifnull(MAX(SUBSTRING(no_ref, -3, 3)),0) +1), 3,'0') no "
    },
    "receive-receive":{
        "table"         : "receive_hd",
        "cond"          : " and year(date)  = year(curdate()) and month(date) = month(curdate())",
        "format"        : "string,connection,date,connection,dateRomanic,connection,autonumber",
        "attr"          :   {
                                "connection"    : "/",
                                "string"        : "REC",
                                "date"          : "Y",
                                "dateRomanic"   : "m"
                            },
        "autonumber"    : " LPAD((ifnull(MAX(SUBSTRING(no_ref, -3, 3)),0) +1), 3,'0') no "
    },
    "adjust-adjust":{
        "table"         : "adjust_hd",
        "cond"          : " and year(date)  = year(curdate()) and month(date) = month(curdate())",
        "format"        : "string,connection,date,connection,dateRomanic,connection,autonumber",
        "attr"          :   {
                                "connection"    : "/",
                                "string"        : "ADJ",
                                "date"          : "Y",
                                "dateRomanic"   : "m"
                            },
        "autonumber"    : " LPAD((ifnull(MAX(SUBSTRING(no_ref, -3, 3)),0) +1), 3,'0') no "
    },
    "transfer-transfer":{
        "table"         : "trf_stock_hd",
        "cond"          : " and year(date)  = year(curdate()) and month(date) = month(curdate())",
        "format"        : "string,connection,date,connection,dateRomanic,connection,autonumber",
        "attr"          :   {
                                "connection"    : "/",
                                "string"        : "TRF",
                                "date"          : "Y",
                                "dateRomanic"   : "m"
                            },
        "autonumber"    : " LPAD((ifnull(MAX(SUBSTRING(no_ref, -3, 3)),0) +1), 3,'0') no "
    },
	"expend-specific":{
        "table"         : "expend_hd",
        "cond"          : " and year(date)  = year(curdate()) and month(date) = month(curdate())",
        "format"        : "string,connection,date,connection,dateRomanic,connection,autonumber",
        "attr"          :   {
                                "connection"    : "/",
                                "string"        : "EX",
                                "date"          : "Y",
                                "dateRomanic"   : "m"
                            },
        "autonumber"    : " LPAD((ifnull(MAX(SUBSTRING(no_ref, -3, 3)),0) +1), 3,'0') no "
	}
}