?>
<html>
<head>
<title></title>

</head>
<br><br>
<body  text="#000000">

<center>
  <table width="80%" border="0" cellspacing="0" style="padding-top:50px;"  cellpadding="0">
    <tr>
    <h3 style="text-align:center">MONTHLY SALES REPORT</h3>
      <br></br>
        <h3 style="text-align:center"><?php echo date('F Y')?></h3>

       <br></br>

        </center>
        </tr>

    <table width="100%" border="0px" cellspacing="0" style="text-align:center; border-collapse:collapse;"  cellpadding="0">
    <tr>
        <th  style="border: 1px solid;" size="30">Date</th>
        <th  style="border: 1px solid;">Total Amount</th>
        <th style="border: 1px solid;">Daily Expenses</th>
        <th  style="border: 1px solid;">Balance</th>
        <th  style="border: 1px solid;">LCL</th>
        <th  style="border: 1px solid;">CMT</th>
        <th  style="border: 1px solid;">Outstanding Balance</th>
         <th style="color:#609;"><label id="selected_item"></label></th>
     </tr>
    <?php 

for($days = 1; $days <= $numDays; $days++)
{
    if($days < 10)
    {
        $days = '0'.$days;
    }
        $todate = $today_month.'-'.$days;

        $payment = mysql_query(" select * from invoice where payment_date = '".$todate."' AND status = 'PAID' GROUP BY payment_date"); 
        $pay = mysql_fetch_assoc($payment);



            //get sum

            $sum_q = mysql_query("SELECT SUM(payment) AS sumpayment FROM invoice WHERE (status = 'PAID' OR status = 'PARTIALLY PAID') AND payment_date = '".$todate."'");
            $sumpay = mysql_fetch_assoc($sum_q);

            //expenses
            $exp_q = mysql_query("SELECT SUM(Expenses) AS sumExp FROM expenses WHERE (Company = 'LCL' OR Company = 'CMT') AND Date = '".$todate."'");
            $sumexp = mysql_fetch_assoc($exp_q);

            //outstanding
            $out_q1 = mysql_query("SELECT SUM(outstanding) AS sumcharge FROM invoice  WHERE invoice_date = '".$todate."'");
            $sumout1 = mysql_fetch_assoc($out_q1);

            //$out_q2 = mysql_query("SELECT SUM(payment) AS sumpay FROM invoice WHERE outstanding = '".$todate."'");
            //$sumout2 = mysql_fetch_assoc($out_q2);

            //$outstandingtot = $sumout1['sumcharge'] - $sumout2['sumpay'];

            //LCL
            $lcl1 = mysql_query("SELECT SUM(charges) AS sumcharge FROM service WHERE collector = 'LCL' AND date = '".$todate."'");
            $sumlcl = mysql_fetch_assoc($lcl1);

            //CMT
            $cmt1 = mysql_query("SELECT SUM(charges) AS sumcharge FROM service WHERE collector = 'CMT' AND date = '".$todate."'");
            $sumcmt = mysql_fetch_assoc($cmt1);

            //balance
            $bal =($sumpay['sumpayment'] - $sumexp['sumExp']);


        }
        ?>



     </table>
     </table>

     <br></br>
      <div id="print"><input type="button" id="printButton" class="all_btn" value="Print">&nbsp;&nbsp;&nbsp;<input type="button" name="close" id="close" style="button-align:center" value="Close" class="all_btn" onClick="window.parent.location.href='report.php'"></div>

      <script>
$('#search_month').click( function(e) {$(this).off('click').AnyTime_picker({ format: "%Y-%m", labelTitle: "Select Date"}).focus(); } ).
keydown(
    function(e)
    {
        var key = e.keyCode || e.which;
        if ( ( key != 16 ) && ( key != 9 ) ) // shift, del, tab
        {
            $(this).off('keydown').AnyTime_picker().focus();
            e.preventDefault();
        }
    } );
</script>