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
    $result = '';
    $correct = false;

    if(isset($_GET['result']))
    {
        if(!strlen($_GET['result']) or (strlen($_GET['result']) > 50))
            $correct = false;
        else
        {
            for($i = 0; $i < strlen($_GET['result']); $i++)
            {
                if($_GET['result'][$i] == '+' or $_GET['result'][$i] == '-' or $_GET['result'][$i] == '*' or $_GET['result'][$i] == '/')
                {
                    $correct = true;
                }
            }
        }
        for($i = 0; $i < strlen($_GET['result']); $i++)//判斷特殊字元&多餘運算子
        {
            $x = $_GET['result'][$i];
            if($x == '!' or $x == '@' or $x == '#' or $x == '$' or $x == '%' or $x == '^' or $x == '&'
               or $x == '"' or $x == '[' or $x == ']' or $x == ';' or $x == ',' or $x == '_' or $x == '~')
            {
                $correct = false;
                break;
            }
            if($x == '+' or $x == '-' or $x == '*' or $x == '/' or $x == '.')
            {
                $y = $_GET['result'][$i+1];
                if($y == '+' or $y == '-' or $y == '*' or $y == '/' or $y == '.')
                {
                    $correct = false;
                    break;
                }
            }
        }
        $found_dot = false;
        for($i = 0; $i < strlen($_GET['result']); $i++)//判斷多餘小數點
        {
            $x = $_GET['result'][$i];
            if($x == '.')
            {
                if($found_dot)
                {
                    $correct = false;
                    break;
                }
                else
                    $found_dot = true;
            }
            if($x == '+' or $x == '-' or $x == '*' or $x == '/')
            {
                if($found_dot)
                    $found_dot = false;
            }
        }
        if(preg_match("/([\x81-\xfe][\x40-\xfe])/",$_GET['result'], $match) or preg_match("/([A-Za-z])/", $_GET['result'], $match))//判斷是否有中文/英文
            $correct = false; 
        if($correct)
            eval('$result = '.$_GET['result'].';');
    }
?>
    
    <div id="app">
        <h1 class="title">Homework 03</h1>
        <form action="HW03.php" method="GET">
        <table align="center"><tr><td><input type="text" name="result" id="result" class="result_box" value="<?php echo $result?>"></td></tr></table>
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
                <td><input type="button" value="-" class="button" id="sub"></td>
            </tr>
            <tr class="box">
                <td><input type="button" value="1" class="button" id="n1"></td>
                <td><input type="button" value="2" class="button" id="n2"></td>
                <td><input type="button" value="3" class="button" id="n3"></td>
                <td><input type="button" value="×" class="button" id="mul"></td>
            </tr>
            <tr class="box">
                <td><input type="button" value="C" class="button" id="clear"></td>
                <td><input type="button" value="0" class="button" id="n0"></td>
                <td><input type="button" value="." class="button" id="dot"></td>
                <td><input type="button" value="÷" class="button" id="div"></td>
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
	document.getElementById("sub").onclick = function(){result.value += "-";};
	document.getElementById("mul").onclick = function(){result.value += "*";};
	document.getElementById("div").onclick = function(){result.value += "/";};
	document.getElementById("dot").onclick = function(){result.value += ".";};
	document.getElementById("clear").onclick = function(){
        result.value = "";
    };
	document.getElementById("equal").onclick = function(){
		result.form.submit();
	};
</script>
</html>