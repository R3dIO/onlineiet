<?php 

session_start();

if(!isset($_POST["date1"]))

  header('Location: index.php');

require_once 'conn_iet.php';

//$SubjectId = $_POST['classdetail']; #selectoption will contain class code from previous page

$FacultyId = $_SESSION["userid"];

$batch=$_SESSION["batch"];

$schedule=$_SESSION['schedule'];

$lecture=$_POST['date1'];

//echo $schedule;

$_SESSION['lecture']=$lecture;

$result=mysqli_query($conn,"select $lecture from schedule_table where id=$schedule");

if($result->num_rows >0)

{   while($row =$result->fetch_assoc()  )

  {

      $d1=$row[$lecture];

  }

}

//$result1=mysqli_query($conn,"select id from schedule_table where subject_id=$SubjectId and class_id= (select class_id from faculty_subject_table where subject_id=$SubjectId and faculty_id=$FacultyId);");

//$_SESSION['class_name'] = $result1; #table code is stored so it is used in save attendance


if ($batch==0)
$result=mysqli_query($conn,"select * from attendance_table join student_table on student_table.id=attendance_table.student_id where schedule_id =$schedule");
else
$result=mysqli_query($conn,"select * from attendance_table join student_table on student_table.id=attendance_table.student_id where schedule_id =$schedule and student_table.batch=$batch"); # it fetches all the roll numbers of that particular class

$list="";

$i=0;


if($result->num_rows >0)

{   while($row =$result->fetch_assoc()  )

  {

     if($row["$lecture"]==1)

      { $list.='<td data-title="'.$row["name"].'"style="width:10%"> <span class="button-checkbox">

<button type="button" class="btn btn-success" data-color="success">'.$row["roll_no"].'</button>

        <input type="checkbox" class="hidden-sm-up" name="present[]" id="present" value="'.$row["roll_no"].'" checked />

    </span></td>';

          $i++;

                     if($i==6){

                         $list='<tr>'.$list.'</tr>';

                         $list1.=$list;

                         $list="";

                         $i=0;

                     }    

      }
      




    elseif($row["$lecture"]==0)

      { $list.='<td data-title="'.$row["name"].'"style="width:10%"> <span class="button-checkbox">

<button type="button" class="btn btn-danger" data-color="success">'.$row["roll_no"].'</button>

        <input type="checkbox" class="hidden-sm-up" name="present[]" id="present" value="'.$row["roll_no"].'" />

    </span></td>';

           $i++;

                     if($i==6){

                         $list='<tr>'.$list.'</tr>';

                         $list1.=$list;

                         $list="";

                         $i=0;

                     }    

      }

    

  }
if($i>0) {
          $list='<tr>'.$list.'</tr>';

                         $list1.=$list;

        }

} else {

    //echo "0 results";

}



?>
<!-- php ends here -->

<script>$(function(){

  // # Add a new row after the first one in the table

  $('table#submenu tr:first').after('<tr></tr>');



  // # Move the four last TDs to this new row

  $('table#submenu tr:first td.submenu:gt(9)') // Select the four last TDs

   .detach() // Detach them from their current row

   .appendTo('table#submenu tr:nth-child(2)'); // Add them at the end of the new row

});</script>

<script language="JavaScript">

//function to check & uncheck all the elements

    function toggle(source) {
    
          checkboxes = document.getElementsByName('present[]');
        
          check1=document.getElementsByClassName('btn');
          
        
          for(var i=0, n=checkboxes.length;i<n;i++) {
        
                  checkboxes[i].checked = source.checked;
        
                                                    }
                                                    
        
        if(document.getElementById("check").innerHTML == "Uncheck All")
        
                {document.getElementById("check").innerHTML = "Check All";
                
        
                var x=document.getElementsByName('chk');
                    for (i = 0; i < x.length;i++)
                            x[i].setAttribute("class", 'far fa-circle');
                
                
                    for(var i=0,n=checkboxes.length;i<n;i++)
                
                                check1[i].className = 'btn btn-danger active';
                
                
                
                }
                
        
        
        else
        
                {document.getElementById("check").innerHTML = "Uncheck All";
                
    
                var x=document.getElementsByName('chk');
                     for (i = 0; i < x.length; i++)
                        x[i].setAttribute("class", 'fas fa-check-circle');
                    
                    
                    for(var i=0,n=checkboxes.length;i<n;i++)
                    
                    check1[i].className = 'btn btn-success active';
                    
            
            
            }

}





