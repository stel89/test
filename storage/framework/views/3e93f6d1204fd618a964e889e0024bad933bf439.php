<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    
					
					<h1><center> Сегодняшние котировки </h1>
					<table class="table">
					<caption><center>Покупка</center></caption>
					<tr><th>Банк</th><th>USD</th><th>EUR</th><th>RUB</th></tr>
					<tr><td>Интербанк</td><td><?php echo e($results->USD->interbank->buy); ?></td><td><?php echo e($results->EUR->interbank->buy); ?></td><td><?php echo e($results->RUB->interbank->buy); ?></td></tr>
					<tr><td>НБУ</td><td><?php echo e($results->USD->nbu->buy); ?></td><td><?php echo e($results->EUR->nbu->buy); ?></td><td><?php echo e($results->RUB->nbu->buy); ?></td></tr>
					</table><p>
					
					<table class="table">
					<caption>Продажа</caption>
					<tr><th>Банк</th><th>USD</th><th>EUR</th><th>RUB</th></tr>
					<tr><td>Интербанк</td><td><?php echo e($results->USD->interbank->sell); ?></td><td><?php echo e($results->EUR->interbank->sell); ?></td><td><?php echo e($results->RUB->interbank->sell); ?></td></tr>
					<tr><td>НБУ</td><td><?php echo e($results->USD->nbu->sell); ?></td><td><?php echo e($results->EUR->nbu->sell); ?></td><td><?php echo e($results->RUB->nbu->sell); ?></td></tr>
					</table>
					<p>
					<form class="form-inline" action="javascript:void(0);" name="val">
					<caption>
					Сравнить динамику изминений курса  
					</caption>
					<div class="form-group">
					<select class="selectpicker" data-width="120px" id="sel1">
					<option value="1">USD и EUR</option>
					<option value="2">USD и RUB</option>
					<option value="3">EUR и RUB</option>
					</select>
					</div>
					в банке
					<div class="form-group">
					<select class="selectpicker" data-width="100px"  id="sel2">
					<option value="1">НБУ</option>
					<option value="2">Интербанк</option>
					</select>
					</div>
					за 
					<div class="form-group">
					<select class="selectpicker" data-width="100px" id="sel3">
					<option value="1">3 дня</option>
					<option value="2">Неделя</option>
					<option value="3">Месяц</option>
					</select>
					</div>
					<button type="button" class=" btn btn-default compare">Cравнить</button>
					</form>
					<p>

					<div id="chart_div"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
google.charts.load('current', {packages: ['corechart', 'line']});
google.charts.setOnLoadCallback(drawBasic);

var chart;

   function drawBasic() {

      var data = new google.visualization.DataTable();
      data.addColumn('number', ' ');
      data.addColumn('number', ' ');
	

      data.addRows([
        
      ]);

      var options = {
        hAxis: {
          title: 'Дата'
        },
        vAxis: {
          title: 'Цена'
        }
      };

      chart = new google.visualization.LineChart(document.getElementById('chart_div'));

      chart.draw(data, options);
    }

$('document').ready(function()
{
	$('.compare').click(function()
	{

		
	  var data = new google.visualization.DataTable();
      data.addColumn('string', 'X');
	   if($('#sel1').val() == 1)
	   {
      data.addColumn('number', 'USD');
	  data.addColumn('number', 'EUR');
	   }
	   else if($('#sel1').val() == 2)
	   {
		   data.addColumn('number', 'USD');
	       data.addColumn('number', 'RUB');
	   }
	    else if($('#sel1').val() == 3)
	   {
		   data.addColumn('number', 'EUR');
	       data.addColumn('number', 'RUB');
	   }
	  
	  var nbu_usd_b =[];
	  var nbu_usd_s =[];
	  var nbu_eur_b =[];
	  var nbu_eur_s =[];
	  var nbu_rub_b =[];
	  var nbu_rub_s =[];
	  var int_usd_b =[];
	  var int_usd_s =[];
	  var int_eur_b =[];
	  var int_eur_s =[];
	  var int_rub_b =[];
	  var int_rub_s =[];
	  var date_n = [];
	  
	  <?php for($i=0; $i < 30 ; $i++): ?>
	  nbu_usd_b[<?php echo e($i); ?>] = <?php echo e($result[$i]->USD->nbu->buy); ?>;
	  nbu_usd_s[<?php echo e($i); ?>] = <?php echo e($result[$i]->USD->nbu->sell); ?>;
	  nbu_eur_b[<?php echo e($i); ?>] = <?php echo e($result[$i]->EUR->nbu->buy); ?>;
	  nbu_eur_s[<?php echo e($i); ?>] = <?php echo e($result[$i]->EUR->nbu->sell); ?>;
	  nbu_rub_b[<?php echo e($i); ?>] = <?php echo e($result[$i]->RUB->nbu->buy); ?>;
	  nbu_rub_s[<?php echo e($i); ?>] = <?php echo e($result[$i]->RUB->nbu->sell); ?>;
	  int_usd_b[<?php echo e($i); ?>] = <?php echo e($result[$i]->USD->interbank->buy); ?>;
	  int_usd_s[<?php echo e($i); ?>] = <?php echo e($result[$i]->USD->interbank->sell); ?>;
	  int_eur_b[<?php echo e($i); ?>] = <?php echo e($result[$i]->EUR->interbank->buy); ?>;
	  int_eur_s[<?php echo e($i); ?>] = <?php echo e($result[$i]->EUR->interbank->sell); ?>;
	  int_rub_b[<?php echo e($i); ?>] = <?php echo e($result[$i]->RUB->interbank->buy); ?>;
	  int_rub_s[<?php echo e($i); ?>] = <?php echo e($result[$i]->RUB->interbank->sell); ?>; 
	  date_n[<?php echo e($i); ?>] = '<?php echo e($n_date[$i]); ?>';
		<?php endfor; ?>

		var count_d;
		
		if ($('#sel3').val() == 1) count_d =3;
		if ($('#sel3').val() == 2) count_d =7;
		if ($('#sel3').val() == 3) count_d =30;

		
	  for(var i=count_d; i > 0 ; i--)
	  {
		  if($('#sel2').val() == 1)
		  {
			 if($('#sel1').val() == 1)	{data.addRow([date_n[i], nbu_usd_b[i], nbu_eur_b[i]]);}
			 else if($('#sel1').val() == 2) {data.addRow([date_n[i], nbu_usd_b[i], nbu_rub_b[i]]);}
			 else if($('#sel1').val() == 3) {data.addRow([date_n[i], nbu_eur_b[i], nbu_rub_b[i]]);}
			 else alert('ОМГ ФЕЙЛ');
	      }
	   else 
	   {
		  {
		 if($('#sel1').val() == 1)	{data.addRow([date_n[i], int_usd_b[i], int_eur_b[i]]);}
			 else if($('#sel1').val() == 2) {data.addRow([date_n[i], int_usd_b[i], int_rub_b[i]]);}
			 else if($('#sel1').val() == 3) {data.addRow([date_n[i], int_eur_b[i], int_rub_b[i]]);}
			 else alert('ОМГ ФЕЙЛ2');
	   }
	  }
	   }
	  
	   var options = {
        hAxis: {
          title: 'Дата'
		  
        },
        vAxis: {
          title: 'Цена',
		  minValue: 24
        }
      };
	 chart.draw(data, options);
	});
});

</script>	
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>