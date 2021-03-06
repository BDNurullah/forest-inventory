
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/datatable/dataTables.bootstrap.css">
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>asset/datatable/jqueryDataTable.min.js">
</script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>asset/datatable/dataTableBootstrap.min.js">
</script>
<style type="text/css">
   .page_content{
   padding: 15px;
   background-color: white;
   margin-top: 15px;
   }
   .page_des_big_image{
   width: 100%;
   height: 300px;
   }
   .bdy_des{
   margin-top: 25px;
   }
   .breadcump{
   background-image: url("<?php echo base_url("resources/images/breadcump_image.jpg")?>");
   height: 103px;
   }
   .breadcump-wrapper{
 /*  background-color: #000000 !important;*/
   opacity: 0.7;
   width: 100%;
   height:100%;
   }
   .wrapper{
   padding:30px !important;
   color: #FFFFFF;
   font-weight: bold;
   }
   .breadcump_row a{
   color: white;
   }
</style>

<script type="text/javascript">
   $(document).on('keypress', '#title', function () {
   
   var pattern = /[0-9]+/g;
   var id = $(this).attr('id').match(pattern);
   $(this).autocomplete({
      source: "<?php echo site_url('Portal/get_title'); ?>",
      select: function (event, ui) {
          $("#title" + id).val(ui.item.id);
      }
   });
   });
   
   
     $(document).on('keypress', '#author', function () {
   
   var pattern = /[0-9]+/g;
   var id = $(this).attr('id').match(pattern);
   $(this).autocomplete({
      source: "<?php echo site_url('Portal/get_author'); ?>",
      select: function (event, ui) {
          $("#author" + id).val(ui.item.id);
      }
   });
   });
   
   
   $(document).on('keypress', '#keyword', function () {
   
   var pattern = /[0-9]+/g;
   var id = $(this).attr('id').match(pattern);
   $(this).autocomplete({
      source: "<?php echo site_url('Portal/get_keyword'); ?>",
      select: function (event, ui) {
          $("#keyword" + id).val(ui.item.id);
      }
   });
   });
   
   
   
   
   
   
</script>

<?php
   $lang_ses = $this->session->userdata("site_lang");
   ?>
