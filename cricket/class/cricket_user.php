<?php
define('TEAM_COST','25000000');
include_once('db.php');
include_once('team_owner.php');
include_once ('functions.php');
class User
{
	public function __construct()
	{
		$db=new DB();
	}
	public function getPlayer()
	{
		$sql = mysql_query("SELECT * FROM ".REGISTER." where player=1 order by firstname,lastname");
		$i=1;
		while($row=mysql_fetch_assoc($sql))
		{
			$players .= $row['uid'].':'.$row['firstname'].' '.$row['lastname'];
			if(mysql_num_rows($sql)!=$i)
			{
				$players .=';';
			}
			$i++;
		}
		return $players;
	}
	public function getDetails($page,$limit,$sidx,$sord,$type,$wh="")
	{
		$function=new Functions();
		$team=new Team();
		$teamScore=$team->getTeamScore();
		$page=$function->dbCheckValues($page);
		$limit=$function->dbCheckValues($limit);
		$sidx=$function->dbCheckValues($sidx);
		$sord=$function->dbCheckValues($sord);
		$type=$function->dbCheckValues($type);
		$wh=$function->dbCheckValues($wh);
		$result = mysql_query("SELECT COUNT(*) AS count FROM ".REGISTER." where player='$type'");
		$row = mysql_fetch_array($result,MYSQL_ASSOC);
		$count = $row['count'];
		if( $count >0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
        if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit; // do not put $limit*($page - 1)
		if ($start<0) $start = 0;
        $SQL = "SELECT uid, mindtreeid, email, firstname, lastname, sexselect, choice, rating, description, base_price, sold_price, team_name FROM ".REGISTER." a,".TEAM_NAME." b WHERE b.team_id=a.team AND player='$type' ".$wh." ORDER BY $sidx $sord LIMIT $start , $limit";
		$result = mysql_query( $SQL ) or die("Couldn’t execute query.".mysql_error());
		$responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
		$i=0; $amttot=0; $taxtot=0; $total=0;
		while($row = mysql_fetch_array($result,MYSQL_ASSOC)) 
		{
			if($row['sexselect']==1)
			{
				$sexSelect='Male';
			}
			else
			{
				$sexSelect='Female';
			}
			if($row['choice']==1)
			{
				$choice='Batting';
			}
			else if($row['choice']==2)
			{
				$choice='Bowling';
			}
			else if($row['choice']==3)
			{
				$choice='All Rounder';
			}
			$total=$row[base_price];
			$amttot += $total;
			$total_sold=$row[sold_price];
			$amttot_sold += $total_sold;
			$percentage_increase=0;
			if($row['base_price'])
			{
				$percentage_increase=(($row['sold_price']-$row['base_price'])/$row['base_price'])*100;
				$percentage_increase=number_format($percentage_increase, 2);
				if($percentage_increase<0) $percentage_increase=number_format(0,2);
			}
			$responce->rows[$i]['uid']=$row['uid'];
            $responce->rows[$i]['cell']=array($row['uid'],$row['mindtreeid'],$row['email'],$row['firstname'],$row['lastname'],$sexSelect,$choice,$row['rating'],$row['description'],$row['base_price'],$row['sold_price'],$row['team_name'],$percentage_increase);
            $i++;
		}
		$cost1=TEAM_COST-$teamScore[1]['sum'];
		$cost2=TEAM_COST-$teamScore[2]['sum'];
		$cost3=TEAM_COST-$teamScore[3]['sum'];
		$cost4=TEAM_COST-$teamScore[4]['sum'];
		$responce->userdata['mindtreeid'] = "A - ".(string)$cost1;
		$responce->userdata['firstname'] = 'B - '.(string)$cost2;
		$responce->userdata['lastname'] = 'C - '.(string)$cost3;
		$responce->userdata['choice'] = 'D - '.(string)$cost4;
		$responce->userdata['base_price'] = $amttot;
		$responce->userdata['sold_price'] = $amttot_sold;
		$responce->userdata['description'] = 'Total:';
		return $responce;
	}
	public function addDetails($mindtreeid,$firstname,$lastname,$sexselect,$choice,$rating,$player,$description,$email,$base_price)
	{
		$function=new Functions();
		$mindtreeid=$function->dbCheckValues($mindtreeid);
		$firstname=$function->dbCheckValues($firstname);
		$lastname=$function->dbCheckValues($lastname);
		$sexselect=$function->dbCheckValues($sexselect);
		$choice=$function->dbCheckValues($choice);
		$rating=$function->dbCheckValues($rating);
		$player=$function->dbCheckValues($player);
		$description=$function->dbCheckValues($description);
		$email=$function->dbCheckValues($email);
		$base_price=$function->dbCheckValues($base_price);
		$userip = $function->ip_address_to_number($_SERVER['REMOTE_ADDR']);
		$result=mysql_query("INSERT INTO ".REGISTER."(mindtreeid,firstname,lastname,sexselect,choice,rating,player,userip,registerDate,description,email,base_price) VALUES('$mindtreeid','$firstname','$lastname','$sexselect','$choice','$rating','$player','$userip',now(),'$description','$email','$base_price')");
		if($result)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	public function editDetails($uid,$base_price,$sold_price,$rating,$team)
	{
		$function=new Functions();
		$uid=$function->dbCheckValues($uid);
		$base_price=$function->dbCheckValues($base_price);
		$sold_price=$function->dbCheckValues($sold_price);
		$rating=$function->dbCheckValues($rating);
		$team=$function->dbCheckValues($team);
		if($sold_price<$base_price)
			return FALSE;
		mysql_query("UPDATE ".REGISTER." SET base_price='$base_price',sold_price='$sold_price',rating='$rating',team='$team' WHERE uid='$uid'");
		if(mysql_affected_rows()>=1)
		{
			mysql_query("COMMIT");
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	/*
	public function deleteDetails($id)
	{
		$user=new User();
		$userid=$user->getCurrenUserId();
		$function=new Functions();
		$id=$function->dbCheckValues($id);
		mysql_query("DELETE FROM ".ORDERS." WHERE userid='$userid' AND id='$id'");
		if(mysql_affected_rows()>=1)
		{
			mysql_query("COMMIT");
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	*/
}
?>