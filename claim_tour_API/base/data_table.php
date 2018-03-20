{
	"user-priv":{
					"table" : " user a INNER JOIN user_mobile_privilege b on a.Tipe = b.KdTipe",
    				"cond"  : " AND a.UserName = ?",
    				"data"  : "b.MenuAdminCd,b.view,b.execute"
                },
	"user-access":{
					"table" : "view_user_login",
    				"cond"  : " AND Username = ? AND Password = md5(?) ",
    				"data"  : "Username,NamaTourGuide,KdTourGuide,Type,TypeName"
				},

    "group-groups":{
                    "table" : "group_tour",
                    "cond"  : " AND Status = 1 AND KdTourGuide = ?",
                    "data"  : "KdGroup,NamaGroup,Tanggal,Pax_adult Pax,PersentaseGuide,TipeOptionTour"
                },
    "main_activity-main_activitys":{
                    "table" : "aktivitasgroup",
                    "cond"  : " ",
                    "data"  : " * "
                },
    "optional_tour_activity-optional_tour_activitys":{
                    "table" : "aktivitasoptionaltour",
                    "cond"  : " ",
                    "data"  : " * "
                },
    "activity-activitys":{
                    "table" : "aktivitas",
                    "cond"  : " ",
                    "data"  : "KdAktivitas,NamaAktivitas,Jenis,IDR,USD,RMB,isEdit status_edit"
                },

    "report-report":{
                    "table" : "view_report_group_tour",
                    "cond"  : " AND KdTourGuide = ? GROUP BY KdGroup",
                    "data"  : "KdGroup,NamaGroup,Pax_adult Pax,ROUND(ifnull(sum(pax_set*IDR_ctg),0),2) IDR_ctg_sum,ROUND(ifnull(sum(pax_set*USD_ctg),0),2) USD_ctg_sum,ROUND(ifnull(sum(pax_set*RMB_ctg),0),2) RMB_ctg_sum,ROUND(ifnull(sum(pax_set*IDR_gtc),0),2) IDR_gtc_sum,ROUND(ifnull(sum(pax_set*USD_gtc),0),2)+ROUND(ifnull(sum(pax_set*Net),0),2) USD_gtc_sum,ROUND(ifnull(sum(pax_set*RMB_gtc),0),2) RMB_gtc_sum,ROUND(ifnull(sum(pax_set*HargaJualUSD),0),2) Sell_sum,ROUND(ifnull(sum(pax_set*Net),0),2) Net_sum"
                },
    "report-main":{
                    "table" : "aktivitasgroup a LEFT JOIN aktivitas b ON a.`KdAktivitas` = b.`KdAktivitas`",
                    "cond"  : " AND KdGroup = ? AND b.Jenis = ?",
                    "data"  : "a.KdGroup,b.NamaAktivitas,a.Tanggal,a.Pax,a.IDR,a.USD,a.RMB"
                },
    "report-optional":{
                    "table" : "aktivitasoptionaltour a LEFT JOIN optionaltour b ON a.`KdTour` = b.`KdTour`",
                    "cond"  : " AND KdGroup = ? ",
                    "data"  : "a.KdGroup,b.NamaTour,a.Tanggal,a.Pax,a.`HargaJualUSD` sell,a.Net"
                },

    "template-templates":{
                    "table" : "template",
                    "cond"  : " ",
                    "data"  : "jenis,title,header,isi"
                },

    "visitor-visitors":{
                    "table" : "visitor_information_header",
                    "cond"  : " ",
                    "data"  : "*"
                },

    "visitor-details":{
                    "table" : "visitor_information_detail",
                    "cond"  : " ",
                    "data"  : "*"
                },

    "cancel-cancels":{
                    "table" : "cancel_opt_header",
                    "cond"  : " ",
                    "data"  : "*"
                },

    "cancel-details":{
                    "table" : "cancel_opt_detail",
                    "cond"  : " ",
                    "data"  : "*"
                },

    "freeday-freedays":{
                    "table" : "free_day_statement",
                    "cond"  : " ",
                    "data"  : "*"
                },

    "opt-opts":{
                    "table" : "opt_header",
                    "cond"  : " ",
                    "data"  : "*"
                },

    

    "optional_tour-optional_tours":{
                    "table" : "view_group_optional_tour",
                    "cond"  : " ",
                    "data"  : "KdTour,NamaTour,HargaJualUSD,HPP,category,category_tourname"
                }

}