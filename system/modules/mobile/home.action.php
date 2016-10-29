<?php

defined('G_IN_SYSTEM')or exit('No permission resources.');

System::load_app_class('base','member','no');

System::load_app_fun('my','go');

System::load_app_fun('user','go');

System::load_sys_fun('send');

System::load_sys_fun('user');

class home extends base {

	public function __construct(){

		parent::__construct();

		if(ROUTE_A!='userphotoup' and ROUTE_A!='singphotoup'){

			// if(!$this->userinfo)_message("请登录",WEB_PATH."/mobile/user/login",3);
			if(!$this->userinfo) header("Location:".WEB_PATH."/mobile/user/login");
		}

		$this->db = System::load_sys_class('model');



	}

	public function init(){

	    $webname=$this->_cfg['web_name'];

		$member=$this->userinfo;

		$title="我的用户中心";
		$key = '我的云购';

		//$quanzi=$this->db->GetList("select * from `@#_quanzi_tiezi` order by id DESC LIMIT 5");



	 //获取用户等级  用户新手  用户小将==

	  $memberdj=$this->db->GetList("select * from `@#_member_group`");



	  $jingyan=$member['jingyan'];

	  if(!empty($memberdj)){

	     foreach($memberdj as $key=>$val){

		    if($jingyan>=$val['jingyan_start'] && $jingyan<=$val['jingyan_end']){

			   $member['yungoudj']=$val['name'];

			}

		 }

	  }



		include templates("mobile/user","index");

	}



function invite(){

        $webname=$this->_cfg['web_name'];

        $member=$this->userinfo;

        $title="我的用户中心";

        //$quanzi=$this->db->GetList("select * from `@#_quanzi_tiezi` order by id DESC LIMIT 5");



        //获取云购等级  云购新手  云购小将==

        $memberdj=$this->db->GetList("select * from `@#_member_group`");



        $jingyan=$member['jingyan'];

        if(!empty($memberdj)){

            foreach($memberdj as $key=>$val){

                if($jingyan>=$val['jingyan_start'] && $jingyan<=$val['jingyan_end']){

                    $member['yungoudj']=$val['name'];

                }

            }

        }

        include templates("mobile/user","invite");

    }

public function modify(){
	$mysql_model=System::load_sys_class('model');
	$member=$this->userinfo;
	$title="编辑个人资料";
	$member_qq=$this->db->GetOne("select * from `@#_member_band` where `b_uid`=$member[uid]");
	$member_dizhi=$mysql_model->Getlist("select * from `@#_member_dizhi` where uid='".$member['uid']."' limit 5");
	foreach($member_dizhi as $k=>$v){		
		$member_dizhi[$k] = _htmtocode($v);
	}
	$count=count($member_dizhi);
include templates("mobile/user","modify");
}
public function do_modify(){
	$username=$_POST['username'];
	$qianming=$_POST['qianming'];
	$uid=$_POST['uid'];
	$this->db->Query("UPDATE `@#_member` SET `username`='$username',`qianming`='$qianming' WHERE `uid`='$uid'");
	if($this->db->affected_rows()){
		_message('修改成功',WEB_PATH."/mobile/home");
	}else{
		_message('修改失败');
	}

}
public function address(){
	$member=$this->userinfo;
	$title="收货地址";
	$addresslist=$this->db->GetList("SELECT * FROM `@#_member_dizhi` WHERE `uid`='$member[uid]'");

	include templates("mobile/user","address");
}
public function add_address(){
	if($_POST['do_submit']){
		$sheng=$_POST['sheng'];
		$shi=$_POST['shi'];
		$xian=$_POST['xian'];
		$jiedao=$_POST['jiedao'];
		$youbian=$_POST['youbian'];
		$shouhuoren=$_POST['shouhuoren'];
		$mobile=$_POST['mobile'];
		$qq=$_POST['qq'];
		$time=time();
		$member=$this->userinfo;
		$this->db->Query("INSERT INTO `@#_member_dizhi` (`uid`,`sheng`,`shi`,`xian`,`jiedao`,`youbian`,`shouhuoren`,`mobile`,`qq`,`default`,`time`) VALUES ('$member[uid]','$sheng','$shi','$xian','$jiedao','$youbian','$shouhuoren','$mobile','$qq','N','$time')");
		if($this->db->affected_rows()){
			_message('添加成功',WEB_PATH."/mobile/home/address");
		}else{
			_message('添加失败');
		}
	}
	include templates("mobile/user","add_address");
}
public function edit_address(){
	$id=$this->segment(4);
	if($_POST['do_submit']){
		$id=$_POST['id'];
		$sheng=$_POST['sheng'];
		$shi=$_POST['shi'];
		$xian=$_POST['xian'];
		$jiedao=$_POST['jiedao'];
		$youbian=$_POST['youbian'];
		$shouhuoren=$_POST['shouhuoren'];
		$mobile=$_POST['mobile'];
		$qq=$_POST['qq'];
		$time=time();
		$r=$this->db->Query("UPDATE `@#_member_dizhi` SET `sheng`='$sheng',`shi`='$shi',`xian`='$xian',`jiedao`='$jiedao',`youbian`='$youbian',`shouhuoren`='$shouhuoren',`mobile`='$mobile',`qq`='$qq',`time`='$time' WHERE `id`='$id'");
		if($this->db->affected_rows()){
			_message('修改成功',WEB_PATH."/mobile/home/address");
		}else{
			_mesage('修改失败');
		}
	}
	$addressinfo=$this->db->GetOne("SELECT * FROM `@#_member_dizhi` WHERE `id`='$id'");
	include templates("mobile/user","edit_address");
}
public function moren(){
	$id=$_POST['id'];
	$def=$_POST['def'];
	$member=$this->userinfo;
	$this->db->Query("UPDATE `@#_member_dizhi` SET `default`='N' WHERE `uid`='$member[uid]' AND `default`='Y'");
	$this->db->Query("UPDATE `@#_member_dizhi` SET `default`='$def' WHERE `id`='$id'");
	if($this->db->affected_rows()){
		echo 'ok';
	}else{
		echo 'no';
	}
}


