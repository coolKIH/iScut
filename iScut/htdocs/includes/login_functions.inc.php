<?php

function absolute_url($page='index.php')
{
	$url= 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);

	$url=rtrim($url,'/\\');
	$url .= '/' . $page;

	return $url;
}

function check_login($dbc,$type,$id='',$pass='')
{
	if(!empty($id) && !empty($pass) &&!empty($type) )
	{
		$i=trim($id);$p=trim($pass);
		$q="";
		if($type=='s')
		$q="select s_id,pass from student where s_id='$i' and pass=SHA1('$p')";
		else if($type=='t')
			$q="select t_id,pass from teacher where t_id='$i' and pass=SHA1('$p'    )";
		else if($type=='m')
			 $q="select m_id,pass from manager where m_id='$i' and
				 pass=SHA1('$p')";
		$r=mysqli_query($dbc,$q);
		if(mysqli_num_rows($r)==1) return true;
		else return false;
	}
	return false;
}

?>
