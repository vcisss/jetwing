<?php
  $this->load->library('session');
  $session_name=$this->session->userdata('username');
  $session_level = $this->session->userdata('userlevel');
  $this->load->model('Menumodel');
  $this->load->library('globallib');

  $Menumodel=new Menumodel();
  $data = $Menumodel->get_root($session_level);
//echo "<pre>";print_r($data);echo "</pre>";die();
  $dropdown = $Menumodel->get_drop_down($session_level);
  $mylib = new globallib();
  //$mnH = $this->global_model->get_root($session_level);
?>


<ul id="main-menu" class="">
    <!-- add class "multiple-expanded" to allow multiple submenus to open -->
    <!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->
    <!-- Search Bar
    <li id="search">
        <form method="get" action="">
            <input type="text" name="q" class="search-input" placeholder="Search something..."/>
            <button type="submit">
                <i class="entypo-search"></i>
            </button>
        </form>
    </li>-->

    <?php
    for($a=0;$a<count($data);$a++)
    {
        $base = "";
        if($data[$a]['url']!="")
        {
            $base = base_url();
        }
        if($data[$a]['FlagAktif']=='1'){
            ?>
                <li>
                    <a href="<?=base_url().$data[$a]['url'];?>">
                        <?php echo (!empty($data[$a]['icon']))?"<i class='".$data[$a]['icon']."'></i>":"<i class='entypo-window'></i>";?>
                        <span><?=$data[$a]['nama'];?></span>
                    </a>
                    <?php
                    if($data[$a]['ulid']!="") {
                        echo "<ul>";
                        getMenu($data[$a]['ulid'], $session_level);
                        echo "</ul>";
                    }
                    ?>
                </li>
    <?php
        }
    }
    ?>
    <!--
    <li>
        <a href="#">
            <i class="entypo-flow-tree"></i>
            <span>Menu Levels</span>
        </a>
        <ul>
            <li>
                <a href="#">
                    <i class="entypo-flow-line"></i>
                    <span>Menu Level 1.1</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="entypo-flow-line"></i>
                    <span>Menu Level 1.2</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="entypo-flow-line"></i>
                    <span>Menu Level 1.3</span>
                </a>
                <ul>
                    <li>
                        <a href="#">
                            <i class="entypo-flow-parallel"></i>
                            <span>Menu Level 2.1</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="entypo-flow-parallel"></i>
                            <span>Menu Level 2.2</span>
                        </a>
                        <ul>
                            <li>
                                <a href="#">
                                    <i class="entypo-flow-cascade"></i>
                                    <span>Menu Level 3.1</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="#">
                                            <i class="entypo-flow-branch"></i>
                                            <span>Menu Level 4.1</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="entypo-flow-cascade"></i>
                                    <span>Menu Level 3.2</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">
                            <i class="entypo-flow-parallel"></i>
                            <span>Menu Level 2.3</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>-->
</ul>

<?

/**
 * @param $root
 * @param $level
 */
 
function getMenu($root,$level)
{
 	$Menumodel=new Menumodel();
	$submenu = $Menumodel->get_sub_menu($root,$level);
	for($s = 0;$s<count($submenu);$s++)
	{
		  	if($submenu[$s]['FlagAktif']=='1'){
		?>

			<li>
                <a href="<?=base_url().$submenu[$s]['url']?>">
                    <?php echo (!empty($submenu[$s]['icon']))?"<i class='".$submenu[$s]['icon']."'></i>":"<i class='entypo-flow-branch'></i>";?>
                    <span><?=$submenu[$s]['nama'];?></span>
                </a>
                <?php
                    if($submenu[$s]['url']==''){
                        echo "<ul>";
                        getMenu2($submenu[$s]['nama'],$level);
                        echo "</ul>";
                }?>
            </li>
		<?php
		}
	}
}

function getSubMenu($root,$level)
{
 $Menumodel=new Menumodel();
 $submenu = $Menumodel->get_sub_menu($root,$level);
?>
    <li>
      <a href="#">
          <i class="entypo-flow-cascade"></i>
          <span><?=$root;?></span>
      </a>
      <ul>
        <?php //getMenu2($root,$level);?>
      </ul>
    </li>
<?php
}

function getMenu3($root,$level)
{
 	$Menumodel=new Menumodel();
	$submenu = $Menumodel->get_sub_menu($root,$level);
	for($s = 0;$s<count($submenu);$s++)
	{
		 if($submenu[$s]['url']!='')
		 {
		  	if($submenu[$s]['FlagAktif']=='1'){
		?>
			<li>
                <a href="<?=base_url().$submenu[$s]['url']?>">
                    <?php echo (!empty($submenu[$s]['icon'])) ? "<i class='".$submenu[$s]['icon']."'></i>" : "<i class='entypo-flow-cascade'></i>";?>
                    <span><?=$submenu[$s]['nama'];?></span>
                </a>
            </li>
		<?php
			}
		}
	}
}

function getMenu2($root,$level)
{
 	$Menumodel=new Menumodel();
	$submenu = $Menumodel->get_sub_menu($root,$level);
	for($s = 0;$s<count($submenu);$s++)
	{
		 
	  	if($submenu[$s]['FlagAktif']=='1'){
		?>
		<li>
            <a href="<?=base_url().$submenu[$s]['url']?>">
                <?php echo (!empty($submenu[$s]['icon'])) ? "<i class='".$submenu[$s]['icon']."'></i>" : "<i class='entypo-flow-cascade'></i>";?>
                <span><?=$submenu[$s]['nama'];?></span>
            </a>
            <?php
                if($submenu[$s]['url']==''){
                    echo "<ul>";
                    getMenu3($submenu[$s]['nama'],$level);
                    echo "</ul>";
            }?>
        </li>
		<?php
		}
	}
}
?>