	/*

	public function password(){

		$mysql_model=System::load_sys_class('model');

		$member=$this->userinfo;

		$title="密码修改";

		include templates("member","password");

	}

	public function oldpassword(){

		$mysql_model=System::load_sys_class('model');

		$member=$this->userinfo;

		if($member['password']==md5($_POST['param'])){

			echo '{

					"info":"",

					"status":"y"

				}';

		}else{

			echo "原密码错误";

		}

	}

	public function userpassword(){

		$mysql_model=System::load_sys_class('model');

		$member=$this->userinfo;

		//$member=$mysql_model->GetOne("select * from `@#_member` where uid='".$member['uid']."'");

		$password=isset($_POST['password']) ? $_POST['password'] : "";

		$userpassword=isset($_POST['userpassword']) ? $_POST['userpassword'] : "";

		$userpassword2=isset($_POST['userpassword2']) ? $_POST['userpassword2'] : "";

		if($password==null or $userpassword==null or $userpassword2==null){

				echo "密码不能为空;";

				exit;

			}

		if($_POST['password']<6 and $_POST['password']<20){

			echo "密码小于6位数";

			exit;

		}

		if($_POST['userpassword']!=$_POST['userpassword2']){

			echo "新密码不一致";

			exit;

		}

		$password=md5($password);

		$userpassword=md5($userpassword);

		if($member['password']!=$password){

			echo _message("原密码错误",null,3);

		}else{

			$mysql_model->Query("UPDATE `@#_member` SET password='".$userpassword."' where uid='".$member['uid']."'");

			echo _message("密码修改成功",null,3);

		}

	} */



	//云购记录

	public function userbuylist(){

	   $webname=$this->_cfg['web_name'];

		$mysql_model=System::load_sys_class('model');

		$member=$this->userinfo;

		$uid = $member['uid'];

		$title="购买记录";

		//$record=$mysql_model->GetList("select * from `@#_member_go_record` where `uid`='$uid' ORDER BY `time` DESC");

		include templates("mobile/user","userbuylist");

	}



	//云购记录

