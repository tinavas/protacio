<? include "../../myDatabase.php" ?>
<? include "../../myDatabase4.php" ?>
<? $ro = new database() ?>
<? $ro4 = new database4() ?>
<? $ro4->inventory_list("supplies") ?>
<!doctype html>
<html>
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="../../jquery-2.1.4.min.js"></script>
	<link rel="stylesheet" href="../../bootstrap-3.3.6/css/bootstrap.css"></link>
	<script src="../../bootstrap-3.3.6/js/bootstrap.js"></script>

	<script>
		<? foreach($ro4->inventory_list_inventoryCode() as $inventoryCode) { ?>
			$(document).on("click","#removeBtn<? echo $inventoryCode ?>",function(){
				$.post("medicine-new-delete.php",{inventoryCode:<? echo $inventoryCode ?>},function(){
					$("#myTable").load("supplies-new.php #myTable");
				});
			});

			$(document).on("click","#updateBtn<? echo $inventoryCode ?>",function(){

				var inventoryCode = <? echo $inventoryCode ?>;
				var description = $("#description<? echo $inventoryCode ?>").val();
				var quantity = $("#quantity<? echo $inventoryCode ?>").val();
				var unitcost = $("#unitcost<? echo $inventoryCode ?>").val();
				var price = $("#price<? echo $inventoryCode ?>").val();

				var myData = {
					"inventoryCode":inventoryCode,
					"description":description,
					"quantity":quantity,
					"unitcost":unitcost,
					"price":price
				}

				$.post("supplies-new-update.php",myData,function(){
					$("#myTable").load("supplies-new.php #myTable");
				});
			});

		<? } ?>
	</script>

	</head>
	<body>
		
	<div class="container">
		<h3>Supplies</h3>	
		<table id="myTable" class="table table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th>Stock#</th>
					<th>Description</th>
					<th>QTY</th>
					<th>Unitcost</th>
					<th>Price</th>
					<th>&nbsp;</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<? foreach($ro4->inventory_list_inventoryCode() as $inventoryCode) { ?>
					<tr>
						<td>&nbsp;<? echo $inventoryCode ?></td>
						<td>&nbsp;<? echo $ro->selectNow("inventory","stockCardNo","inventoryCode",$inventoryCode) ?></td>
						<td>&nbsp;<? echo $ro->selectNow("inventory","description","inventoryCode",$inventoryCode) ?></td>
						<td>&nbsp;<? echo $ro->selectNow("inventory","quantity","inventoryCode",$inventoryCode) ?></td>
						<td>&nbsp;<? echo $ro4->number_format($ro->selectNow("inventory","suppliesUNITCOST","inventoryCode",$inventoryCode)) ?></td>
						<td>&nbsp;<? echo $ro4->number_format($ro->selectNow("inventory","unitcost","inventoryCode",$inventoryCode)) ?></td>
						<td><input type="button" class="btn btn-success" data-toggle="modal" data-target="#updateModal<?php echo $inventoryCode ?>" value="Update"></td>
						<td><input type="button" class="btn btn-danger" data-toggle="modal" data-target="#removeModal<?php echo $inventoryCode ?>" value="Remove"></td>
					</tr>
				<? } ?>
			</tbody>
		</table>

		<? foreach($ro4->inventory_list_inventoryCode() as $inventoryCode) { ?>
		<!-- Modal -->
		<div id="removeModal<?php echo $inventoryCode ?>" class="modal fade" role="dialog">
		  <div class="modal-dialog">

		    <!-- Modal content-->
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">Modal Header</h4>
		      </div>
		      <div class="modal-body">
		        <p>Delete <b><? echo $ro->selectNow("inventory","description","inventoryCode",$inventoryCode) ?></b>?</p>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-success" data-dismiss="modal">Cancel Remove</button>
		        <button type="button" id="removeBtn<? echo $inventoryCode ?>" class="btn btn-danger" data-dismiss="modal">Confirm Remove</button>
		      </div>
		    </div>

		  </div>
		</div>
		<? } ?>


		<? foreach($ro4->inventory_list_inventoryCode() as $inventoryCode) { ?>
		<!-- Modal -->
		<div id="updateModal<? echo $inventoryCode ?>" class="modal fade" role="dialog">
		  <div class="modal-dialog">

		    <!-- Modal content-->
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">Modal Header</h4>
		      </div>
		      <div class="modal-body">
		        <div class="container">
		        	<div class="row">
			        	<div class="col-md-5">
			        		<div class="form-group">
			        			<label>Description</label>
			        			<input type="text" id="description<? echo $inventoryCode ?>" class="form-control" value="<? echo $ro->selectNow('inventory','description','inventoryCode',$inventoryCode) ?>">
			        		</div>
			        	</div>
		        	</div>
		        	<div class="row">
			        	<div class="col-md-2">
			        		<div class="form-group">
			        			<label>Quantity</label>
			        			<input type="text" id="quantity<? echo $inventoryCode ?>" class="form-control" value="<? echo $ro->selectNow('inventory','quantity','inventoryCode',$inventoryCode) ?>">
			        		</div>
			        		<div class="form-group">
			        			<label>Unitcost</label>
			        			<input type="text" id="unitcost<? echo $inventoryCode ?>" class="form-control" value="<? echo $ro->selectNow('inventory','suppliesUNITCOST','inventoryCode',$inventoryCode) ?>">
			        		</div>
			        		<div class="form-group">
			        			<label>Price</label>
			        			<input type="text" id="price<? echo $inventoryCode ?>" class="form-control" value="<? echo $ro->selectNow('inventory','unitcost','inventoryCode',$inventoryCode) ?>">
			        		</div>
			        	</div>
		        	</div>

		        </div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-success" data-dismiss="modal">Cancel Update</button>
		        <button type="button" id="updateBtn<? echo $inventoryCode ?>" class="btn btn-danger" data-dismiss="modal">Confirm Update</button>
		      </div>
		    </div>

		  </div>
		</div>
		<? } ?>


	</div>

	</body>
</html>