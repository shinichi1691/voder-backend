<?php
   // var_dump($bankInfo);
   if(!isset($_GET['page'])){
        $page = 1;
    }else{
        $page = $_GET['page'];
    }
    //var_dump($listTransaction);
    $current_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

?>
<script>
    function confirmDelete(idTransaction){
        var url = "<?php echo base_url().'admin/verifypartner/deletetransaction/'?>"+idTransaction + "/<?php echo $partner->partnerID ?>";
        $("#delete_confirm").attr('href', url);
    }
    function changeTotal(transactionID){
        var nTotal = document.getElementById("change_total_"+transactionID).value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange=function()
          {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
            }
          }
        xmlhttp.open("POST","<?php echo base_url().'admin/editTotalTransaction'?>",true);
        xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xmlhttp.send("transactionID="+transactionID+"&total="+nTotal);
        
		var html = "<span id='edit_total_"+transactionID+"' >"+nTotal+"</span>";
		document.getElementById("example"+transactionID).innerHTML = html;
		document.getElementById("btnChangeTotal"+transactionID).style.display = "none";
		document.getElementById("btnEditTotal"+transactionID).style.display = "";
	}
	function editTotal(transactionID){	
	   
		var nTotal = document.getElementById("edit_total_"+transactionID);
		var html = "<input type='text' id='change_total_"+transactionID+"' class='form-control' value='"+nTotal.innerHTML+"'>";
		document.getElementById("example"+transactionID).innerHTML = html;
		
		document.getElementById("btnChangeTotal"+transactionID).style.display = "";
		document.getElementById("btnEditTotal"+transactionID).style.display = "none";
	}
 </script>
 <div class="col-md-12" id="content">
   <div class="row" id="content-top">
        <div class="col-md-1" style="padding-top: 40px;">
          <a href="<?php echo base_url().'admin?tab_active=0' ?>"><img src="<?php echo base_url().'assets/icon_arrow_back.png';?>" /></a>
        </div>
        <div class="col-md-2">
          <img width="110" height="110" src="<?php if($partner->image != null && $partner->image != ''){echo base_url().$partner->image;} else { echo  base_url().'image/default.jpg' ;}?>" />
        </div>
        <div class="col-md-8">
            <p style="color: #4dd6ce; margin:0px;font-size: 30px;"><b><?php echo $partner->firstName.' '.$partner->lastName ?></b></p>
            <p style="margin-bottom: 5px;">Email: <?php echo $partner->email ?></p>
            <p style="margin-bottom: 5px;">Phone: <?php echo $partner->phone ?></p>
            <p style="margin-bottom: 5px;">Address: <?php echo $partner->address ?></p>
        </div>
    </div> 
    <div class="row" id="content-top1" >
    <div class="col-md-2">
        <p>Bank Account Name:</p>
        <p>Bank Name:</p>
    </div>
    <div class="col-md-2" >
        <p><?php if($bankInfo!= null) echo $partner->firstName.' '.$partner->lastName ?></p>
        <p><?php if($bankInfo!= null) echo $bankInfo->name ?></p>
    </div>
    <div class="col-md-2">
        <p>Bank Numer</p>
        <p>BSB:</p>
    </div>
    <div class="col-md-2">
        <p><?php if($bankInfo!= null) echo $bankInfo->number ?></p>
        <p><?php if($bankInfo!= null) echo $bankInfo->bsb ?></p>
    </div>
    <div class="col-md-3 col-md-offset-1" id="div_search">
       <form role="form" method="get" action="<?php echo base_url().'admin/partnertransaction/'.$partner->partnerID ;?>" id="pa_search">
       <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon"><img src="<?php echo base_url() ?>assets/icon_search.png"/></div>
              <input type="text" class="form-control" name="pa_tr_keyword" id="pa_date_keyword" placeholder="Search" >
              <div class="input-group-addon" id="pa_del_search"></div>
            </div>
        </div>
        </form>
        <a href="<?php echo base_url().'admin/partner/'.$partner->partnerID ?>" ><button class="btn btn-default">Menu</button></a>
    </div>        
    </div> 
    <div class="row" id="content-mid">
    <?php if($business != null) { ?>
       <table class="table table-bordered">
            <tr id="tbl_header">
                <td><b>Transaction ID</b></td>
                <td><b>Date time</b></td>
                <td><b>Description</b></td>
                <td><b>Note</b></td>
                <td><b>Payment Method</b></td>
                <td><b>Total</b></td>
                <td><b>Funtions</b></td>
            </tr>
       <?php if($listTransaction != null){ for($i=8*($page-1);$i<sizeof($listTransaction);$i++){ if($i == 8*$page){ break;} $row = $listTransaction[$i]; ?>
            <tr>
                <td><?php echo $row->transactionID?></td>
                <td><?php echo $row->dateTime;?></td>
                <td>
                <?php $listItem = $row->description;
                      for($j = 0; $j<sizeof($listItem);$j++){
                        echo "<p>".$listItem[$j]->title." x ".$listItem[$j]->quantity."<p>";
                    }
                ?>
                </td>
                <td><?php echo $row->note;?></td>
                <td><?php echo $row->paymentMethod;?></td>
                <td>
                    <div class="form-group form-inline" id="<?php echo 'example'.$row->transactionID ; ?>" name="example">			
                        <span id="<?php echo 'edit_total_'.$row->transactionID ; ?>"><?php echo $row->totalCost;?></span>				
                    </div>                    
                </td>
                <td>
                    <a href="#" ><img data-toggle="modal" data-target="#myModal" onclick="confirmDelete(<?php echo $row->transactionID ?>)" style="padding-right: 10px;"src="<?php echo base_url()?>assets/icon_delete.png"/></a><button class="btn btn-default" style="display: none;" id="<?php echo 'btnChangeTotal'.$row->transactionID ; ?>" onclick="changeTotal(<?php echo $row->transactionID ;?>)">change</button>
                    <a href="#"><img id="<?php echo 'btnEditTotal'.$row->transactionID ; ?>" onclick="editTotal(<?php echo $row->transactionID ;?>)"src="<?php echo base_url()?>assets/icon_edit.png"/></a>
                </td>
            </tr>
       <?php }} ?>
       </table>
       <?php } else { ?>
            <p style="text-align: center;">No have business</p>
        <?php }  ?>
    </div>
    <div class="row" id="content-bottom">
        <?php 
            if($listTransaction != null){
                if(sizeof($listTransaction)%8 != 0){
                     $tmp = 1 + sizeof($listTransaction)/8;
                     $numberpage = (int)$tmp;
                }else{
                     $tmp = sizeof($listTransaction)/8;
                     $numberpage = (int)$tmp;
                }
                if($numberpage >= 5){
                    if($page <= 5){
                        $minpage = 1;
                        $maxpage = 5;
                    }else if($page >= $numberpage-2){
                        $minpage = $numberpage-4;
                        $maxpage = $numberpage;
                    }else{
                        $minpage = $page - 2;
                        $maxpage = $page + 2;
                    }            
                }else{
                    $minpage = 1;
                    $maxpage = $numberpage;
                }
            }else{
                $minpage = 1;
                $maxpage = 1;
                $numberpage = 0;
            }
           
            
        ?>
        <nav>
          <ul class="pagination">
            <li <?php $back = $page - 1; if($back == 0) echo "class='disabled'"; ?>><?php if($back > 0){ echo "<a href='".base_url().'admin/partnertransaction/'.$partner->partnerID.'?tab_active=0&page='.$back."'>";}?><span aria-hidden="true"><img src="<?php echo base_url().'assets/arrow_page_back.png';?>" /></span><?php if($back > 0){ echo "</a>";} ?></li>
            <?php for($j = $minpage;$j<$maxpage+1;$j++){ ?>
            <li <?php if($j == $page)  echo "class='active'";?>><a href="<?php echo base_url().'admin/partnertransaction/'.$partner->partnerID.'?tab_active=0&page='.$j ; ?>"><?php echo $j; ?></a></li>
            <?php } ?>
            <li <?php $next = $page+1; if($next > $numberpage) echo "class='disabled'"; ?>><?php if($next <= $numberpage){ echo "<a href='".base_url().'admin/partnertransaction/'.$partner->partnerID.'?tab_active=0&page='.$next."'>";}?><span aria-hidden="true"><img src="<?php echo base_url().'assets/arrow_page_next.png';?>" /></span><?php if($next <= $numberpage){ echo "</a>";} ?></li>
          </ul>
        </nav>
    </div> 
    
    <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-body" style="text-align: center;">
               <p><h3>Are you sure want to delele this transaction ?</h3></p>
              </div>
              <div class="modal-footer" style="text-align: center;">
                <a id="delete_confirm" href="#"><button type="button" class="btn submit">YES</button></a>
                <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
              </div>
            </div>
          </div>
        </div>                      
</div>      