{
	"Tax":{
					"table"     : " tax ",
                    "body"      :   {
                                    "name"          : "A",
                                    "amount"        : "B",
                                    "type_tax"      : "C"
                                    },
                    "unique"    : ["name"]
				},

    "Discount":{
                    "table"     : " discount ",
                    "body"      :   {
                                    "name"          : "A",
                                    "amount"        : "B",
                                    "type_discount" : "C"
                                    },
                    "unique"    : ["name"]          
                },

    "Cassa":{
                    "table"     : " cassa ",
                    "body"      :   {
                                    "code"          : "A",
                                    "name"          : "B",
                                    "outlet"        : "C"
                                    },
                    "unique"    : ["code"]
                },

    "Outlet":{
                    "table"     : " outlet ",
                    "body"      :   {
                                    "code"          : "A",
                                    "name"          : "B",
                                    "email"         : "C",
                                    "phone"         : "D",
                                    "fax"           : "E",
                                    "address"       : "F",
                                    "header"        : "G",
                                    "footer"        : "H",
                                    "description"   : "I",
                                    "status"        : "J"
                                    },
                    "unique"    : ["code"]                
                },
    "Supplier":{
                    "table"     : " supplier ",
                    "body"      :   {
                                    "code"          : "A",
                                    "name"          : "B",
                                    "email"         : "C",
                                    "phone"         : "D",
                                    "fax"           : "E",
                                    "address"       : "F",
                                    "state"         : "G",
                                    "city"          : "H",
                                    "zip"           : "I"
                                    },
                    "unique"    : ["code"]
                },
    "Customer":{
                    "table"     : " customer ",
                    "body"      :   {
                                    "name"          : "A",
                                    "email"         : "B",
                                    "phone"         : "C",
                                    "birth_date"    : "D",
                                    "gender"        : "E",
                                    "address"       : "F",
                                    "status"        : "G"
                                    },
                    "unique"    : ["code"]
                },
    "Employee":{
                    "table"     : " users ",
                    "body"      :   {
                                    "email"          : "A",
                                    "password"       : "B",
                                    "name"           : "C",
                                    "level"          : "D",
                                    "status"         : "E"
                                    },
                    "unique"    : ["email"]
                }
}