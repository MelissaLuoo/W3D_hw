<!DOCTYPE html>
<html>

<?php
session_start();

function NumberGen() {
    $PuzzleLength = 4;
    // 計算要猜的數字，此處用亂數產生，同學需要使用演算法來算    
    $arrNumber = array();
    $arrNumber[0] = rand(0,9);
    
	$nums_array = array( "0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
	shuffle($nums_array);
	$string = '';		
	for ($i = 0; $i < $PuzzleLength ; $i++) {
		 $string .= $nums_array[$i];
		 $MyNumber .= $nums_array[$i];
	}

    //$MyNumber = implode('', $arrNumber);
    return $string;
}
$showans = 0;
if (isset($_POST['showA'])) $showans = $_POST['showA'];
$mes = 2;
if (isset($_POST['Mess'])) $mes = $_POST['Mess'];
$ThisGuess = '0000';
if (isset($_POST['ThisGuess'])) $ThisGuess = $_POST['ThisGuess'];
$arrHistory = array();
if (isset($_SESSION['History'])) $arrHistory = $_SESSION['History'];
$ansH = array();
if (isset($_SESSION['ansHistory'])) $ansH = $_SESSION['ansHistory'];

if (isset($_SESSION['MyNumber'])) $MyNumber = $_SESSION['MyNumber'];

if(isset($_POST['reset'])){
	$ThisGuess = '0000';
	$showans=0;		
}
if(isset($_POST['showA'])){
	if($showans==0)$showans=1;
	else $showans=0;		
}

if ($ThisGuess == '0000') {
    $MyNumber = NumberGen();	//make new ans
    $arrHistory = array();
	$ansH = array();	//ans history
}

if ($ThisGuess<>'0000') {
	$arrHistory[] = $ThisGuess;	//<> Not equal
	// 判斷?A?B
	$Length = 4;
	$strans = '';
	$arr1 = str_split($MyNumber,1);		//1=ans
	$arr2 = str_split($ThisGuess,1);	//2=this
	$cntA =0;
	$cntB =0;
	
	for ($i = 0; $i < $Length ; $i++) {
		//echo "$arr1[$i]".$arr1[$i]."$arr2[$i]".$arr2[$i]."<br>";

		if($arr1[$i] == $arr2[$i]) $cntA++;

		for ($j = 0; $j < $Length ; $j++){
			if($arr1[$i] == $arr2[$j]) $cntB++;
		}
	}
	$cntB -= $cntA;
	if($cntA==4) $strans='4A4B';
	else $strans = $cntA.'A'.$cntB.'B';

	if (isset($_POST['ThisGuess'])){		
		$ansH[] = $strans;

		if($strans == '4A4B'){
			$mes=1;
		}
		else if($ThisGuess != $MyNumber){
			$mes=0;
		}		
	}
}
$_SESSION['showA'] = $showans;
$_SESSION['Mess'] = $mes;
$_SESSION['MyNumber'] = $MyNumber;
$_SESSION['ansHistory'] = $ansH;
$_SESSION['History'] = $arrHistory;

?>


<head>
<title>Guess-Number</title>
<style type="text/css">
	.row {
	  	width: 400px;
		background-color: #D3D3D3;
	  	margin: 0 auto;
	  	&::after {
			content: '';
			display: table;
			clear: both;
	  	}
	}

	.row__container {
		width: 50%;
	  	float: left;
	}

	#Sidebar{
	  	width: 90%;
	 	margin: 0 auto;
		font-size:20px;
		border:2px #8A9A5B solid;
		background-color: #818589;
	}
</style>
</head>
<body style="text-align:center;font-size:25px;" bgcolor="#808080" text="#00008B">
<div>
	<a href="/index.html"><font color="#DAF7A6"><b>HOME-Index</b></font></a>
	<br><a href="testsend.php"><font color="#DAF7A6">Test-send</font></a>
	<br>

	<form method="POST" action="">
		Please enter your guess: 
		<input type="text" name="ThisGuess" size="4">&nbsp;&nbsp;
		<input type="submit" name="Guess" value="SEND">
		<br>
		<br>
		<input type="submit" name="reset" value="_RESET_">
		<input type="submit" name="showA" value="_showans_">
	</form>
	<span style="color:#DAF7A6"> <?php	
		if($showans==1)echo "ans = ",$MyNumber;
		if($mes == 0) echo "<br>keep trying<br>";
		else if($mes == 1) echo "<br>YOU WIN<br>";
		else echo '<br>';
		echo '<br>';
	?></span>
	
</div>
<span style="color:#00008B">
<div class="row">
  <div class="row__container">
    <div id="Sidebar">
		<?php	echo '<pre>' . var_export($arrHistory, true) . '</pre>'; ?>
	</div>
  </div>
  <div class="row__container">
    	<div id="Sidebar">
		<?php	echo '<pre>' . var_export($ansH, true) . '</pre>'; ?>
	</div>
  </div>
</div>
</span>
<div style="clear:both;"></div>
<span style="font-size:12px">
	<?php 	
		echo var_dump($arrHistory),'<br>';
		echo var_dump($ansH),'<br>'; 
	?>
	</span>
</body>
</html>
