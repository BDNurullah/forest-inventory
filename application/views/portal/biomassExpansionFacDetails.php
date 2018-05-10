

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
   /*background-color: #000000 !important;*/
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
<?php
   $lang_ses = $this->session->userdata("site_lang");
   ?>
<div class="col-sm-12 breadcump img-responsive">
   <div class="row">
      <div class="breadcump-wrapper">
         <div class="wrapper">
            <div style="font-size:25px;" class="breadcump_row"><?php echo $this->lang->line("biomass_expansion_factor"); ?>
            </div>
            <div class="breadcump_row"><a href="<?php echo base_url() ?>"><?php echo $this->lang->line("home"); ?></a> ><?php echo $this->lang->line("biomass_expansion_factor"); ?>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="col-md-12 page_content">
<a href="<?php echo site_url('data/biomassExpansionFacView'); ?>" class="btn btn-info" role="button"><< Back</a>
   <div class="col-md-12">
      <h2 style="font-family:Tahoma, Verdana, Segoe, sans-serif;">Emission factors</h2>
   </div>
   <div class="col-sm-12 bdy_des">
      <div style="float:right;">
         <form action='export/' id="export-form" method="POST">
         <input type='hidden' name='csrfmiddlewaretoken' value='EUSnAj1qQRRf6anXMDF1cWRSTLAwax2J' />
         <input type="hidden" name="query" id="export-query" />
         <input type="hidden" name="extension" id="export-extension" />
         <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false" >
            <span class="glyphicon glyphicon-download"></span> Export Results <span class="caret"></span>
            </button>
            <?php 
               foreach($biomassExpansionFacDetails as $row)
               {
               ?>
            <ul class="dropdown-menu" role="menu">
               <!--  <li><a href="#" id="export-txt">Download TXT (Tab Delimited UTF-16)</a></li> -->
               <li><a href="<?php echo site_url('Portal/biomassExpansionFacPdf/'.$row->ID_EF); ?>" id="export-json">Download PDF</a></li>
               <!-- <li><a href="#" id="export-xml">Download XML</a></li> -->
            </ul>
            <?php 
               }?>
         </div>
         <form>
      </div>
      <h3 style="font-family:Tahoma, Verdana, Segoe, sans-serif;">Record Details</h3>
      <div class="row">
         <div class="col-md-12">
            <br>
            <table class="table">
               <tr>
                  <th style="width:210px"> Emission Factor: </th>
                  <td> <b>
                     <?php echo $row->EmissionFactor;?>
                     </b>
                  </td>
               </tr>
               <tr>
                  <th> Value: </th>
                  <td> <?php echo $row->Value;?></td>
               </tr>
               <tr>
                  <th>Units: </th>
                  <td><?php echo $row->Unit;?></td>
               </tr>
               <tr>
                  <th>Lower confidence limit: </th>
                  <td><?php echo $row->Lower_Confidence_Limit;?></td>
               </tr>
               <tr>
                  <th>Upper confidence limit: </th>
                  <td><?php echo $row->Upper_Confidence_Limit;?></td>
               </tr>
               <tr>
                  <th>Type of parameter: </th>
                  <td><?php echo $row->Type_of_Parameter;?></td>
               </tr>
               <tr>
                  <th>Age Range: </th>
                  <td><?php echo $row->Age_yr;?></td>
               </tr>
               <tr>
                  <th>Height Range: </th>
                  <td><?php echo $row->Height_m;?></td>
               </tr>
               <tr>
                  <th>Volume Range: </th>
                  <td><?php echo $row->Volume_m3_ha;?></td>
               </tr>
                <tr>
                  <th>Basal Area: </th>
                  <td><?php echo $row->Basal_m2_ha;?></td>
               </tr>
            </table>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12">
            <br>
            <h3 class="section-header">Idendification</h3>
            <table class="table">
             <!--   <tr>
                  <th> Tree type: </th>
                  <td><?php echo $row->Tree_type;?> </td>
               </tr> -->
               <tr>
                  <th>Land Cover: </th>
                  <td> <?php echo $row->LandCover;?> </td>
               </tr>
            </table>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12">
            <br>
            <h3 class="section-header">
               Taxonomy
               <span style="color:#999;font-size:11px;font-weight:normal;">
               &nbsp;&nbsp;&nbsp;&nbsp;
               </span>
            </h3>
            <table class="table">
               <tr>
                  <th>Family:</th>
                  <th>Genus:</th>
                  <th>Species:</th>
                  <th>Subspecies:</th>
                  <th>Author:</th>
                  <th>Local Names:</th>
               </tr>
               <td >
                  <?php echo $row->Family;?>
               </td>
               <td>
                  <?php echo $row->Genus;?>
               </td>
               <td>
                  <?php echo $row->Species;?>
               </td>
               <td >NA</td>
               <td >None</td>
               <td><?php if($row->local_name!='') { ?>
                                   
                <?php echo $row->local_name;?>
                                   
                <?php } else { ?>
                <p>NA</p>
                                        
               <?php  } ?>
               </td>
               </tr>
            </table>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12">
            <br>
            <h3 class="section-header">
               Locations
               <span style="color:#999;font-size:11px;font-weight:normal;">
               &nbsp;&nbsp;&nbsp;&nbsp;
               </span>
            </h3>
           <table class="table">
      <thead>
        <tr>
         <?php 
         foreach($biomassExpansionFacDetails as $row)
         {
           ?>
           <th>FAO Biome:</th>
           <td><?php echo $row->FAOBiomes;?></td>
           <th>BFI Zone:</th>
           <td><?php echo $row->Zones;?></td>
           <th>Bangladesh Agroecological Zone:</th>
           <td><?php echo $row->AEZ_NAME;?></td>


         </tr>
         <?php 
       }?>
       <br>
       <tr class="bg-success">
        <th>Division</th>
        <th>District</th>
        <th>Upazila</th>
        <th>Union</th>
        <th>Latitute</th>
        <th>Longitute</th>
      </tr>
    </thead>
    <tbody>

     <?php
     $i = 1;
     foreach ($location as $row) {
       ?>
       <tr>
        <td ><?php echo $row->Division;?></td>
        <td><?php echo $row->District;?></td>
        <td><?php echo $row->THANAME;?></td>
        <td ><?php echo $row->UNINAME;?></td>
        <td><?php echo $row->LatDD;?></td>
        <td><?php echo $row->LongDD;?></td>
      </tr>
      <?php
      $i++;
    }
    ?>
  </tbody>

</table>
            <br>
            <div id="point_map_canvas"></div>
         </div>
      </div>
<?php 
foreach($biomassExpansionFacDetails as $row)
{
 ?>
      <div class="row">
         <div class="col-md-12">
            <br>
            <h3 class="section-header">Reference</h3>
            <table class="table">
               <tr>
                  <th> Reference: </th>
                  <td> 
                     <?php echo $row->Reference;?>
                  </td>
               </tr>
               <tr>
                  <th> Author: </th>
                  <td>
                     <?php echo $row->Author;?>
                  </td>
               </tr>
               <tr>
                  <th> Year: </th>
                  <td> 
                     <?php echo $row->Year;?>
                  </td>
               </tr>
            </table>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12">
            <br>
            <h3 class="section-header">Contributor</h3>
            <table class="table">
               <tr>
                  <th style="width:210px">Contributor:</th>
                  <td><?php echo $row->Contributor_name;?></td>
               </tr>
            </table>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12">
            <br>
            <h3 class="section-header">Dataset</h3>
            <table class="table">
               <tr>
                  <th style="width:210px">Dataset:</th>
                  <td>EF </td>
               </tr>
                 <?php 
             }?>

            </table>
         </div>
      </div>
   </div>
</div>
</div>