	public function jf_userbuylist(){

	   $webname=$this->_cfg['web_name'];

		$mysql_model=System::load_sys_class('model');

		$member=$this->userinfo;

		$uid = $member['uid'];

		$title="购买记录";

		//$record=$mysql_model->GetList("select * from `@#_member_go_record` where `uid`='$uid' ORDER BY `time` DESC");

		include templates("mobile/user","jf_userbuylist");

	}

	//云购记录详细

	public function userbuydetail(){

	    $webname=$this->_cfg['web_name'];

		$mysql_model=System::load_sys_class('model');

		$member=$this->userinfo;

		$title="购买详情";

		$crodid=intval($this->segment(4));

		$record=$mysql_model->GetOne("select * from `@#_member_go_record` where `id`='$crodid' and `uid`='$member[uid]' LIMIT 1");

		if($crodid>0){

			include templates("member","userbuydetail");

		}else{

			echo _message("页面错误",WEB_PATH."/member/home/userbuylist",3);

		}

	}

	//获得的商品

	public function orderlist(){

	    $webname=$this->_cfg['web_name'];

		$member=$this->userinfo;

		$title="获得的商品";

		//$record=$this->db->GetList("select * from `@#_member_go_record` where `uid`='".$member['uid']."' and `huode`>'10000000' ORDER BY id DESC");

		include templates("mobile/user","orderlist");

	}

	//账户管理

	public function userbalance(){

	    $webname=$this->_cfg['web_name'];

		$member=$this->userinfo;

		$title="账户记录";

		$account=$this->db->GetList("select * from `@#_member_account` where `uid`='$member[uid]' and `pay` = '账户' ORDER BY time DESC");

         $czsum=0;

         $xfsum=0;

		if(!empty($account)){

			foreach($account as $key=>$val){

			  if($val['type']==1){

				$czsum+=$val['money'];

			  }else{

				$xfsum+=$val['money'];

			  }

			}

		}



		include templates("mobile/user","userbalance");

	}





	public function userrecharge(){

	    $webname=$this->_cfg['web_name'];

		$member=$this->userinfo;

		$title="账户充值";

		$paylist = $this->db->GetList("SELECT * FROM `@#_pay` where `pay_start` = '1' AND pay_mobile = 1");

		// 		print_r($paylist);

		include templates("mobile/user","recharge");

	}

	/*

	public function pay(){

		if(isset($_POST['submit'])){

			$mid = TENPAY_MID; //商户编号

			$key = TENPAY_KEY; //商户密钥

			$desc = '云购系统'; //商品名称

			$oid = date("YmdHis").rand(100,999); //商户订单号

			$pri = $_POST['money']*100; //总价(单位:分)

			$url = WEB_PATH.'/member/home/tenpaysuccess'; //回调地址

			header("location:".makeUrl($key,$desc,$mid,$oid,$pri,$url));

		}

	}

	public function tenpaysuccess(){

		$mysql_model=System::load_sys_class('model');

		$member=$this->userinfo;

		$cmd_no         = $_GET['cmdno'];

		$pay_result     = $_GET['pay_result'];

		$pay_info       = $_GET['pay_info'];

		$bill_date      = $_GET['date'];

		$bargainor_id   = $_GET['bargainor_id'];

		$transaction_id = $_GET['transaction_id'];

		$sp_billno      = $_GET['sp_billno'];

		$total_fee      = $_GET['total_fee']/100+$member['money'];

		$fee_type       = $_GET['fee_type'];

		$attach         = $_GET['attach'];

		$sign           = $_GET['sign'];

		if($pay_result<1){

			$mysql_model->Query("UPDATE `@#_member` SET money='".$total_fee."' where uid='".$member['uid']."'");

			_message("支付成功",WEB_PATH.'/member/home/userbalance',3);

		}

	}

	*/

	//晒单

	public function singlelist(){

		 $webname=$this->_cfg['web_name'];

		include templates("mobile/user","singlelist");

	}



	//添加晒单

