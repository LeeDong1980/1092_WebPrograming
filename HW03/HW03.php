<html>
<head>
    <style type="text/css">

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    img{
        display: block;
    }

    html,
    body{
        width: 100%;
        height: 100%;
    }
    .title{
        padding: 10px 0 10px 0;
        text-align: center;
        background-color: #485696;
        color: #E7E7E7;
    }
    .board{
        display: block;
        margin: 0 auto;
    }
    .box{
        background-color:#CCDDFF;
    }
    .button{
        width: 70px;height: 70px;font-size: 28px;
    }
    .box2{
        width: 290px;height: 70px;font-size: 28px;
    }
    .result_box{
        width: 290px; height: 50px;font-size: 30px;text-align: center;
    }
    </style>
</head>

<body>
 
<?php
    $result = "";
    $isCorrect = false;
    if(isset($_GET["result"])){
        if(!strlen($_GET["result"]) or strlen($_GET["result"]) > 10){
            $isCorrect = false;
        }
        for($i = 0; $i < strlen($_GET["result"]); $i++){
            $x = $_GET["result"][$i];
            if(preg_match('/^[0-9]*$/', $x) or $x == "+" or $x == "-" or $x == "*" or $x == "/" or $x == "."){ //檢查數字，檢查+-*/.
                    $isCorrect = true;
            }else{
                $isCorrect = false;
                break;
            }
        }
        if($isCorrect){
            eval('$result = '.$_GET['result'].';');
        }
    }
?>
    
    <div id="app">
        <h1 class="title">Homework 03</h1>
        <div class="board">
            <form class="board-form" action="HW03.php" method="get">
            <table align="center">
                <tr>
                    <td>
                        <input type="text" name="result" id="result" class="result_box" value="<?php echo $result?>">
                    </td>
                </tr>
            </table>
            <table align="center">
                <tr class="box">
                    <td><input type="button" value="7" class="button" id="n7"></td>
                    <td><input type="button" value="8" class="button" id="n8"></td>
                    <td><input type="button" value="9" class="button" id="n9"></td>
                    <td><input type="button" value="+" class="button" id="add"></td>
                </tr>
                <tr class="box">
                    <td><input type="button" value="4" class="button" id="n4"></td>
                    <td><input type="button" value="5" class="button" id="n5"></td>
                    <td><input type="button" value="6" class="button" id="n6"></td>
                    <td><input type="button" value="-" class="button" id="subtract"></td>
                </tr>
                <tr class="box">
                    <td><input type="button" value="1" class="button" id="n1"></td>
                    <td><input type="button" value="2" class="button" id="n2"></td>
                    <td><input type="button" value="3" class="button" id="n3"></td>
                    <td><input type="button" value="×" class="button" id="multiply"></td>
                </tr>
                <tr class="box">
                    <td><input type="button" value="C" class="button" id="clear"></td>
                    <td><input type="button" value="0" class="button" id="n0"></td>
                    <td><input type="button" value="." class="button" id="dot"></td>
                    <td><input type="button" value="÷" class="button" id="divide"></td>
                </tr>
            </table>
            <table align="center">
                <tr>
                    <td>
                        <input type="button" value="=" class="box2" id="equal">
                    </td>
                </tr>
            </table>
            </form>        
        </div>
    </div>
</body>
<script>
	result = document.getElementById("result");
	document.getElementById("n0").onclick = function(){result.value += "0";};
	document.getElementById("n1").onclick = function(){result.value += "1";};
	document.getElementById("n2").onclick = function(){result.value += "2";};
	document.getElementById("n3").onclick = function(){result.value += "3";};
	document.getElementById("n4").onclick = function(){result.value += "4";};
	document.getElementById("n5").onclick = function(){result.value += "5";};
	document.getElementById("n6").onclick = function(){result.value += "6";};
	document.getElementById("n7").onclick = function(){result.value += "7";};
	document.getElementById("n8").onclick = function(){result.value += "8";};
	document.getElementById("n9").onclick = function(){result.value += "9";};
	document.getElementById("add").onclick = function(){result.value += "+";};
	document.getElementById("subtract").onclick = function(){result.value += "-";};
	document.getElementById("multiply").onclick = function(){result.value += "*";};
	document.getElementById("divide").onclick = function(){result.value += "/";};
	document.getElementById("dot").onclick = function(){result.value += ".";};
	document.getElementById("clear").onclick = function(){
        result.value = "";
    };
	document.getElementById("equal").onclick = function(){
		result.form.submit();
	};
</script>
</html>