<div class="col-sm-12 breadcump img-responsive">
   <div class="row">
      <div class="breadcump-wrapper">
         <div class="wrapper">
            <div style="font-size:25px;" class="breadcump_row"><?php echo $this->lang->line("library"); ?>
            </div>
            <div class="breadcump_row"><a href="<?php echo base_url() ?>"><?php echo $this->lang->line("home"); ?></a> ><?php echo $this->lang->line("library"); ?>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="col-md-12 page_content">
   <h3>Documents Search</h3>
   <div class="col-sm-12">
      <ul class="nav nav-tabs">
         <li class="active"><a data-toggle="tab" href="#home">Search</a></li>
      </ul>
      <div class="tab-content">
         <div id="home" class="tab-pane fade in active">
            <p> Search Documents by Title, Author, and Keyword.
               Example searches
               <br>
               Example searches: <a href="#"> Title: Chittagong university campus</a>,
               <a href="#">Author: Barua, S. and S. Haque </a>,
               <a href="#"> Keyword: Barua </a>
            </p>
          <!--   <form action="<?php echo site_url('portal/search_document');?>" method = "post"> -->
    
             <form action="<?php echo site_url('portal/searchSearchdocumentAll');?>" method = "get">
               <div class="col-md-3">
                  <div class="form-group">
                     <label>Title <span style="color:red;"></span></label>
                     <input type="text" class="form-control input-sm" name ="Title"  class ="title"  placeholder="Title" />
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-group">
                     <label>Author  <span style="color:red;"></span></label>
                     <input type="text" class="form-control input-sm" name ="Author"  class ="author" placeholder="Author" />
                  </div>
               </div>
               <div class="col-md-2">
                  <div class="form-group">
                     <label>Keyword  <span style="color:red;"></span></label>
                     <input type="text" class="form-control input-sm" name ="keyword"  class ="keyword" placeholder="Keywords" />
                  </div>
               </div>

                <div class="col-md-2">
                  <div class="form-group">
                     <label>Year  <span style="color:red;"></span></label>
                     <input type="text" class="form-control input-sm" name ="Year"  class ="Year" placeholder="Year" />
                  </div>
               </div>
               <div class="col-md-2">
                  <div class="form-group">
                     <br>
                     <input id="searchButton" style="float:right" class="btn btn-success" type="submit" value="Search">
                  </div>
               </div>
            </form>
         </div>
      </div><br>
      <div class="col-sm-12 bdy_des">
         <div class="row" style="background-color:#eee;border:1px solid #ddd;border-radius:4px;margin:0px 1px 20px 1px;">
            <div class="col-lg-6">
               <h4>Result count: <span id="summary-results-total">
                    <?php
                           if(isset($reference_count))
                           {
                         
                            echo count($reference_count); 
                            }
                            else if(isset($reference))
                            {
                              echo count($reference);
                            }
                            else 
                            { 
                             echo $this->db->count_all_results('reference');


                    
                            }
                            
                           ?>
                  </span> 
               </h4>
               <br><br>
            </div>
            <div class="col-lg-6">
               <h4> Search criteria</h4>
               <p> <?php
          $keyWord='';
          if(isset($_GET['keyword']))
          {
             $keyWord=$_GET['keyword'];
          }
         
          if($keyWord=='')
          {
             if(!empty($fieldNameValue)){
              $n=count($fieldNameValue);
              $i=0;
              foreach($fieldNameValue as $key=>$value)
              {
          $pieces = explode("/", $key);
          $fieldName= $pieces[0]; // piece1
          $keyWord= $pieces[1]; 
          //echo $fieldName;exit;// piece2
          if($i<$n-1)
          {
            $substitute="$keyWord=$value&";
          }
          else {
            $substitute="$keyWord=$value";
          }
          $sub=str_replace(' ','+',$substitute);
          //echo $actualUrl;
          $newUrl=str_replace($sub,'',$actualUrl);
          // $url=str_replace('','',$actualUrl);
          $i++;
          echo "<b> $fieldName </b> : $value "."<a href='$newUrl'>Remove Filter</a> <br>";
        }
          }
          else{
        echo "No criteria - All results are shown";
      }
    //   echo "<pre>";
    // print_r($fieldNameValue);exit();
           

      }
      else 
      {

        $url=site_url('portal/viewLibraryPage');
        echo "Keyword: $keyWord <a href='$url'>Remove Filter</a>";
      }
      
      ?></p>
            </div>
         </div>
         <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                  <td><center>Library</center></td>
                </tr>
              </thead>
            <?php
               $pdf_values=".pdf";
               foreach($reference as $row)
                 
               {
                 ?>
                 <tr>
                   <td>
            <h4><?php echo $row->Title;?></h4>
            <?php
                           if (empty($row->URL)) {
                             ?>
                              <p><a href="<?php echo base_url('resources/pdf/'.$row->PDF_label.$pdf_values);?>" target="_blank"><img src="<?php echo base_url('resources/images/pdf.gif')?>" alt="logo"/> Click here to download this documents or view </a>
                               <p>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row->Author;?></p>
                               <?php
                           }else{ ?>
                             <p><a href="<?php echo $row->URL;?>" target="_blank">   <i class="glyphicon glyphicon-link"></i>  Click here to get the document </a>
                            <!--  <p><?php echo $row->Title;?></p> -->
                              <p>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row->Author;?></p>
                                  <?php 
                            }
                            
                           ?>
                            </td>
                    </tr>
              
         
            <?php
               }?>
         <!--    <p><?php echo $links; ?></p> -->
     
         </table>

           <script>
                $(document).ready(function() {
                  $('#example').dataTable( {
                    "searching": false,
                    "bLengthChange": false,
                    "pageLength": 20,
                    "bSort" : false
                    

                  } );
                } );
                </script>
      </div>
   </div>
</div>

