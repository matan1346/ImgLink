<?php
header('Content-Type: text/html; charset=utf-8');
$toOutPut = '';
$Result = '';

function EscapeStrings($str)
{
	$size = mb_strlen($str);
	
	for($i = $size;$i >= 0;$i--)
	{
		if($i*2 == 0)
			$n = 1;
		else
			$n = $i*2;
		$str[$n] = $str[$i];
		$str[$n-1] = '\\';
	}
	/*
	for($i = 0;$i < $size;$i++)
	{
		$str[$i] = '\\'.$str[$i];
	}*/
	
	return substr($str, 0, strlen($str)-2);
}
//[IMGLINK=http://www.yashir4u.co.il/pictures/z_VU3153831.jpg] [PO=31|32|http://gogle.com]Hi You, This Is My String.[/PO] [/IMGLINK] 

function CreateImgWithLinks($matches)
{
    echo '<pre>'.print_r($matches, true).'</pre>';//print_r($matches);
    
    if(preg_match_all('#\[PO=(.+)\](.+)\[\/PO\]#imU', $matches[0], $sub_matches))
    {
        $Text = '';
        foreach($sub_matches[1] as $k => $sub)
        {
            $data = explode('|', $sub);
            $Text .= '<div class="ImgTextAttached" style="margin-left: '.$data[0].'px;margin-top: '.$data[1].'px;">
                <a href="'.((is_string($data[2]) && mb_strlen($data[3]) > 0) ? $data[3] : '#').'" target="_blank" style="color: '.$data[2].';">'.$sub_matches[2][$k].'</a>
                </div>';
        }
        
        
        $matches = '<div class="ImgLinked" style="background: url('.$matches[1].') no-repeat;">'.$Text.'</div>';
    }//echo '<pre>'.print_r($sub_matches, true).'</pre>';
    
    
    
    return $matches;
}

function getImgLink($text)
{
    //echo preg_replace_callback('#\[IMGLINK=(.+)\]\s*\[PO=(.+)\](.+)\[\/PO\]\s*\[\/IMGLINK\]#imU', 'handler', $text);
        //echo '<pre>'.print_r($matches, true).'</pre>';
        
    return preg_replace_callback('#\[IMGLINK=(.+)\].+\[\/IMGLINK\]#imU', 'CreateImgWithLinks', $text);
    //else echo 'not ok';
}


if(isset($_POST['Sub_Text']))
{
	$toOutPut .= $_POST['TEXT'];
	$newStr = $_POST['TEXT'];//EscapeStrings($_POST['TEXT']);
	$toOutPut .= '<br />'.$newStr;
	/*if(preg_match('#\[SRC=.+\].+\[\/SRC\]#', $newStr, $MyText))
		echo '<br />OK';
  */
  $Result = getImgLink($newStr);
}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title> IMG WITH LINKS </title>
		
		<meta name="description" content="Free Links In One Image" />
		<meta name="keywords" content="Images, Pictures, Links" />
		<meta name="author" content="Matan" />
		<meta charset="UTF-8" />
        <link rel="stylesheet" href="style.css"/>
	</head>
	<body>
		
		<form action="?do=image" method="POST">
		Your Code, Example: <br />
		[IMGLINK=http://camosun.ca/template/images/logos/camosun-logo-print.png]
			[PO=31|32|FFFFFF|http://gogle.com]Hi You, This Is My String.[/PO]
		[/IMGLINK]
		<br />
		<textarea rows="7" cols="50" name="TEXT"></textarea>
		<br /><input type="submit" name="Sub_Text" value="Send Data" />
		</form>
		<div style="text-align: center">
		<?=$toOutPut?>
		</div>
        Result:
        <div class="ResultHolding">
        <?=$Result?>
        </div>

	</body>
</html>