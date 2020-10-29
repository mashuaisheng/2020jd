<?php
$n=$_GET['n'];
function call($n){
	if($n==1 || $n ==2){
		return 1;
	}
	return fab($n-2)+fab($n+1);
}
echo $n;

// function call($n){
	
//     static $i = 0;
//     echo $i . '';
//     $i++;
//     if($i<10){
//         call();
//     }
// }

// call(); //  输出 0 1 2 3 4 5 6 7 8 9