	public function postsingle(){

		$member=$this->userinfo;

		$uid=_getcookie('uid');

		$ushell=_getcookie('ushell');

		$title="添加晒单";
		$recordid=intval($this->segment(4));
		
		$shaidan=$this->db->GetOne("select * from `@#_member_go_record` where `id`='$recordid' and `uid` = '$member[uid]'");
		$shopid = $shaidan['shopid'];
		if(!$shaidan){
			_messagemobile("该商品您不可晒单!");
		}
		$shaidanyn=$this->db->GetOne("select sd_id from `@#_shaidan` where `sd_shopid`='$shopid' and `sd_userid` = '$member[uid]'");

		if($shaidanyn){
			_messagemobile("不可重复晒单!");
		}
		$ginfo=$this->db->GetOne("select id,sid,qishu from `@#_shoplist` where `id`='$shaidan[shopid]' LIMIT 1");
		if(!$ginfo){
			_messagemobile("该商品已不存在!");
		}

		if(isset($_POST['submit'])){

			if($_POST['title']==null)_message("标题不能为空");	
			if($_POST['content']==null)_message("内容不能为空");	
			if(!isset($_POST['fileurl_tmp'])){
				_message("图片不能为空");
			}
			System::load_sys_class('upload','sys','no');
			$img=$_POST['fileurl_tmp'];
			$num=count($img);
			$pic="";
			for($i=0;$i<$num;$i++){
				$pic.=trim($img[$i]).";";
			}
			
			$src=trim($img[0]);
			
			if(!file_exists(G_UPLOAD.$src)){
					_message("晒单图片不正确");
			}
			$size=getimagesize(G_UPLOAD.$src);
			$width=220;
			$height=$size[1]*($width/$size[0]);			
		
			$src_houzhui = upload::thumbs($width,$height,false,G_UPLOAD.'/'.$src);			
			$thumbs=$src."_".intval($width).intval($height).".".$src_houzhui;			
			
			
			$sd_userid = $this->userinfo['uid'];
			$sd_shopid = $ginfo['id'];	
			$sd_shopsid = $ginfo['sid'];	
			$sd_qishu = $ginfo['qishu'];	
			$sd_title = _htmtocode($_POST['title']);
			$sd_thumbs = $thumbs;
			$sd_content = $_POST['content'];
			$sd_photolist= $pic;
			$sd_time=time();		
			$sd_ip = _get_ip_dizhi();			
			$this->db->Query("INSERT INTO `@#_shaidan`(`sd_userid`,`sd_shopid`,`sd_shopsid`,`sd_qishu`,`sd_ip`,`sd_title`,`sd_thumbs`,`sd_content`,`sd_photolist`,`sd_time`)VALUES
			('$sd_userid','$sd_shopid','$sd_shopsid','$sd_qishu','$sd_ip','$sd_title','$sd_thumbs','$sd_content','$sd_photolist','$sd_time')");

			_message("晒单分享成功",WEB_PATH."/mobile/home/singlelist");

		}

		

		if($recordid>0){

			

			include templates("mobile/user","postsingle");

		}else{

			_message("页面错误");

		}

	}
	/*

	//编辑

	public function PostSingleEdit(){

		_message("不可编辑!");

		if(isset($_POST['submit'])){

			System::load_sys_class('upload','sys','no');

			if($_POST['title']==null)_message("标题不能为空");

			if($_POST['content']==null)_message("内容不能为空");

			$sd_id=$_POST['sd_id'];

			$shaidan=$this->db->GetOne("select * from `@#_shaidan` where `sd_id`='$sd_id'");

			$pic=null;$thumbs=null;

			if(isset($_POST['fileurl_tmp'])){

				if($shaidan['sd_photolist']==null){

					$img=$_POST['fileurl_tmp'];

					$num=count($img);

					for($i=0;$i<$num;$i++){

						$pic.=trim($img[$i]).";";

					}

					$src=trim($img[0]);

					$size=getimagesize(G_UPLOAD_PATH."/".$src);

					$width=220;

					$height=$size[1]*($width/$size[0]);

					$thumbs=tubimg($src,$width,$height);

				}else{

					$img=$_POST['fileurl_tmp'];

					$num=count($img);

					for($i=0;$i<$num;$i++){

						$pic.=$img[$i].";";

					}

				}

			}

			if($thumbs!=null){

				$sd_thumbs=$thumbs;

			}else{

				$sd_thumbs=$shaidan['sd_thumbs'];

			}

			$uid=$this->userinfo;

			$sd_userid=$uid['uid'];

			$sd_shopid=$shaidan['sd_shopid'];

			$sd_title=$_POST['title'];

			$sd_content=$_POST['content'];

			$sd_photolist=$pic.$shaidan['sd_photolist'];

			$sd_time=time();

			$this->db->Query("UPDATE `@#_shaidan` SET

			`sd_userid`='$sd_userid',

			`sd_shopid`='$sd_shopid',

			`sd_title`='$sd_title',

			`sd_thumbs`='$sd_thumbs',

			`sd_content`='$sd_content',

			`sd_photolist`='$sd_photolist',

			`sd_time`='$sd_time' where sd_id='$sd_id'");

			_message("晒单修改成功",WEB_PATH."/member/home/singlelist");

		}

		$member=$this->userinfo;

		$title="修改晒单";

		$uid=_getcookie('uid');

		$ushell=_getcookie('ushell');

		$sd_id=intval($this->segment(4));

		if($sd_id>0){

			$shaidan=$this->db->GetOne("select * from `@#_shaidan` where `sd_id`='$sd_id'");

			include templates("member","singleupdate");

		}else{

			_message("页面错误");

		}

	}

	public function singoldimg(){

		if($_POST['action']=='del'){

			$sd_id=$_POST['sd_id'];

			$oldimg=$_POST['oldimg'];

			$shaidan=$this->db->GetOne("select * from `@#_shaidan` where `sd_id`='$sd_id'");

			$sd_photolist=str_replace($oldimg.";","",$shaidan['sd_photolist']);

			$this->db->Query("UPDATE `@#_shaidan` SET sd_photolist='".$sd_photolist."' where sd_id='".$sd_id."'");

		}

	}

	public function singphotoup(){

		 $mysql_model=System::load_sys_class('model');

		if(!empty($_FILES)){

			$uid=isset($_POST['uid']) ? $_POST['uid'] : NULL;

			$ushell=isset($_POST['ushell']) ? $_POST['ushell'] : NULL;

			$login=$this->checkuser($uid,$ushell);

			if(!$login){_message("上传出错");}

			System::load_sys_class('upload','sys','no');

			upload::upload_config(array('png','jpg','jpeg','gif'),1000000,'shaidan');

			upload::go_upload($_FILES['Filedata']);

			if(!upload::$ok){

				echo _message(upload::$error,null,3);

			}else{

				$img=upload::$filedir."/".upload::$filename;

				$size=getimagesize(G_UPLOAD_PATH."/shaidan/".$img);

				$max=700;$w=$size[0];$h=$size[1];

				if($w>700){

					$w2=$max;

					$h2=$h*($max/$w);

					upload::thumbs($w2,$h2,1);

				}



				echo trim("shaidan/".$img);

			}

		}

	}

	public function singdel(){

		$action=isset($_GET['action']) ? $_GET['action'] : null;

		$filename=isset($_GET['filename']) ? $_GET['filename'] : null;

		if($action=='del' && !empty($filename)){

			$filename=G_UPLOAD_PATH.'shaidan/'.$filename;

			$size=getimagesize($filename);

			$filetype=explode('/',$size['mime']);

			if($filetype[0]!='image'){

				return false;

				exit;

			}

			unlink($filename);

			exit;

		}

	}

	//晒单删除

	public function shaidandel(){

		_message("不可以删除!");

		$member=$this->userinfo;

		//$id=isset($_GET['id']) ? $_GET['id'] : "";

		$id=$this->segment(4);

		$id=intval($id);

		$shaidan=$this->db->Getone("select * from `@#_shaidan` where `sd_userid`='$member[uid]' and `sd_id`='$id'");

		if($shaidan){

			$this->db->Query("DELETE FROM `@#_shaidan` WHERE `sd_userid`='$member[uid]' and `sd_id`='$id'");

			_message("删除成功",WEB_PATH."/member/home/singlelist");

		}else{

			_message("删除失败",WEB_PATH."/member/home/singlelist");

		}

	}









	*/



}



?>