

<script>
    function windowOpener(windowHeight, windowWidth, windowName, windowUri, name)
    {
        var centerWidth = (window.screen.width - windowWidth) / 2;
        var centerHeight = (window.screen.height - windowHeight) / 2;
        //alert('aaaa');

        newWindow = window.open(windowUri, windowName, 'resizable=yes,scrollbars=yes,width=' + windowWidth +
            ',height=' + windowHeight +
            ',left=' + centerWidth +
            ',top=' + centerHeight
        );

        newWindow.focus();
        return newWindow.name;
    }
     
    function pop_up_memo()
    {
        windowOpener('600', '800', 'Memo', '<?php echo base_url(); ?>inventory/npm_memo.php', 'Memo')    
    }
    
    function pop_up_memo_edit(memo_id)
    {
        windowOpener('600', '800', 'Memo', '<?php echo base_url(); ?>inventory/npm_memo.php?action=edit&id='+memo_id, 'Memo')    
    }
    
    function pop_up_memo_delete(memo_id)
    {
        windowOpener('600', '800', 'Memo', '<?php echo base_url(); ?>inventory/npm_memo.php?action=delete&id='+memo_id, 'Memo')    
    }
</script>

<?php
    function format_show_datetime($date)
    {
        $arr_format = explode(" ", $date);
        $arr_date   = explode("-", $arr_format[0]);
        $arr_hour   = explode(":", $arr_format[1]);
        
        $return     = $arr_date[2]."/".$arr_date[1]."/".$arr_date[0]." ".$arr_hour[0].":".$arr_hour[1].":".$arr_hour[2];
        
        return $return;
    }
?>
	
<div class="profile-env"> 
	<header class="row"> 
		<div class="col-sm-2"> 
			<a href="#" class="profile-picture"> 
				<img src="<?php echo base_url(); ?>public/images/nopicture.png" style="width: 115px;" class="img-responsive img-circle"> </a> 
		</div> 
		<div class="col-sm-7"> 
			<ul class="profile-info-sections">
				<li>
					<div class="profile-name"> 
						<?php 
							if($employee_id)
							{
								echo "<strong>Hai,</strong>";
								echo "<span><a>".$myprofile->employee_name."</a></span>";
							}
							else
							{
								echo "<strong>Hai,</strong>";
								echo "<span><a>".$username."</a></span>";
							}
						?>
                        
                        
					</div> 
				</li> 
			</ul>
		</div> 
        
	</header> 
	
	<section class="profile-info-tabs"> 
		<div class="row"> 
			<div class="col-sm-offset-2 col-sm-10"> 
				<p>Selamat Datang di Aplikasi <strong>PT. Jetwings Group</strong>, Silakan pilih menu disamping untuk mengelola aplikasi.</p>
			</div>
		</div>
	</section>
    
    <?php 
        if($username=="ambar0410" || $username=="dicky0707" || $username=="hendri1003" || $username=="frangky2311")
        {
    ?>
    <div title="TAMBAH MEMO" style="cursor: pointer;" onclick="pop_up_memo()"><img src="<?php echo base_url(); ?>inventory/images/add.gif" alt=""> TAMBAH MEMO</div>
    <?php 
        }
        
            unset($arr_data);
            if(!isset($arr_data)){ $arr_data = isset($arr_data); } else { $arr_data = $arr_data; }
            
            /*$q = "
                    SELECT
                        db_natura.memo.memo_id,
                        db_natura.memo.memo_date,
                        db_natura.memo.subject,
                        db_natura.memo.content,
                        db_natura.memo.edited_date,
                        db_natura.memo.edited_user
                    FROM
                        db_natura.memo
                    WHERE
                        1
                    ORDER BY
                        db_natura.memo.edited_date DESC
                    LIMIT
                        0,10
            ";
            $qry = mysql_query($q);
            while($row = mysql_fetch_array($qry))
            {
                list(
                    $memo_id,
                    $memo_date,
                    $subject,
                    $content,
                    $edited_date,
                    $edited_user 
                ) = $row;
                
                $arr_data["list_memo"][$memo_id] = $memo_id;
                $arr_data["memo_date"][$memo_id] = $memo_date;
                $arr_data["subject"][$memo_id] = $subject;
                $arr_data["content"][$memo_id] = $content;
                $arr_data["edited_date"][$memo_id] = $edited_date;
                $arr_data["edited_user"][$memo_id] = $edited_user;
            }*/
    ?>
    <br>
    <?php 
        if(count($arr_data["list_memo"])*1>0)
        {
            foreach($arr_data["list_memo"] as $memo_id=>$val)
            {
                $memo_date = $arr_data["memo_date"][$memo_id];
                $subject = $arr_data["subject"][$memo_id];
                $content = $arr_data["content"][$memo_id];
                $edited_date = $arr_data["edited_date"][$memo_id];
                $edited_user = $arr_data["edited_user"][$memo_id]; 
                
                $content_echo = str_replace("\n", "<br>", $content);
        ?>
        <div title="<?php echo $subject; ?>" style="margin-bottom: 5px;">
            <div style="font-size: 14px; font-weight: bold;">
                
                <?php 
                    if($username=="ambar0410" || $username=="dicky0707" || $username=="hendri1003")
                    {
                        
                ?>
                <img style="cursor: pointer;" onclick="pop_up_memo_edit('<?php echo $memo_id; ?>')" src="<?php echo base_url(); ?>inventory/images/edit.png" alt="Edit <?php echo $subject; ?>" title="Edit <?php echo $subject; ?>"> 
                <img style="cursor: pointer;" onclick="pop_up_memo_delete('<?php echo $memo_id; ?>')" src="<?php echo base_url(); ?>inventory/images/delete.gif" alt="Hapus <?php echo $subject; ?>" title="Hapus <?php echo $subject; ?>">
                <?php 
                    }
                ?>
                <?php echo $subject; ?>
            </div>
            <div style="font-size: 11px; font-weight: bold;"><?php echo $edited_user; ?> Last Edited : <?php echo format_show_datetime($edited_date); ?></div>
            
            <div style="font-size: 12px; border-bottom: 2px solid gray; margin-bottom: 5px; margin-top: 5px;"><?php echo $content_echo; ?></div>
        </div>
        <?php 
            }
        }
    ?>
               

    
    
    
</div>
				
