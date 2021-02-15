<?php
include_once '../../app/logic/conn.php';
$cita = $_GET['c'];
$usuario = $_GET['u'];
$paciente = $_GET['p'];
$sql_medicamentos = "SELECT * FROM med_homeopaticos";
$res = $mysqli->query($sql_medicamentos);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../static/css/main.css">
    <title>Frascos Extra Med Hom</title>
    <style>
        body{
            font-family: 'Roboto', sans-serif;
        }
        input[type=checkbox] {
        transform: scale(1.5);
        }

        
        .btn{
            color: #FFF; 
            background: #2d83a0;
            margin-left: 3em; 
            border: 2px solid #2d83a0;
            border-radius: 3px;
            padding: 5px;
        }
        .btn:hover{
            background-color: #008CBA;
        }

        .bt2{
            color: #FFF; 
            background: #006064;
            margin-left: 2em; 
            border: 2px solid #006064;
            border-radius: 3px;
            padding: 5px;
        }
        .bt2:hover{
            background-color: #008CBA;
        }
        
        .et{
            border: 1px solid #757575;
            border-radius: 4px;
        }

        .autocomplete {
  position: relative;
  display: inline-block;

}
 .autocomplete-items{
  position: absolute;
  border: 1px solid #757575;
  border-radius: 4px;
  border-bottom: none;
  border-top: none;
  z-index: 99;
  /*position the autocomplete items to be the same width as the container:*/
  
  left: auto;
  right: auto;
}

.autocomplete-items div {
  
  cursor: pointer;
  background-color: #fff; 
  border-bottom: 1px solid #d4d4d4;
  max-width: 150px;
}


/*when hovering an item:*/
.autocomplete-items div:hover {
  background-color: #e9e9e9; 
}

/*when navigating through the items using the arrow keys:*/
.autocomplete-active {
  background-color: DodgerBlue !important; 
  color: #ffffff; 
}
    </style>
</head>
<body>
    <div style="width: 100%;">
    <form action="save_med_hom_ex.php" method="POST" style="display: inline-block;">
        <h2 style="margin-bottom: 5%;">Medicamentos Homeopáticos (Frascos Extra)</h2>
        <table>
            <tbody>
                <tr class="autocomplete" style="margin-top: -2em;">
                    <td><input type="checkbox" name="frasco1[]"></td>
                    <td style="width: 40px;"><h1>1EX</h1></td>
                    <td><input type="text" id="f1-in1" name="frasco1[]" placeholder="--" style="margin-left: 0.5em;" class="et" autocomplete="off"></td>
                    <td><input type="text" id="f1-in2" name="frasco1[]" placeholder="--" style="margin-left: 1em;" class="et" autocomplete="off"></td>
                    <td><input type="text" id="f1-in3" name="frasco1[]" placeholder="--" style="margin-left: 1em;" class="et" autocomplete="off"></td>
                    <td><input type="text" id="f1-in4" name="frasco1[]" placeholder="--" style="margin-left: 1em;" class="et" autocomplete="off"></td>
                    <td><input type="text" id="f1-in5" name="frasco1[]" placeholder="--" style="margin-left: 1em;" class="et" autocomplete="off"></td>
                </tr>
                <tr class="autocomplete" style="margin-top: -2.5em;">
                    <td><input type="checkbox" name="frasco2[]"></td>
                    <td style="width: 40px;"><h1>2EX</h1></td>
                    <td><input type="text" id="f2-in1" name="frasco2[]" placeholder="--" style="margin-left: 0.5em;" class="et" autocomplete="off"></td>
                    <td><input type="text" id="f2-in2" name="frasco2[]" placeholder="--" style="margin-left: 1em;" class="et" autocomplete="off"></td>
                    <td><input type="text" id="f2-in3" name="frasco2[]" placeholder="--" style="margin-left: 1em;" class="et" autocomplete="off"></td>
                    <td><input type="text" id="f2-in4" name="frasco2[]" placeholder="--" style="margin-left: 1em;" class="et" autocomplete="off"></td>
                    <td><input type="text" id="f2-in5" name="frasco2[]" placeholder="--" style="margin-left: 1em;" class="et" autocomplete="off"></td>
                </tr>
                <tr class="autocomplete" style="margin-top: -2.5em;">
                    <td><input type="checkbox" name="frasco3[]"></td>
                    <td style="width: 40px;"><h1>3EX</h1></td>
                    <td><input type="text" id="f3-in1" name="frasco3[]" placeholder="--" style="margin-left: 0.5em;" class="et" autocomplete="off"></td>
                    <td><input type="text" id="f3-in2" name="frasco3[]" placeholder="--" style="margin-left: 1em;" class="et" autocomplete="off"></td>
                    <td><input type="text" id="f3-in3" name="frasco3[]" placeholder="--" style="margin-left: 1em;" class="et" autocomplete="off"></td>
                    <td><input type="text" id="f3-in4" name="frasco3[]" placeholder="--" style="margin-left: 1em;" class="et" autocomplete="off"></td>
                    <td><input type="text" id="f3-in5" name="frasco3[]" placeholder="--" style="margin-left: 1em;" class="et" autocomplete="off"></td>
                </tr>
                
               
            </tbody>
        </table>
        <input type="hidden" name="c" value="<?php echo $cita ?>">
        <input type="hidden" name="u" value="<?php echo $usuario ?>">
        <input type="hidden" name="tipo" value="ext">
       
       
          
        <input style="margin-left: 30%;" type="submit" class="btn" value="Guardar Frascos Extra">
       
        <a href="save_med_hom.php"><button class="bt2">Ver medicamentos capturados</button></a>
        </form>
        
    </div>


<!-- ***************** INICIA SCRIPT DE AUTOCOMPLETADO ***************************************-->

<script>
function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
          b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}

/*An array containing all the country names in the world:*/

var med_home = [
   <?php 
      while($med = mysqli_fetch_assoc($res)){
         echo '"'.$med['descrip_med_hom'].'",';
      }
      ?>
];

/*initiate the autocomplete function on the "myInput" element, and pass along the med_home array as possible autocomplete values:*/
autocomplete(document.getElementById("f1-in1"), med_home);
autocomplete(document.getElementById("f1-in2"), med_home);
autocomplete(document.getElementById("f1-in3"), med_home);
autocomplete(document.getElementById("f1-in4"), med_home);
autocomplete(document.getElementById("f1-in5"), med_home);

autocomplete(document.getElementById("f2-in1"), med_home);
autocomplete(document.getElementById("f2-in2"), med_home);
autocomplete(document.getElementById("f2-in3"), med_home);
autocomplete(document.getElementById("f2-in4"), med_home);
autocomplete(document.getElementById("f2-in5"), med_home);

autocomplete(document.getElementById("f3-in1"), med_home);
autocomplete(document.getElementById("f3-in2"), med_home);
autocomplete(document.getElementById("f3-in3"), med_home);
autocomplete(document.getElementById("f3-in4"), med_home);
autocomplete(document.getElementById("f3-in5"), med_home);

</script>
</body>
</html>