</script>

<!doctype html>

<html>

<head>

<?php include('header.php');?>
<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
<script src="admin/js/jquery-3.3.1.min.js"></script>

<style type="text/css">
@media only screen and (max-width: 800px) {
    
    /* Force table to not be like tables anymore */
    #no-more-tables table{width: "100%"; border-spacing: 0px;} 
    #no-more-tables thead, 
    #no-more-tables tbody, 
    #no-more-tables th, 
    #no-more-tables td, 
    #no-more-tables tr { 
        display: block; 
    }
 
    /* Hide table headers (but not display: none;, for accessibility) */
    #no-more-tables thead tr { 
        position: absolute;
    }
 
    
    #no-more-tables td { 
        /* Behave  like a "row" */
        border: none;
    /*  border-bottom: 1px solid #eee; */
        position: relative;
        padding-left:30%; 
        white-space: normal;
        text-align:left;
    }
 
    #no-more-tables td:before { 
        /* Now like a table header */
        position:relative;
        /* Top/left values mimic padding */
        top: 6px;
        left: 6px;
        width: 100%; 
        padding-right: 0px; 
        white-space: nowrap;
        text-align:left;
        font-weight: bold;
    }
 
    /*
    Label the data
    */
    #no-more-tables td:before { content: attr(data-title); }
}


   
</style>
</head>

<style type="text/css">

    table{

        border-collapse: separate;

        border-spacing: 10px; /* Apply cell spacing */

    }

   

    table th, table td{

        padding: 5px; /* Apply cell padding */

    }

    

</style>





<body>

     <center>

    <div class="col-md-10">

<!--datepicker-->

    <!--form--><br>

<form action="edit.php" method="post">

    <div class="form-group form-inline">

        <label for="example-date-input" class="col-form-label">Date</label>

        

        <div class="col-md-3 col-sm-8">

             <input class="form-control" type="date"  value="<?php echo $d1;?>" name="date-input" required>

        </div>

    

    </div>

<!--datepicker-->  

<div class="card-block">

<blockquote class="card-blockquote">

    <div class="col-md-4">


    </div>

        

     <!-- roll number are created here--> 

    <div class="container border border-success">

    
<div id="no-more-tables">
            <table style="width:100%">

            

     <?php echo $list1; ?>

            

            </table>
</div>

        </div><br><br>

    </div>

    <!-- roll number are created here-->

</blockquote>

<button type="submit" class="btn btn-primary btn-lg">Save</button>

</div>



   

</form>

     </center>

</div>

</center>

<?php include('footer.php');?>


<script>
    $(function () {
    $('.button-checkbox').each(function () {

        // Settings
        var $widget = $(this),
            $button = $widget.find('button'),
            $checkbox = $widget.find('input:checkbox'),
            color = $button.data('color'),
            settings = {
                on: {
                    icon: 'far fa-check-circle'
                },
                off: {
                    icon: 'far fa-circle'
                }
            };

        // Event Handlers
        $button.on('click', function () {
            $checkbox.prop('checked', !$checkbox.is(':checked'));
            $checkbox.triggerHandler('change');
            updateDisplay();
        });
        $checkbox.on('change', function () {
            updateDisplay();
        });

        // Actions
        function updateDisplay() {
            var isChecked = $checkbox.is(':checked');

            // Set the button's state
            $button.data('state', (isChecked) ? "on" : "off");

            // Set the button's icon
            $button.find('.svg-inline--fa')
                .removeClass()
                .addClass('svg-inline--fa' + settings[$button.data('state')].icon);

            // Update the button's color
            if (isChecked) {
                $button
                    .removeClass('btn-danger')
                    .addClass('btn-' + color + ' active');
            }
            else {
                $button
                    .removeClass('btn-' + color + ' active')
                    .addClass('btn-danger');
            }
        }

        // Initialization
        function init() {

            updateDisplay();

            // Inject the icon if applicable
            if ($button.find('.svg-inline--fa').length == 0) {
                $button.prepend('<i id="chk" class="' + settings[$button.data('state')].icon + '" name="chk"></i> ');
            }
        }
        init();
    });
});
    
</script>

</body>

</html>
