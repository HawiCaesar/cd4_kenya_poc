<div style="float:center">
  <script>
    function date_filter(type,value){
      $.ajax({
          type:"POST",
          async:false,
          data:"type="+type+"&value="+value,
            url:"<?php echo base_url()."quality/quality/quality_date_filter_post"; ?>",  
            success:function(data) {
                  $("#exists").val(data);           
              }
      });
    }
    function date_filter_custom(){
      var from  = "";
      var to    = "";
      from      =  $("#filterfromdate").val();
      to        =  $("#filtertodate").val();
      
      if(to!="" && from!=""){
        var fromdate  = $.datepicker.parseDate("yy-mm-dd",  from);
        var todate    = $.datepicker.parseDate("yy-mm-dd",  to);
        if(todate>fromdate){
          var type  = "Custom";
          var value = {from:from,to:to};
          var value_json =  JSON.stringify(value, null, 2);

          date_filter(type,value_json);

          location.reload();
        }else{alert("To (Date) must be greater than From (Date)");}
      }else{
        alert("No dates Selected!");
      }
    }
  </script>
    <table align="center" border="1" style="font-size:10px" >
    <tr style="background: rgba(211, 220, 227, 0.42);">
      <td style="width: 43.5%;" class="filter">
        <ul class="tabbed" id="network-tabs"  >
          <li>
            <span>Period:  |</span>
          </li>
          <li class = "<?php 
                        if($filter_used=="All"){
                          echo "current";
                        }else{echo "tab";}
                      ?>">
            <span> &nbsp&nbsp <a href="" onclick="date_filter('All','all')">All Time</a> &nbsp&nbsp |</span>
          </li>
          <li class = "<?php 
                        if($filter_used=="Periodic" && $date_filter_desc=="The Last 2 Calendar Months"){
                          echo "current";
                        }else{echo "tab";}
                      ?>">
            <span> &nbsp&nbsp <a href="" onclick="date_filter('Periodic',6)">Last 2 Months</a> &nbsp&nbsp |</span>
          </li>
          <li class = "<?php 
                        if($filter_used=="Periodic" && $date_filter_desc=="The Last 1 Calendar Months"){
                          echo "current";
                        }else{echo "tab";}
                      ?>">
            <span> &nbsp&nbsp <a href="" onclick="date_filter('Periodic',3)">Last 1 Month</a> &nbsp&nbsp |</span>
          </li>
          <li class = "<?php 
                        if($filter_used=="Periodic" && $date_filter_desc=="The Last Week"){
                          echo "current";
                        }else{echo "tab";}
                      ?>">
            <span> &nbsp&nbsp <a href="" onclick="date_filter('Periodic',2)">Last Week</a> &nbsp&nbsp |</span>
          </li>
          <li class = "<?php 
                        if($filter_used=="Default" && $date_filter_desc=="This Week"){
                          echo "current";
                        }else{echo "tab";}
                      ?>">
            <span> &nbsp&nbsp <a href="" onclick="date_filter('Default',0)">This Week</a> &nbsp&nbsp |</span>
          </li>
          <li style="width: 22%;" class = "<?php 
                        if($filter_used=="Custom"){
                          echo "current";
                        }else{echo "tab";}
                      ?>">
            <div>
              <div>
                <span> &nbsp&nbsp <a onClick="toggleHideCustomize()" href = "javascript:void(null);">Customize dates</a> &nbsp&nbsp </span>
                <div >
                  <div id = "customize" class="mycontainer" style="width: 19%; padding-bottom: 9px;border-bottom: 4px solid #D0D0D0;position: fixed;z-index: 20; filter:alpha(opacity=90); opacity:.93;background-color: white;display: none;">                
                    <button type="button" class="close" style="margin:2px;margin-bottom:9px;" onClick="toggleHideCustomize()" >×</button>
                    <div class="input-group" style="width: 100%;margin:2px;margin-top:19px;">
                      <span class="input-group-addon" style="width: 40%;">From :</span>
                      <div class="input-group date" id="from_div" data-date="" data-date-format="dd-mm-yyyy">
                        <input id="filterfromdate" class="span2" size="22%" type="text" style="height: 28px;" value="">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                      </div>
                    </div>
                    <div class="input-group" style="width: 100%;margin:2px;margin-top:9px;">
                      <span class="input-group-addon" style="width: 40%;">To :</span>
                      <div class="input-group date" id="from_div" data-date="" data-date-format="dd-mm-yyyy">
                        <input id="filtertodate" class="span2" size="22%" type="text" style="height: 28px;" value="">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                      </div>
                    </div>
                    <button name="reset" onclick="date_filter_custom()" type="button" style="width: 100%;margin:2px;margin-top:9px;" class="btn btn-default btn-minii"><i class="glyphicon glyphicon-search"></i> Filter</button>               
                   </div>
                </div>
              </div>
            </div>
          </li>
        </ul>
      </td>
      <!--  -->
    </tr>
  </table>